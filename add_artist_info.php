<?php
require_once 'dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $artist_name = $_POST['artist_name'];
  $album_title = $_POST['album_title'];

  $db->beginTransaction();

  try {
    // artisti
    $stmt = $db->prepare('INSERT INTO artist (Name) VALUES (:name)');
    $stmt->bindValue(':name', $artist_name);
    $stmt->execute();
    $artist_id = $db->lastInsertId();

    // albumi
    $stmt = $db->prepare('INSERT INTO album (Title, ArtistId) VALUES (:title, :artist_id)');
    $stmt->bindValue(':title', $album_title);
    $stmt->bindValue(':artist_id', $artist_id);
    $stmt->execute();
    $album_id = $db->lastInsertId();

    // biisi
    $tracks = $_POST['tracks'];
    foreach ($tracks as $track) {
      $stmt = $db->prepare('INSERT INTO track (Name, AlbumId) VALUES (:name, :album_id)');
      $stmt->bindValue(':name', $track);
      $stmt->bindValue(':album_id', $album_id);
      $stmt->execute();
    }

    $db->commit();

    echo 'Artisti, albumi ja biisien lisäys onnistui!';
  } catch (PDOException $e) {
    $db->rollBack();

    echo 'Virhe: ' . $e->getMessage();
  }
} else {
  echo 'Invalid request method.';
}