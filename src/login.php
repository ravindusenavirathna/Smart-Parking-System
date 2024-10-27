<?php
session_start();
require '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $userCollection = $db->users;
    $user = $userCollection->findOne(['username' => $username]);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $username;
        header("Location: ../public/parking.html");
    } else {
        header("Location: ../public/login.html?error=1"); // Redirect with error flag
    }
    exit();
}
