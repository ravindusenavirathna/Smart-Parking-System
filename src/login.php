<?php
require __DIR__ . '/../config/database.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Access the users collection
    $collection = $client->selectDatabase('smart_parking_system')->users;

    // Find user by username
    $user = $collection->findOne(['username' => $username]);

    // Verify password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $username;
        echo "Login successful!";
    } else {
        echo "Invalid username or password!";
    }
}
