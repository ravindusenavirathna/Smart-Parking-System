<?php
require '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    $contactData = [
        'name' => $name,
        'email' => $email,
        'message' => $message,
        'submitted_at' => new MongoDB\BSON\UTCDateTime(),
    ];

    try {
        $contactsCollection = $db->contacts;
        $insertResult = $contactsCollection->insertOne($contactData);

        if ($insertResult->getInsertedCount() === 1) {
            echo "<script>alert('Message sent successfully!'); window.location.href = '../public/contact.html';</script>";
        } else {
            echo "<script>alert('Failed to send the message. Please try again.'); window.location.href = '../public/contact.html';</script>";
        }
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href = '../public/contact.html';</script>";
    }
} else {
    header("Location: ../public/contact.html");
    exit();
}
