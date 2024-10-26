<?php
session_start();
require '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);

    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $userCollection = $db->users;

    $existingUser = $userCollection->findOne(['username' => $username]);
    if ($existingUser) {
        die("Username already exists. Please choose a different one.");
    }

    $userCollection->insertOne([
        'name' => $name,
        'username' => $username,
        'password' => $hashedPassword,
    ]);

    header("Location: ../public/login.html");
    exit();
}
