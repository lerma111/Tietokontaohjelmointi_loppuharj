<?php

require_once('dbconnection.php');

// valitse tietokannasta poistettava id
$invoice_item_id = 1;


try {
    $stmt = $pdo->prepare("DELETE FROM invoice_item WHERE invoice_item_id = ?");
    $stmt->execute([$invoice_item_id]);
    echo "Invoice item poistettu!";
} catch (PDOException $e) {
    echo "Virhe: " . $e->getMessage();
}