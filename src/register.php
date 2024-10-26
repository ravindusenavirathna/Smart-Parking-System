<?php
// Include database connection
require __DIR__ . '/../config/database.php';

session_start();

// Check if POST data is present
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Secure password hashing

    // Create a new database client
    $collection = $client->selectDatabase('smart_parking_system')->users;

    // Insert new user
    $result = $collection->insertOne([
        'username' => $username,
        'password' => $password,
    ]);

    if ($result->getInsertedId()) {
        echo "User registered successfully!";
    } else {
        echo "Registration failed!";
    }
}
