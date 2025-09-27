<?php
require_once("../includes/functions.php"); 
check_student_login(); // functions.php से login check होगा
include("header.php");

// DB connection
include("../config/db.php");

// Quizzes लाओ DB से
$quizzes = mysqli_query($con, "SELECT * FROM quizzes ORDER BY id DESC");
?>

<div class="text-center welcome-section" style="margin:30px 0;">
   
    <!-- Welcome Text -->
    <h2 style="font-size:2.5rem; font-weight:700; color:#3498db; margin-bottom:10px;">
       
    </h2>
    
    <!-- Subtext -->
    <p style="font-size:1.1rem; color:#555;">
       
        <em>Sharpen your skills with fun quizzes!</em>
    </p>
</div>


<hr>

<h3>📚 Available Quizzes</h3>

<?php if (mysqli_num_rows($quizzes) > 0) { ?>
    <?php while ($quiz = mysqli_fetch_assoc($quizzes)) { ?>
        <div style="border:1px solid #ccc; padding:15px; margin:10px; border-radius:8px;">
            <h3><?php echo $quiz['title']; ?></h3>
            <p><?php echo $quiz['description']; ?></p>
            <a href="quiz.php?id=<?php echo $quiz['id']; ?>" 
               style="text-decoration:none; padding:8px 12px; background:#3498db; color:#fff; border-radius:5px;">
               🚀 Start Quiz
            </a>
        </div>
    <?php } ?>
<?php } else { ?>
    <p>No quizzes available right now.</p>
<?php } ?>



