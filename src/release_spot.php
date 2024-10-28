<?php
session_start();
require '../config/database.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../public/login.html");
    exit();
}

$username = $_SESSION['user'];
$spotId = trim($_POST['spot_id']);

$reservationsCollection = $db->reservations;
$releasedReservationsCollection = $db->released_reservations;

$reservation = $reservationsCollection->findOne(['username' => $username, 'spot' => $spotId, 'status' => 'reserved']);

if ($reservation) {
    $releasedReservationsCollection->insertOne([
        'username' => $reservation['username'],
        'vehicle_number' => $reservation['vehicle_number'],
        'spot' => $reservation['spot'],
        'timestamp' => $reservation['timestamp'],
        'release_time' => new MongoDB\BSON\UTCDateTime(),
    ]);

    $reservationsCollection->deleteOne(['username' => $username, 'spot' => $spotId]);

    echo "success";
} else {
    echo "Error: Spot not found or unauthorized";
}
exit();
