<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['student_id'];
$res = mysqli_query($con, "SELECT r.*, q.title FROM results r JOIN quizzes q ON r.quiz_id=q.id WHERE r.user_id=$student_id ORDER BY r.date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION['student_name']; ?> - Profile Dashboard</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMTYiIGN5PSIxNiIgcj0iMTYiIGZpbGw9IiM2MzY2RjEiLz4KPHN2ZyB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHZpZXdCb3g9IjAgMCAxOCAxOCIgZmlsbD0id2hpdGUiIHg9IjciIHk9IjciPgo8cGF0aCBkPSJNOSAyQzUuMTMgMiAyIDUuMTMgMiA5UzUuMTMgMTYgOSAxNlMxNiAxMi44NyAxNiA5UzEyLjg3IDIgOSAyWk05IDEwSDdWOEg5VjEwWiIgZmlsbD0iI0ZGRiIvPgo8L3N2Zz4KPC9zdmc+">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <link rel="stylesheet" href="..includes/styles.css">
    

    <style>
        :root {
            /* Light Theme */
            --bg-primary: #f8fafc;
            --bg-secondary: #ffffff;
            --bg-tertiary: #f1f5f9;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-tertiary: #94a3b8;
            --border-color: #e2e8f0;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --primary: #6366f1;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
        }

        [data-theme="dark"] {
            /* Dark Theme */
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --bg-tertiary: #334155;
            --text-primary: #f8fafc;
            --text-secondary: #cbd5e1;
            --text-tertiary: #94a3b8;
            --border-color: #475569;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            transition: all 0.3s ease;
            min-height: 100vh;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Header Section */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: var(--bg-secondary);
            padding: 1.5rem 2rem;
            border-radius: 16px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--info));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .header-info h1 {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .header-info p {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .theme-toggle {
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            border-radius: 50px;
            padding: 0.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-secondary);
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            background: var(--border-color);
            transform: translateY(-1px);
        }

        /* Grid Layout */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        /* Statistics Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
        }

        .stat-icon.primary { background: var(--primary); }
        .stat-icon.success { background: var(--success); }
        .stat-icon.warning { background: var(--warning); }
        .stat-icon.info { background: var(--info); }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.9rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        /* Chart Container */
        .chart-container {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            height: fit-content;
        }

        .chart-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .chart-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        #performanceChart {
            max-height: 300px;
        }

        /* Results Table */
        .results-container {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .results-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .results-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .table-container {
            overflow-x: auto;
        }

        .results-table {
            width: 100%;
            border-collapse: collapse;
        }

        .results-table th {
            background: var(--bg-tertiary);
            padding: 1rem 1.5rem;
            text-align: left;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.9rem;
            border-bottom: 1px solid var(--border-color);
        }

        .results-table td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .results-table tbody tr {
            transition: all 0.2s ease;
        }

        .results-table tbody tr:hover {
            background: var(--bg-tertiary);
        }

        .quiz-title {
            font-weight: 500;
            color: var(--text-primary);
        }

        .score-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .score-excellent {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .score-good {
            background: rgba(6, 182, 212, 0.1);
            color: var(--info);
        }

        .score-average {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .score-poor {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        /* Back Button */
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: var(--shadow);
            margin-top: 2rem;
        }

        .back-button:hover {
            background: #5855eb;
            transform: translateY(-1px);
            box-shadow: var(--shadow-lg);
            color: white;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .chart-container {
                order: -1;
            }
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 1rem;
            }

            .header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .header-info h1 {
                font-size: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 1rem;
            }

            .results-table th,
            .results-table td {
                padding: 0.75rem;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <div class="avatar">
                    <?php echo strtoupper(substr($_SESSION['student_name'], 0, 2)); ?>
                </div>
                <div class="header-info">
                    <h1><?php echo htmlspecialchars($_SESSION['student_name']); ?></h1>
                    <p>Student Dashboard</p>
                </div>
            </div>
            <div class="theme-toggle" onclick="toggleTheme()">
                <i class="fas fa-sun" id="theme-icon"></i>
            </div>
        </div>

        <?php 
        // Calculate statistics
        $total_quizzes = 0;
        $total_score = 0;
        $total_possible = 0;
        $results_array = [];
        $performance_data = [
            'excellent' => 0,
            'good' => 0, 
            'average' => 0,
            'poor' => 0
        ];
        
        while ($row = mysqli_fetch_assoc($res)) {
            $results_array[] = $row;
            $total_quizzes++;
            $total_score += $row['score'];
            $total_possible += $row['total'];
            
            $percentage = ($row['score'] / $row['total']) * 100;
            if ($percentage >= 90) $performance_data['excellent']++;
            elseif ($percentage >= 75) $performance_data['good']++;
            elseif ($percentage >= 60) $performance_data['average']++;
            else $performance_data['poor']++;
        }
        
        $average_percentage = $total_possible > 0 ? round(($total_score / $total_possible) * 100, 1) : 0;
        $highest_score = 0;
        foreach ($results_array as $result) {
            $score_percentage = ($result['score'] / $result['total']) * 100;
            if ($score_percentage > $highest_score) {
                $highest_score = round($score_percentage, 1);
            }
        }
        ?>

        <!-- Statistics Cards -->
        <?php if ($total_quizzes > 0): ?>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon primary">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
                <div class="stat-value"><?php echo $total_quizzes; ?></div>
                <div class="stat-label">Total Quizzes</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon success">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
                <div class="stat-value"><?php echo $average_percentage; ?>%</div>
                <div class="stat-label">Average Score</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon warning">
                        <i class="fas fa-trophy"></i>
                    </div>
                </div>
                <div class="stat-value"><?php echo $highest_score; ?>%</div>
                <div class="stat-label">Best Score</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon info">
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <div class="stat-value"><?php echo $total_score; ?>/<?php echo $total_possible; ?></div>
                <div class="stat-label">Total Points</div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Dashboard Grid -->
        <div class="dashboard-grid">
            <!-- Results Table -->
            <div class="results-container">
                <div class="results-header">
                    <i class="fas fa-table"></i>
                    <h2 class="results-title">Quiz Results</h2>
                </div>
                
                <div class="table-container">
                    <?php if ($total_quizzes > 0): ?>
                    <table class="results-table">
                        <thead>
                            <tr>
                                <th>Quiz</th>
                                <th>Score</th>
                                <th>Percentage</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results_array as $row): 
                                $percentage = round(($row['score'] / $row['total']) * 100, 1);
                                $badge_class = '';
                                if ($percentage >= 90) $badge_class = 'score-excellent';
                                elseif ($percentage >= 75) $badge_class = 'score-good';
                                elseif ($percentage >= 60) $badge_class = 'score-average';
                                else $badge_class = 'score-poor';
                            ?>
                            <tr>
                                <td class="quiz-title"><?php echo htmlspecialchars($row['title']); ?></td>
                                <td><?php echo $row['score']; ?>/<?php echo $row['total']; ?></td>
                                <td>
                                    <span class="score-badge <?php echo $badge_class; ?>">
                                        <?php echo $percentage; ?>%
                                    </span>
                                </td>
                                <td><?php echo date('M d, Y', strtotime($row['date'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-clipboard-list"></i>
                        <h3>No Quiz Results</h3>
                        <p>You haven't taken any quizzes yet.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Performance Chart -->
            <?php if ($total_quizzes > 0): ?>
            <div class="chart-container">
                <div class="chart-header">
                    <i class="fas fa-chart-pie"></i>
                    <h3 class="chart-title">Performance Overview</h3>
                </div>
                <canvas id="performanceChart"></canvas>
            </div>
            <?php endif; ?>
        </div>

        <!-- Back Button -->
        <a href="dashboard.php" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Back to Dashboard
        </a>
    </div>

    <script>
        // Theme Toggle
        function toggleTheme() {
            const html = document.documentElement;
            const themeIcon = document.getElementById('theme-icon');
            const currentTheme = html.getAttribute('data-theme');
            
            if (currentTheme === 'dark') {
                html.removeAttribute('data-theme');
                themeIcon.className = 'fas fa-moon';
                localStorage.setItem('theme', 'light');
            } else {
                html.setAttribute('data-theme', 'dark');
                themeIcon.className = 'fas fa-sun';
                localStorage.setItem('theme', 'dark');
            }
        }

        // Load saved theme
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme');
            const themeIcon = document.getElementById('theme-icon');
            
            if (savedTheme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                themeIcon.className = 'fas fa-sun';
            } else {
                themeIcon.className = 'fas fa-moon';
            }

            <?php if ($total_quizzes > 0): ?>
            // Performance Chart
            const ctx = document.getElementById('performanceChart').getContext('2d');
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Excellent (90%+)', 'Good (75-89%)', 'Average (60-74%)', 'Poor (<60%)'],
                    datasets: [{
                        data: [
                            <?php echo $performance_data['excellent']; ?>,
                            <?php echo $performance_data['good']; ?>,
                            <?php echo $performance_data['average']; ?>,
                            <?php echo $performance_data['poor']; ?>
                        ],
                        backgroundColor: [
                            '#10b981',
                            '#06b6d4',
                            '#f59e0b',
                            '#ef4444'
                        ],
                        borderWidth: 0,
                        cutout: '60%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                color: isDark ? '#cbd5e1' : '#64748b',
                                font: {
                                    family: 'Poppins',
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: isDark ? '#1e293b' : '#ffffff',
                            titleColor: isDark ? '#f8fafc' : '#1e293b',
                            bodyColor: isDark ? '#cbd5e1' : '#64748b',
                            borderColor: isDark ? '#475569' : '#e2e8f0',
                            borderWidth: 1,
                            cornerRadius: 8,
                            titleFont: {
                                family: 'Poppins'
                            },
                            bodyFont: {
                                family: 'Poppins'
                            }
                        }
                    }
                }
            });
            <?php endif; ?>

            // Smooth animations
            const cards = document.querySelectorAll('.stat-card, .results-container, .chart-container');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>