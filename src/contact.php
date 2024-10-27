<?php
require '../config/database.php'; // Assumes your MongoDB connection is set up here

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Prepare data to be inserted
    $contactData = [
        'name' => $name,
        'email' => $email,
        'message' => $message,
        'submitted_at' => new MongoDB\BSON\UTCDateTime(), // Store current time
    ];

    // Insert data into the 'contacts' collection
    try {
        $contactsCollection = $db->contacts; // Creates or references the 'contacts' collection
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
    // Redirect to the contact page if accessed directly
    header("Location: ../public/contact.html");
    exit();
}
