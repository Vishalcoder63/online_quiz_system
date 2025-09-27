<?php
require_once "../includes/functions.php";
check_admin_login(); // Sirf admin access kare

// Agar delete request aayi hai
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($con, "DELETE FROM questions WHERE id=$id");
    header("Location: manage_questions.php?msg=deleted");
    exit;
}

// Quizzes + Questions fetch karna
$sql = "SELECT q.id, q.question_text, q.option1, q.option2, q.option3, q.option4, q.correct_option, 
        quiz.title AS quiz_title
        FROM questions q
        JOIN quizzes quiz ON q.quiz_id = quiz.id
        ORDER BY q.id DESC";
$result = mysqli_query($con, $sql);
?>



<!-- Custom CSS -->
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1000px;
        margin: 40px auto;
        background-color: #fff;
        padding: 20px 30px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        border-radius: 8px;
    }

    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table th, table td {
        padding: 12px 15px;
        text-align: left;
        vertical-align: top;
    }

    table th {
        background-color: #4CAF50;
        color: white;
    }

    table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    table tr:hover {
        background-color: #e0f7fa;
    }

    a {
        text-decoration: none;
        color: #007bff;
        font-weight: bold;
    }

    a:hover {
        color: #0056b3;
    }

    p {
        font-size: 16px;
        margin: 10px 0;
    }

    .options-list {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .options-list li {
        margin-bottom: 5px;
        background: #f4f4f4;
        padding: 5px 8px;
        border-radius: 4px;
    }

    .correct-option {
        color: green;
        font-weight: bold;
    }
</style>

<div class="container">
    <h2>Manage Questions</h2>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted') { ?>
        <p style="color:green;">✅ Question deleted successfully!</p>
    <?php } ?>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Quiz</th>
            <th>Question</th>
            <th>Options</th>
            <th>Correct</th>
            <th>Action</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['quiz_title']); ?></td>
            <td><?php echo htmlspecialchars($row['question_text']); ?></td>
            <td>
                <ul class="options-list">
                    <li>1. <?php echo htmlspecialchars($row['option1']); ?></li>
                    <li>2. <?php echo htmlspecialchars($row['option2']); ?></li>
                    <li>3. <?php echo htmlspecialchars($row['option3']); ?></li>
                    <li>4. <?php echo htmlspecialchars($row['option4']); ?></li>
                </ul>
            </td>
            <td class="correct-option"><?php echo $row['correct_option']; ?></td>
            <td>
                
                <a href="manage_questions.php?delete=<?php echo $row['id']; ?>" 
                   onclick="return confirm('Are you sure you want to delete this question?');">🗑 Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>


