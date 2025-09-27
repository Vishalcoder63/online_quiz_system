<?php
session_start();
include("../config/db.php");

// Agar admin pehle se login hai to dashboard bhejo
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

// Form submit hone par check karo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Password ko MD5 ke sath check karenge (abhi demo ke liye simple rakha hai)
    $sql = "SELECT * FROM users WHERE email='$email' AND password=MD5('$password') AND role='admin' LIMIT 1";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['admin_id'] = $row['id'];
        $_SESSION['admin_name'] = $row['name'];
        $_SESSION['role'] = $row['role'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid email/password or not an admin!";
    }
}
?>

<?php include("../includes/header.php"); ?>

<main class="container mt-5">
    <h2 class="mb-4">Admin Login</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required placeholder="Enter admin email">
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required placeholder="Enter password">
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</main>

<?php include("../includes/footer.php"); ?>
