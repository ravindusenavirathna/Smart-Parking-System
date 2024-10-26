<?php
session_start();
require '../config/database.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../public/login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehicleNumber = trim($_POST['vehicle_number']);
    $selectedSpot = trim($_POST['selected_spot']);
    $username = $_SESSION['user'];

    $reservationsCollection = $db->reservations;

    $existingReservation = $reservationsCollection->findOne(['spot' => $selectedSpot]);
    if ($existingReservation) {
        die("Sorry, this spot is already reserved.");
    }

    $reservationsCollection->insertOne([
        'username' => $username,
        'vehicle_number' => $vehicleNumber,
        'spot' => $selectedSpot,
        'timestamp' => new MongoDB\BSON\UTCDateTime(),
    ]);

    header("Location: ../public/parking.html?status=success");
    exit();
}
