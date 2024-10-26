<?php
require __DIR__ . '/../config/database.php';

session_start();

if (!isset($_SESSION['user'])) {
    echo "Unauthorized access!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slotNumber = $_POST['slot_number'];
    $username = $_SESSION['user'];
    $time = new MongoDB\BSON\UTCDateTime();

    $collection = $client->selectDatabase('smart_parking_system')->parking_slots;

    // Reserve parking slot
    $result = $collection->insertOne([
        'slot_number' => $slotNumber,
        'user' => $username,
        'reserved_at' => $time,
    ]);

    if ($result->getInsertedId()) {
        echo "Parking slot reserved successfully!";
    } else {
        echo "Failed to reserve parking slot!";
    }
}
