<?php
session_start();
include("../config/db.php");

// Check student login
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit;
}

// Initialize variables to avoid "undefined variable" warnings
$score = 0;
$total = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quiz_id = intval($_POST['quiz_id']);
    $answers = $_POST['answer'] ?? [];

    // Fetch questions for the quiz
    $qs = mysqli_query($con, "SELECT * FROM questions WHERE quiz_id=$quiz_id");

    $total = mysqli_num_rows($qs);

    while ($row = mysqli_fetch_assoc($qs)) {
        $qid = $row['id'];
        if (isset($answers[$qid]) && $answers[$qid] == $row['correct_option']) {
            $score++;
        }
    }

    // Save result in database
    $student_id = $_SESSION['student_id'];
    mysqli_query($con, "INSERT INTO results (user_id, quiz_id, score, total) VALUES ($student_id, $quiz_id, $score, $total)");
}

// Calculate percentage and performance level
$percentage = $total > 0 ? round(($score / $total) * 100, 1) : 0;
$performance_level = '';
$performance_color = '';
$performance_icon = '';

if ($percentage >= 90) {
    $performance_level = 'Excellent!';
    $performance_color = '#28a745';
    $performance_icon = '🎉';
} elseif ($percentage >= 75) {
    $performance_level = 'Great Job!';
    $performance_color = '#17a2b8';
    $performance_icon = '🌟';
} elseif ($percentage >= 60) {
    $performance_level = 'Good Work!';
    $performance_color = '#ffc107';
    $performance_icon = '👍';
} elseif ($percentage >= 40) {
    $performance_level = 'Keep Trying!';
    $performance_color = '#fd7e14';
    $performance_icon = '💪';
} else {
    $performance_level = 'Need Practice!';
    $performance_color = '#dc3545';
    $performance_icon = '📚';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Result - Amazing Experience</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
            --light-bg: #f8f9fa;
            --card-shadow: 0 20px 40px rgba(0,0,0,0.1);
            --card-hover-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background particles */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .result-container {
            position: relative;
            z-index: 10;
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
        }

        .result-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            padding: 50px 40px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
            transform: translateY(30px);
            opacity: 0;
            animation: slideUp 1s ease-out forwards;
        }

        @keyframes slideUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .performance-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 30px;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 600;
            color: white;
            margin-bottom: 30px;
            animation: pulse 2s infinite;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .score-display {
            margin: 40px 0;
        }

        .score-circle {
            position: relative;
            width: 200px;
            height: 200px;
            margin: 0 auto 30px;
        }

        .score-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
        }

        .score-number {
            font-size: 3rem;
            font-weight: 700;
            color: #333;
            display: block;
            animation: countUp 2s ease-out;
        }

        .score-total {
            font-size: 1.2rem;
            color: #666;
            margin-top: 5px;
        }

        @keyframes countUp {
            from { opacity: 0; transform: translate(-50%, -50%) scale(0.5); }
            to { opacity: 1; transform: translate(-50%, -50%) scale(1); }
        }

        .percentage-text {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 20px 0;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: fadeInUp 1s ease-out 0.5s both;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin: 40px 0;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 20px;
            padding: 25px 20px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            animation: fadeInUp 1s ease-out var(--delay, 0s) both;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .stat-icon {
            font-size: 2rem;
            margin-bottom: 10px;
            display: block;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            display: block;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 5px;
        }

        .action-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 40px;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            min-width: 160px;
            justify-content: center;
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .action-btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            border: none;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.5);
            color: white;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
            border: none;
            box-shadow: 0 8px 25px rgba(108, 117, 125, 0.4);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(108, 117, 125, 0.5);
            color: white;
        }

        .motivational-message {
            background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.7) 100%);
            border-radius: 20px;
            padding: 30px;
            margin: 30px 0;
            border-left: 5px solid var(--primary-color, #667eea);
            animation: fadeInUp 1s ease-out 1s both;
        }

        .message-icon {
            font-size: 3rem;
            margin-bottom: 15px;
            display: block;
        }

        .message-text {
            font-size: 1.1rem;
            color: #555;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .message-tip {
            font-size: 0.95rem;
            color: #777;
            font-style: italic;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .result-card {
                padding: 30px 25px;
                margin: 20px;
            }
            
            .score-circle {
                width: 160px;
                height: 160px;
            }
            
            .score-number {
                font-size: 2.5rem;
            }
            
            .percentage-text {
                font-size: 2rem;
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .action-btn {
                width: 100%;
                max-width: 250px;
            }
        }

        /* Loading animation for chart */
        .chart-loading {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(102, 126, 234, 0.3);
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Animated Background Particles -->
    <div class="particles">
        <!-- Particles will be generated by JavaScript -->
    </div>

    <div class="result-container">
        <div class="result-card">
            <!-- Performance Badge -->
            <div class="performance-badge" style="background: <?php echo $performance_color; ?>;">
                <span><?php echo $performance_icon; ?></span>
                <span><?php echo $performance_level; ?></span>
            </div>

            <h2 class="mb-4" style="color: #333; font-weight: 600;">🎯 Your Quiz Result</h2>

            <!-- Score Display -->
            <div class="score-display">
                <div class="score-circle">
                    <canvas id="scoreChart" width="200" height="200"></canvas>
                    <div class="score-text">
                        <span class="score-number"><?php echo $score; ?></span>
                        <div class="score-total">out of <?php echo $total; ?></div>
                    </div>
                </div>
                
                <div class="percentage-text"><?php echo $percentage; ?>%</div>
            </div>

            <!-- Statistics Grid -->
            <div class="stats-grid">
                <div class="stat-card" style="--delay: 0.2s;">
                    <i class="fas fa-check-circle stat-icon" style="color: var(--success-color);"></i>
                    <span class="stat-value"><?php echo $score; ?></span>
                    <div class="stat-label">Correct</div>
                </div>
                <div class="stat-card" style="--delay: 0.4s;">
                    <i class="fas fa-times-circle stat-icon" style="color: var(--danger-color);"></i>
                    <span class="stat-value"><?php echo $total - $score; ?></span>
                    <div class="stat-label">Incorrect</div>
                </div>
                <div class="stat-card" style="--delay: 0.6s;">
                    <i class="fas fa-percentage stat-icon" style="color: var(--info-color);"></i>
                    <span class="stat-value"><?php echo $percentage; ?>%</span>
                    <div class="stat-label">Score</div>
                </div>
            </div>

            <!-- Motivational Message -->
            <div class="motivational-message" style="--primary-color: <?php echo $performance_color; ?>;">
                <span class="message-icon"><?php echo $performance_icon; ?></span>
                <div class="message-text">
                    <?php
                    if ($percentage >= 90) {
                        echo "Outstanding performance! You've mastered this topic brilliantly. Keep up this excellent momentum!";
                    } elseif ($percentage >= 75) {
                        echo "Great job! You have a solid understanding of the material. You're on the right track to excellence!";
                    } elseif ($percentage >= 60) {
                        echo "Good work! You're making progress. Review the missed questions to strengthen your knowledge further.";
                    } elseif ($percentage >= 40) {
                        echo "You're getting there! Don't give up - every expert was once a beginner. Keep practicing and you'll improve!";
                    } else {
                        echo "Learning is a journey! Use this as motivation to study harder. You have the potential to do much better!";
                    }
                    ?>
                </div>
              
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="dashboard.php" class="action-btn btn-primary">
                    <i class="fas fa-home"></i>
                    Back to Dashboard
                </a>
             
            </div>
        </div>
    </div>

    <script>
        // Create animated background particles
        function createParticles() {
            const particlesContainer = document.querySelector('.particles');
            const particleCount = 50;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                
                // Random size between 4px and 12px
                const size = Math.random() * 8 + 4;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                
                // Random position
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                
                // Random animation delay and duration
                particle.style.animationDelay = Math.random() * 6 + 's';
                particle.style.animationDuration = (Math.random() * 3 + 3) + 's';
                
                particlesContainer.appendChild(particle);
            }
        }

        // Initialize particles
        createParticles();

        // Chart.js configuration
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('scoreChart').getContext('2d');
            
            // Show loading spinner initially
            const chartContainer = ctx.canvas.parentElement;
            
            // Create the chart with animation
            const scoreChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Correct', 'Incorrect'],
                    datasets: [{
                        data: [<?php echo $score; ?>, <?php echo $total - $score; ?>],
                        backgroundColor: [
                            '<?php echo $performance_color; ?>',
                            '#e9ecef'
                        ],
                        borderWidth: 0,
                        hoverOffset: 8,
                        cutout: '75%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const percentage = ((context.raw / <?php echo $total; ?>) * 100).toFixed(1);
                                    return context.label + ': ' + context.raw + ' (' + percentage + '%)';
                                }
                            }
                        }
                    },
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 2000,
                        easing: 'easeOutBounce'
                    }
                }
            });
        });

        // Add some interactive effects
        document.querySelectorAll('.stat-card').forEach((card, index) => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.05)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(-5px) scale(1)';
            });
        });

        // Animate number counting
        function animateNumber(element, start, end, duration) {
            let current = start;
            const increment = (end - start) / (duration / 16);
            const timer = setInterval(() => {
                current += increment;
                if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
                    current = end;
                    clearInterval(timer);
                }
                element.textContent = Math.round(current);
            }, 16);
        }

        // Start number animations after page load
        setTimeout(() => {
            const scoreNumber = document.querySelector('.score-number');
            if (scoreNumber) {
                animateNumber(scoreNumber, 0, <?php echo $score; ?>, 2000);
            }
        }, 500);
    </script>
</body>
</html>