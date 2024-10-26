<?php
session_start();
require '../config/database.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../public/login.html"); // Redirect to login if not authenticated
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and get form inputs
    $vehicleNumber = trim($_POST['vehicle_number']);
    $selectedSpot = trim($_POST['selected_spot']);
    $username = $_SESSION['user']; // Logged-in user

    // Connect to the MongoDB 'reservations' collection
    $reservationsCollection = $db->reservations;

    // Check if the selected spot is already reserved
    $existingReservation = $reservationsCollection->findOne(['spot' => $selectedSpot]);
    if ($existingReservation) {
        echo "Sorry, this spot is already reserved. Please select a different spot.";
        exit();
    }

    // Reserve the parking spot by inserting data into the collection
    $reservationsCollection->insertOne([
        'username' => $username,
        'vehicle_number' => $vehicleNumber,
        'spot' => $selectedSpot,
        'timestamp' => new MongoDB\BSON\UTCDateTime(),
    ]);

    // Confirm the reservation and redirect back to the parking page
    header("Location: ../public/parking.html?status=success"); // Update URL with status message
    exit();
}
