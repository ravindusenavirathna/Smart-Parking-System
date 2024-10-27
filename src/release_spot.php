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

// Verify the spot belongs to the user and then delete it
$reservation = $reservationsCollection->findOne(['username' => $username, 'spot' => $spotId]);
if ($reservation) {
    $reservationsCollection->deleteOne(['username' => $username, 'spot' => $spotId]);
    echo "success";
} else {
    echo "Error: Spot not found or unauthorized";
}
exit();
