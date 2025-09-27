<?php
session_start();

// Include database connection
include("../config/db.php");

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize user input to prevent SQL injection
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    // Basic validation
    if (!empty($name) && !empty($email) && !empty($message)) {

        // Insert data into database
        $query = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";
        $result = mysqli_query($con, $query);

        if ($result) {
            // Success message
            $_SESSION['success'] = "Thank you! Your message has been sent successfully.";
        } else {
            // Error message
            $_SESSION['error'] = "Oops! Something went wrong. Please try again.";
        }

    } else {
        $_SESSION['error'] = "All fields are required!";
    }

    // Redirect back to contact page
    header("Location: contact.php");
    exit();
}
?>
