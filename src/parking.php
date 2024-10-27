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

    // Check for empty fields
    if (empty($vehicleNumber) || empty($selectedSpot)) {
        header("Location: ../public/parking.html?status=error&message=All fields are required.");
        exit();
    }

    // Ensure database connection
    if (!$db) {
        die("Database connection error.");
    }

    // Connect to the reservations collection
    $reservationsCollection = $db->reservations;

    // Check if the selected spot is already reserved
    $existingReservation = $reservationsCollection->findOne(['spot' => $selectedSpot]);
    if ($existingReservation) {
        header("Location: ../public/parking.html?status=error&message=Spot is already reserved.");
        exit();
    }

    // Reserve the selected spot
    $reservationsCollection->insertOne([
        'username' => $username,
        'vehicle_number' => $vehicleNumber,
        'spot' => $selectedSpot,
        'timestamp' => new MongoDB\BSON\UTCDateTime(),
    ]);

    // Redirect with success status
    header("Location: ../public/parking.html?status=success&message=Spot reserved successfully.");
    exit();
}
