<?php 
session_start(); 
include("../config/db.php");  

if (!isset($_SESSION['student_id'])) {     
    header("Location: login.php");     
    exit; 
}  

$quiz_id = isset($_GET['id']) ? intval($_GET['id']) : 0; 
if ($quiz_id == 0) {     
    die("⚠️ Invalid Quiz ID!"); 
}  

// Quiz fetch karo 
$qz = mysqli_query($con, "SELECT * FROM quizzes WHERE id=$quiz_id LIMIT 1"); 
$quiz = mysqli_fetch_assoc($qz);  

// Questions fetch karo 
$qs = mysqli_query($con, "SELECT * FROM questions WHERE quiz_id=$quiz_id"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($quiz['title']); ?> - Attempt Quiz</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .quiz-container {
            max-width: 900px;
            margin: 0 auto;
        }
        
        .quiz-header {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .quiz-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 2.5rem;
        }
        
        .quiz-description {
            color: #7f8c8d;
            font-size: 1.1rem;
            line-height: 1.6;
        }
        
        .question-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .question-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .question-number {
            display: inline-block;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            font-weight: 600;
            margin-right: 15px;
            font-size: 1.1rem;
        }
        
        .question-text {
            color: #2c3e50;
            font-weight: 500;
            font-size: 1.2rem;
            margin-bottom: 20px;
            display: inline-block;
            vertical-align: top;
            width: calc(100% - 60px);
        }
        
        .option-group {
            margin-left: 55px;
        }
        
        .option-label {
            display: block;
            padding: 12px 20px;
            margin-bottom: 10px;
            background: #f8f9fa;
            border: 2px solid transparent;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
            position: relative;
            overflow: hidden;
        }
        
        .option-label:hover {
            background: #e3f2fd;
            border-color: #2196f3;
            transform: translateX(5px);
        }
        
        .option-label input[type="radio"] {
            margin-right: 12px;
            transform: scale(1.2);
        }
        
        .option-label input[type="radio"]:checked + .option-text {
            font-weight: 600;
            color: #2196f3;
        }
        
        .option-label:has(input[type="radio"]:checked) {
            background: linear-gradient(45deg, #e3f2fd, #f3e5f5);
            border-color: #2196f3;
            transform: translateX(10px);
        }
        

        
        .submit-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            margin-top: 30px;
        }
        
        .submit-btn {
            background: linear-gradient(45deg, #4CAF50, #45a049);
            border: none;
            color: white;
            padding: 15px 40px;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        }
        
        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(76, 175, 80, 0.5);
            background: linear-gradient(45deg, #45a049, #4CAF50);
        }
        
        .progress-indicator {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: rgba(255,255,255,0.3);
            z-index: 1000;
        }
        
        .progress-bar {
            height: 100%;
            background: linear-gradient(45deg, #4CAF50, #45a049);
            width: 0%;
            transition: width 0.5s ease;
        }
        
        .quiz-info {
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
            color: white;
            text-align: center;
        }
        
        @media (max-width: 768px) {
            .quiz-title {
                font-size: 2rem;
            }
            
            .question-number {
                width: 35px;
                height: 35px;
                line-height: 35px;
                font-size: 1rem;
            }
            
            .question-text {
                width: calc(100% - 50px);
                font-size: 1.1rem;
            }
            
            .option-group {
                margin-left: 0;
                margin-top: 15px;
            }
            
            .option-label {
                padding: 10px 15px;
            }
        }
        
        .fade-in {
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .question-card:nth-child(odd) {
            animation-delay: 0.1s;
        }
        
        .question-card:nth-child(even) {
            animation-delay: 0.2s;
        }
    </style>
</head>
<body>
    <!-- Progress Indicator -->
    <div class="progress-indicator">
        <div class="progress-bar" id="progressBar"></div>
    </div>

    <div class="container-fluid">
        <div class="quiz-container">
            
            <!-- Quiz Info -->
            <div class="quiz-info fade-in">
                <i class="fas fa-clock me-2"></i>
                <strong>Quiz in Progress</strong> - Answer all questions carefully
            </div>
            
            <!-- Quiz Header -->
            <div class="quiz-header fade-in">
                <h1 class="quiz-title">
                    <i class="fas fa-graduation-cap me-3"></i>
                    <?php echo htmlspecialchars($quiz['title']); ?>
                </h1>
                <?php if (!empty($quiz['description'])): ?>
                    <p class="quiz-description">
                        <?php echo htmlspecialchars($quiz['description']); ?>
                    </p>
                <?php endif; ?>
            </div>
            
            <!-- Quiz Form -->
            <form method="POST" action="result.php" id="quizForm">
                <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
                
                <?php 
                $qno = 1;
                $total_questions = mysqli_num_rows($qs);
                while ($row = mysqli_fetch_assoc($qs)) { 
                    $options = ['A', 'B', 'C', 'D'];
                ?>
                    <div class="question-card fade-in" data-question="<?php echo $qno; ?>">
                        <div class="d-flex align-items-start mb-3">
                            <span class="question-number"><?php echo $qno; ?></span>
                            <div class="question-text">
                                <?php echo htmlspecialchars($row['question_text']); ?>
                            </div>
                        </div>
                        
                        <div class="option-group">
                            <label class="option-label">
                                <input type="radio" name="answer[<?php echo $row['id']; ?>]" value="1" onchange="updateProgress()">
                                <span class="option-text">
                                    <?php echo htmlspecialchars($row['option1']); ?>
                                </span>
                            </label>
                            
                            <label class="option-label">
                                <input type="radio" name="answer[<?php echo $row['id']; ?>]" value="2" onchange="updateProgress()">
                                <span class="option-text">
                                    <?php echo htmlspecialchars($row['option2']); ?>
                                </span>
                            </label>
                            
                            <label class="option-label">
                                <input type="radio" name="answer[<?php echo $row['id']; ?>]" value="3" onchange="updateProgress()">
                                <span class="option-text">
                                    <?php echo htmlspecialchars($row['option3']); ?>
                                </span>
                            </label>
                            
                            <label class="option-label">
                                <input type="radio" name="answer[<?php echo $row['id']; ?>]" value="4" onchange="updateProgress()">
                                <span class="option-text">
                                    <?php echo htmlspecialchars($row['option4']); ?>
                                </span>
                            </label>
                        </div>
                    </div>
                <?php 
                $qno++;
                } 
                ?>
                
                <!-- Submit Section -->
                <div class="submit-section fade-in">
                    <div class="mb-3">
                        <i class="fas fa-info-circle text-info me-2"></i>
                        <span class="text-muted">Make sure you have answered all questions before submitting</span>
                    </div>
                    <button type="submit" class="submit-btn" onclick="return confirmSubmit()">
                        <i class="fas fa-paper-plane me-2"></i>
                        Submit Quiz
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const totalQuestions = <?php echo $total_questions; ?>;
        
        // Update progress bar based on answered questions
        function updateProgress() {
            const answeredQuestions = document.querySelectorAll('input[type="radio"]:checked').length;
            const progressPercentage = (answeredQuestions / totalQuestions) * 100;
            document.getElementById('progressBar').style.width = progressPercentage + '%';
        }
        
        // Confirm before submitting
        function confirmSubmit() {
            const answeredQuestions = document.querySelectorAll('input[type="radio"]:checked').length;
            
            if (answeredQuestions < totalQuestions) {
                const unanswered = totalQuestions - answeredQuestions;
                return confirm(`You have ${unanswered} unanswered question(s). Are you sure you want to submit?`);
            }
            
            return confirm('Are you sure you want to submit your quiz? You cannot change your answers after submission.');
        }
        
        // Add smooth scrolling to next question when an option is selected
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                // Smooth scroll to next question after a short delay
                setTimeout(() => {
                    const currentQuestion = this.closest('.question-card');
                    const nextQuestion = currentQuestion.nextElementSibling;
                    if (nextQuestion && nextQuestion.classList.contains('question-card')) {
                        nextQuestion.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }, 300);
            });
        });
        
        // Add fade-in animation to elements
        window.addEventListener('load', function() {
            document.querySelectorAll('.fade-in').forEach((element, index) => {
                setTimeout(() => {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
        
        // Prevent accidental page refresh
        window.addEventListener('beforeunload', function(e) {
            const answeredQuestions = document.querySelectorAll('input[type="radio"]:checked').length;
            if (answeredQuestions > 0) {
                e.preventDefault();
                e.returnValue = '';
            }
        });
        
        // Auto-save answers to prevent data loss (optional enhancement)
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                // You can implement auto-save to localStorage here if needed
                // localStorage.setItem('quiz_' + quiz_id, JSON.stringify(getFormData()));
            });
        });
    </script>
</body>
</html>