<?php

require_once('dbconnection.php');

// valitse tietokannasta tulostettava id
$artist_id = 1;

try {
    $stmt = $pdo->prepare("
        SELECT track.track_name 
        FROM track
        JOIN album ON album.album_id = track.album_id
        JOIN artist ON artist.artist_id = album.artist_id
        WHERE artist.artist_id = ?
    ");
    $stmt->execute([$artist_id]);

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($result);
} catch (PDOException $e) {
    echo "Virhe: " . $e->getMessage();
}