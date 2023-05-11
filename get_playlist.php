<?php

require_once('dbconnection.php');

// valitse tietokannasta tulostettava id
$playlist_id = 1;


try {
    $stmt = $pdo->prepare("SELECT name FROM playlist WHERE playlist_id = ?");
    $stmt->execute([$playlist_id]);
    $playlist_name = $stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT track.name, composer.name AS composer FROM playlist_track JOIN track ON playlist_track.track_id = track.track_id JOIN album ON track.album_id = album.album_id JOIN artist ON album.artist_id = artist.artist_id JOIN composer ON track.composer = composer.composer_id WHERE playlist_track.playlist_id = ?");
    $stmt->execute([$playlist_id]);
    $tracks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "$playlist_name\n";
    foreach ($tracks as $track) {
        echo "Kappale: {$track['name']}\n";
        echo "Säveltäjä: {$track['composer']}\n\n";
    }
} catch (PDOException $e) {
    echo "Virhe: " . $e->getMessage();
}