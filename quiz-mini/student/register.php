<?php
include("../config/db.php");

session_start(); // ✅ session start add karo

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $pass  = mysqli_real_escape_string($con, $_POST['password']);

    // password ko encrypt karna (secure way)
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    // check if email already exists
    $check = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $message = "⚠️ Email already registered!";
    } else {
        $query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashed_pass', 'student')";
        if (mysqli_query($con, $query)) {
            
            // ✅ new user id nikaal lo
            $user_id = mysqli_insert_id($con);

            // ✅ auto login ke liye session set karo
            $_SESSION['student_id'] = $user_id;
            $_SESSION['student_name'] = $name;
            $_SESSION['student_email'] = $email;

            // ✅ direct redirect kar do dashboard ya home pe
            header("Location: dashboard.php");
            exit;

            // agar redirect nahi karna chaahte aur bas msg dikhana hai to
            // $message = "Registration successful! Welcome $name 🎉";
        } else {
            $message = " Error: " . mysqli_error($con);
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Registration</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        /* Full screen professional background image */
        body {
            background: url('background45.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }
    </style>
</head>
<body class="flex items-center justify-center">

    <!-- Glassmorphism Registration Card -->
    <div class="relative w-96 p-8 bg-white/70 backdrop-blur-md rounded-3xl shadow-xl border border-white/30 
                hover:scale-105 transition-transform duration-300">

        <!-- Title -->
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6 tracking-wide">Register</h2>

        <!-- Error Message -->
        <?php if($message): ?>
            <p class="text-red-700 bg-red-100 border border-red-300 rounded-md px-3 py-2 text-center mb-4 font-medium">
                <?php echo $message; ?>
            </p>
        <?php endif; ?>

        <!-- Form -->
        <form method="POST" class="space-y-5">
            <input type="text" name="name" placeholder="Full Name" required
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 
                       focus:ring-2 focus:ring-green-200 outline-none transition-all duration-300"/>

            <input type="email" name="email" placeholder="Email" required
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 
                       focus:ring-2 focus:ring-green-200 outline-none transition-all duration-300"/>

            <input type="password" name="password" placeholder="Password" required
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 
                       focus:ring-2 focus:ring-green-200 outline-none transition-all duration-300"/>

            <button type="submit"
                class="w-full py-3 bg-gradient-to-r from-green-600 to-teal-500 text-white font-semibold 
                       rounded-lg shadow-md hover:from-teal-500 hover:to-green-600 transform hover:scale-105 
                       transition-all duration-300">
                Register
            </button>
        </form>

        <!-- Login Link -->
        <p class="mt-6 text-center text-sm text-gray-700">
            Already have an account? 
            <a href="login.php" class="text-green-600 font-semibold hover:underline">Login Here</a>
        </p>
    </div>

</body>
</html>
