<?php
session_start();
include("../config/db.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim(mysqli_real_escape_string($con, $_POST['email']));
    $pass  = trim(mysqli_real_escape_string($con, $_POST['password']));

    // Check user (student or admin)
    $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($pass, $user['password'])) {
            if ($user['role'] === 'admin') {
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_name'] = $user['name'];
                header("Location: ../admin/dashboard.php");
                exit;
            } elseif ($user['role'] === 'student') {
                $_SESSION['student_id'] = $user['id'];
                $_SESSION['student_name'] = $user['name'];
                header("Location: dashboard.php");
                exit;
            }
        } else {
            $message = "❌ Wrong password!";
        }
    } else {
        $message = "⚠️ No user found with this email!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login (Student / Admin)</title>

  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <style>
    /* Full screen background image */
    body {
      background: url('background45.jpg') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
    }
  </style>
</head>
<body class="flex items-center justify-center">

  <!-- Glassmorphism Login Card -->
  <div class="relative w-96 p-8 bg-white/70 backdrop-blur-md rounded-3xl shadow-xl border border-white/30 
              hover:scale-105 transition-transform duration-300">

      <!-- Title -->
      <h2 class="text-2xl font-bold text-center text-gray-800 mb-6 tracking-wide">Login</h2>

      <!-- Error Message -->
      <?php if($message): ?>
        <p class="text-red-700 bg-red-100 border border-red-300 rounded-md px-3 py-2 text-center mb-4 font-medium">
          <?php echo $message; ?>
        </p>
      <?php endif; ?>

      <!-- Form -->
      <form method="POST" class="space-y-5">
          <!-- Email -->
          <div>
              <input type="email" name="email" placeholder="Email" required
                  class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 
                         focus:ring-2 focus:ring-blue-200 outline-none transition-all duration-300"/>
          </div>

          <!-- Password with toggle -->
          <div class="relative">
              <input type="password" id="password" name="password" placeholder="Password" required
                  class="w-full px-4 pr-10 py-3 rounded-lg border border-gray-300 focus:border-blue-500 
                         focus:ring-2 focus:ring-blue-200 outline-none transition-all duration-300"/>
              <span class="absolute right-3 top-3 text-gray-500 cursor-pointer" onclick="togglePassword()">
                  <i id="eyeIcon" class="bi bi-eye-fill"></i>
              </span>
          </div>

          <!-- Login Button -->
          <button type="submit"
              class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white font-semibold 
                     rounded-lg shadow-md hover:from-blue-500 hover:to-blue-600 transform hover:scale-105 
                     transition-all duration-300">
              Login
          </button>
      </form>

      <!-- Sign Up -->
      <p class="mt-6 text-center text-sm text-gray-700">Don’t have an account? 
        <a href="register.php" class="text-blue-600 font-semibold hover:underline">Sign Up</a>
      </p>
  </div>

  <!-- Password Toggle Script -->
  <script>
    function togglePassword() {
      const passwordInput = document.getElementById("password");
      const eyeIcon = document.getElementById("eyeIcon");

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("bi-eye-fill");
        eyeIcon.classList.add("bi-eye-slash-fill");
      } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("bi-eye-slash-fill");
        eyeIcon.classList.add("bi-eye-fill");
      }
    }
  </script>

</body>
</html>
