<?php

require_once('dbconnection.php');

// valitse tietokannasta poistettava id
$playlist_id = 1;


try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("DELETE FROM playlist WHERE playlist_id = ?");
    $stmt->execute([$playlist_id]);

    $stmt = $pdo->prepare("DELETE FROM playlist_track WHERE playlist_id = ?");
    $stmt->execute([$playlist_id]);

    $pdo->commit();

    echo "Soittolistan poisto onnistui!";
} catch (PDOException $e) {
    // virheen sattuessa peruuta toiminto
    $pdo->rollBack();
    echo "Virhe: " . $e->getMessage();
}