<?php
session_start();
require '../config/database.php';

$username = $_SESSION['user'] ?? null;
if (!$username) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit();
}

// Fetch the user's reserved spot
$userReservation = $db->reservations->findOne(['username' => $username], [
    'projection' => ['spot' => 1],
]);

$spot = $userReservation ? $userReservation['spot'] : null;

header('Content-Type: application/json');
echo json_encode(['reservedSpot' => $spot]);
