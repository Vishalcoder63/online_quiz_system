<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Quiz</title>
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <!-- Brand Logo -->
            <a class="navbar-brand d-flex align-items-center" href="/online_quiz_system/index.php">
                <img src="https://i.pinimg.com/736x/48/ff/34/48ff343800da6dd5588d4aae7989c607.jpg" 
     alt="Online Quiz Logo" 
     class="img-fluid me-2" 
     style="max-height:50px;">

            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Feedback</a></li>

                    <?php if(isset($_SESSION['student_id'])): ?>
                        <li class="nav-item"><a class="nav-link" href="student/login.php">Login</a></li>
                        <!-- Agar student login hai to yahan future me dashboard/profile link dal sakte ho -->
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="student/login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="student/register.php">Sign Up</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <main class="container mt-4">
