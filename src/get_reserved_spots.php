<?php
require '../config/database.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../public/login.html");
    exit();
}

$username = $_SESSION['user'];
$reservationsCollection = $db->reservations;
$releasedReservationsCollection = $db->released_reservations;

$reservedSpots = $reservationsCollection->find(['status' => 'reserved']);
$userReservedSpots = $reservationsCollection->find(['username' => $username, 'status' => 'reserved']);
$previousReservations = $releasedReservationsCollection->find(['username' => $username]);

$reservedSpotsArray = [];
$userReservedSpotsArray = [];
$previousReservationsArray = [];

foreach ($reservedSpots as $spot) {
    $reservedSpotsArray[] = $spot['spot'];
}

foreach ($userReservedSpots as $spot) {
    $userReservedSpotsArray[] = [
        'spot' => $spot['spot'],
        'vehicle_number' => $spot['vehicle_number'],
    ];
}

foreach ($previousReservations as $spot) {
    $previousReservationsArray[] = [
        'spot' => $spot['spot'],
        'vehicle_number' => $spot['vehicle_number'],
        'release_time' => $spot['release_time']->toDateTime()->format('Y-m-d H:i:s'),
    ];
}

// Return JSON response
echo json_encode([
    'reservedSpots' => $reservedSpotsArray,
    'userReservedSpots' => $userReservedSpotsArray,
    'previousReservations' => $previousReservationsArray,
]);
