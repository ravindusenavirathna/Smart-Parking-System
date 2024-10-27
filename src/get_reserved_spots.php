<?php
session_start();
require '../config/database.php';

if (!isset($_SESSION['user'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$username = $_SESSION['user'];
$reservationsCollection = $db->reservations;

// Get all reserved spots
$allReservedSpots = $reservationsCollection->find([], ['projection' => ['spot' => 1]]);
$reservedSpots = [];
foreach ($allReservedSpots as $reservation) {
    $reservedSpots[] = $reservation->spot;
}

// Get reserved spots for the logged-in user with vehicle numbers
$userReservations = $reservationsCollection->find(['username' => $username], ['projection' => ['spot' => 1, 'vehicle_number' => 1]]);
$userReservedSpots = [];
foreach ($userReservations as $reservation) {
    $userReservedSpots[] = [
        'spot' => $reservation->spot,
        'vehicle_number' => $reservation->vehicle_number,
    ];
}

echo json_encode(['reservedSpots' => $reservedSpots, 'userReservedSpots' => $userReservedSpots]);
exit();
