<?php
$host = "127.0.0.1";   // host IP
$port = 3307;          // tumhara MySQL port
$user = "root";        // phpMyAdmin default user
$pass = "";            // agar tumne password set nahi kiya hai to blank
$db   = "online_quiz"; // database name

// Connection with port
$con = mysqli_connect($host, $user, $pass, $db, $port);

// Check connection
if (!$con) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>

