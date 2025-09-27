<?php
require_once "../includes/functions.php";
check_admin_login(); // sirf admin hi access kare

// Quiz list laane ke liye
$quizzes = mysqli_query($con, "SELECT * FROM quizzes ORDER BY created_at DESC");

$message = "";
$message_type = "";

// Question add karna
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quiz_id = intval($_POST['quiz_id']);
    $question_text = clean_input($_POST['question_text']);
    $option1 = clean_input($_POST['option1']);
    $option2 = clean_input($_POST['option2']);
    $option3 = clean_input($_POST['option3']);
    $option4 = clean_input($_POST['option4']);
    $correct_option = intval($_POST['correct_option']);

    if ($quiz_id && $question_text && $option1 && $option2 && $option3 && $option4 && $correct_option) {
        $sql = "INSERT INTO questions (quiz_id, question_text, option1, option2, option3, option4, correct_option) 
                VALUES ('$quiz_id', '$question_text', '$option1', '$option2', '$option3', '$option4', '$correct_option')";
        if (mysqli_query($con, $sql)) {
            $message = "Question added successfully!";
            $message_type = "success";
        } else {
            $message = "Error: " . mysqli_error($con);
            $message_type = "error";
        }
    } else {
        $message = "Please fill all fields correctly!";
        $message_type = "warning";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Question - Admin Panel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .header p {
            opacity: 0.9;
            font-size: 16px;
        }

        .form-container {
            padding: 40px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            border: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideIn 0.4s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .alert.success {
            background: linear-gradient(135deg, #00b894, #00a085);
            color: white;
        }

        .alert.error {
            background: linear-gradient(135deg, #e17055, #d63031);
            color: white;
        }

        .alert.warning {
            background: linear-gradient(135deg, #fdcb6e, #e17055);
            color: white;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%;
            padding: 15px 18px;
            border: 2px solid #e0e6ed;
            border-radius: 10px;
            font-size: 16px;
            color: #2c3e50;
            background: #f8f9fa;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-control:focus {
            border-color: #3498db;
            background: white;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
            transform: translateY(-1px);
        }

        .form-control:hover {
            border-color: #bdc3c7;
        }

        select.form-control {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 40px;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
            font-family: inherit;
        }

        .options-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 25px;
        }

        @media (max-width: 768px) {
            .options-grid {
                grid-template-columns: 1fr;
            }
        }

        .option-input {
            position: relative;
        }

        .option-input::before {
            content: attr(data-option);
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            background: #3498db;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            z-index: 2;
        }

        .option-input .form-control {
            padding-left: 55px;
        }

        .correct-option-group {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 15px;
            padding: 25px;
            border: 2px dashed #dee2e6;
        }

        .btn-submit {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #00b894, #00a085);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 184, 148, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit i {
            margin-right: 8px;
        }

        .form-hint {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
            font-style: italic;
        }

        .quiz-info {
            background: linear-gradient(135deg, #74b9ff, #0984e3);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
        }

        .quiz-info i {
            margin-right: 8px;
        }

        /* Loading animation */
        .btn-submit.loading {
            pointer-events: none;
        }

        .btn-submit.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .form-container {
                padding: 25px;
            }
            
            .header {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-plus-circle"></i> Add New Question</h1>
            <p>Create engaging quiz questions for your students</p>
        </div>

        <div class="form-container">
            <?php if ($message): ?>
                <div class="alert <?php echo $message_type; ?>">
                    <i class="fas fa-<?php echo $message_type === 'success' ? 'check-circle' : ($message_type === 'error' ? 'exclamation-triangle' : 'info-circle'); ?>"></i>
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="quiz-info">
                <i class="fas fa-info-circle"></i>
                Select a quiz and add your question with four multiple choice options
            </div>

            <form method="POST" id="questionForm">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-list-ul"></i> Choose Quiz
                    </label>
                    <select name="quiz_id" class="form-control" required>
                        <option value="">-- Select Quiz --</option>
                        <?php while ($quiz = mysqli_fetch_assoc($quizzes)): ?>
                            <option value="<?php echo $quiz['id']; ?>">
                                <?php echo htmlspecialchars($quiz['title']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <div class="form-hint">Choose the quiz where you want to add this question</div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-question-circle"></i> Question Text
                    </label>
                    <textarea name="question_text" class="form-control" rows="4" required 
                              placeholder="Enter your question here..."></textarea>
                    <div class="form-hint">Write a clear and concise question</div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-list-ol"></i> Answer Options
                    </label>
                    <div class="options-grid">
                        <div class="option-input" data-option="A">
                            <input type="text" name="option1" class="form-control" 
                                   placeholder="Enter option A" required>
                        </div>
                        <div class="option-input" data-option="B">
                            <input type="text" name="option2" class="form-control" 
                                   placeholder="Enter option B" required>
                        </div>
                        <div class="option-input" data-option="C">
                            <input type="text" name="option3" class="form-control" 
                                   placeholder="Enter option C" required>
                        </div>
                        <div class="option-input" data-option="D">
                            <input type="text" name="option4" class="form-control" 
                                   placeholder="Enter option D" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="correct-option-group">
                        <label class="form-label">
                            <i class="fas fa-check-circle"></i> Correct Answer
                        </label>
                        <select name="correct_option" class="form-control" required>
                            <option value="">-- Select Correct Option --</option>
                            <option value="1">Option A (1)</option>
                            <option value="2">Option B (2)</option>
                            <option value="3">Option C (3)</option>
                            <option value="4">Option D (4)</option>
                        </select>
                        <div class="form-hint">Select which option is the correct answer</div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-plus"></i> Add Question
                </button>
            </form>
        </div>
    </div>

    <script>
        // Form submission animation
        document.getElementById('questionForm').addEventListener('submit', function() {
            const submitBtn = document.querySelector('.btn-submit');
            submitBtn.classList.add('loading');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding Question...';
        });

        // Form validation enhancement
        const form = document.getElementById('questionForm');
        const inputs = form.querySelectorAll('input, textarea, select');

        inputs.forEach(input => {
            input.addEventListener('invalid', function() {
                this.style.borderColor = '#e17055';
                this.style.boxShadow = '0 0 0 3px rgba(225, 112, 85, 0.1)';
            });

            input.addEventListener('input', function() {
                if (this.validity.valid) {
                    this.style.borderColor = '#00b894';
                    this.style.boxShadow = '0 0 0 3px rgba(0, 184, 148, 0.1)';
                }
            });
        });

        // Auto-hide alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateX(-20px)';
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }, 5000);
        });
    </script>
</body>
</html>

