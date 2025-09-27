<?php
session_start();
include("../config/db.php");

// Sirf admin ko access dena hai
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php"); // admin login page
    exit;
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

    if (!empty($title)) {
        $query = "INSERT INTO quizzes (title, description) VALUES ('$title', '$description')";
        if (mysqli_query($con, $query)) {
            $message = "✅ Quiz added successfully!";
        } else {
            $message = "❌ Error: " . mysqli_error($con);
        }
    } else {
        $message = "⚠️ Title is required!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Quiz</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 0; 
            background: linear-gradient(to right, #6a11cb, #2575fc);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: #fff; 
            padding: 30px 40px; 
            border-radius: 12px; 
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            width: 400px;
        }

        h2 {
            color: #2c3e50; 
            text-align: center; 
            margin-bottom: 25px;
        }

        label {
            display: block; 
            font-weight: bold; 
            margin-bottom: 5px;
            color: #333;
        }

        input, textarea {
            width: 100%; 
            padding: 12px; 
            margin-bottom: 15px; 
            border: 1px solid #ccc; 
            border-radius: 6px; 
            font-size: 15px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
        }

        button {
            width: 100%; 
            padding: 12px; 
            background: #2c3e50; 
            color: #fff; 
            border: none; 
            border-radius: 6px; 
            font-size: 16px; 
            cursor: pointer; 
            transition: background 0.3s;
        }

        button:hover {
            background: #34495e;
        }

        .msg {
            margin-bottom: 20px; 
            font-weight: bold; 
            text-align: center;
            color: green;
        }

        a {
            text-decoration: none; 
            display: inline-block; 
            margin-top: 15px; 
            color: #2c3e50; 
            font-weight: bold;
            transition: color 0.3s;
        }

        a:hover {
            color: #34495e;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Quiz</h2>

        <?php if ($message) echo "<div class='msg'>$message</div>"; ?>

        <form method="POST">
            <label>Quiz Title:</label>
            <input type="text" name="title" required>

            <label>Description:</label>
            <textarea name="description" rows="3"></textarea>

            <button type="submit">Add Quiz</button>
        </form>

        <a href="dashboard.php">⬅ Back to Dashboard</a>
    </div>
</body>
</html>