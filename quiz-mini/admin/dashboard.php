<?php
session_start();

// Agar admin login nahi hai to redirect
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php"); // admin login page
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <!-- Font Awesome for better icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* CSS Variables for consistent theming */
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #2ecc71;
            --warning-color: #e67e22;
            --danger-color: #e74c3c;
            --info-color: #1abc9c;
            --purple-color: #9b59b6;
            --light-bg: #f4f6f8;
            --white: #ffffff;
            --text-dark: #2c3e50;
            --text-muted: #6c757d;
            --border-color: #dee2e6;
            --shadow: 0 2px 10px rgba(0,0,0,0.1);
            --sidebar-width: 250px;
            --border-radius: 8px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            background: var(--light-bg);
            line-height: 1.6;
            color: var(--text-dark);
        }

        /* Enhanced Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(135deg, var(--secondary-color) 0%, #34495e 100%);
            color: var(--white);
            height: 100vh;
            padding: 0;
            position: fixed;
            box-shadow: var(--shadow);
            overflow-y: auto;
            transition: var(--transition);
        }

        .sidebar-header {
            padding: 2rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.1);
        }

        .sidebar h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .sidebar-subtitle {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .sidebar-nav {
            padding: 1.5rem 0;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            color: rgba(255,255,255,0.8);
            padding: 1rem 2rem;
            text-decoration: none;
            margin: 0.25rem 1rem;
            border-radius: var(--border-radius);
            transition: var(--transition);
            font-weight: 500;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,0.1);
            color: var(--white);
            transform: translateX(5px);
        }

        .sidebar a.active {
            background: var(--primary-color);
            color: var(--white);
        }

        .sidebar a i {
            width: 20px;
            margin-right: 1rem;
            text-align: center;
        }

        /* Enhanced Content Area */
        .content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 0;
            min-height: 100vh;
        }

        /* Professional Header */
        .topbar {
            background: var(--white);
            padding: 2rem;
            margin-bottom: 0;
            border-radius: 0;
            box-shadow: var(--shadow);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .welcome-section h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }

        .welcome-subtitle {
            color: var(--text-muted);
            font-size: 1rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: var(--light-bg);
            padding: 1rem 1.5rem;
            border-radius: var(--border-radius);
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: bold;
            font-size: 1.2rem;
        }

        .user-details h4 {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .user-role {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        /* Content Body */
        .content-body {
            padding: 2rem;
        }

        .section-title {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 2rem;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 30px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        /* Enhanced Dashboard Cards */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .card {
            background: var(--white);
            color: var(--text-dark);
            padding: 2.5rem 2rem;
            text-align: center;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: var(--shadow);
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            transition: var(--transition);
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        }

        .card:hover::before {
            height: 8px;
        }

        .card-icon {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            display: block;
            color: var(--white);
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .card-description {
            color: var(--text-muted);
            font-size: 0.95rem;
            font-weight: 400;
        }

        /* Color variations */
        .card.add-quiz::before { background: var(--primary-color); }
        .card.add-quiz .card-icon { background: var(--primary-color); }

        .card.manage-quiz::before { background: var(--warning-color); }
        .card.manage-quiz .card-icon { background: var(--warning-color); }

        .card.add-question::before { background: var(--purple-color); }
        .card.add-question .card-icon { background: var(--purple-color); }

        .card.manage-questions::before { background: var(--success-color); }
        .card.manage-questions .card-icon { background: var(--success-color); }

        .card.view-results::before { background: var(--info-color); }
        .card.view-results .card-icon { background: var(--info-color); }

        /* Responsive Design */
        @media (max-width: 1024px) {
            :root {
                --sidebar-width: 220px;
            }
            
            .cards {
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1000;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .content {
                margin-left: 0;
            }
            
            .topbar-content {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .user-info {
                width: 100%;
                justify-content: center;
            }
            
            .cards {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .content-body {
                padding: 1rem;
            }
            
            .mobile-menu-btn {
                position: fixed;
                top: 2rem;
                left: 1rem;
                background: var(--primary-color);
                color: var(--white);
                border: none;
                padding: 1rem;
                border-radius: 50%;
                cursor: pointer;
                font-size: 1.2rem;
                z-index: 1001;
                box-shadow: var(--shadow);
                transition: var(--transition);
            }
            
            .mobile-menu-btn:hover {
                background: #2980b9;
                transform: scale(1.1);
            }
        }

        /* Loading and Animation Enhancements */
        .card-icon {
            transition: var(--transition);
        }

        .card:hover .card-icon {
            transform: scale(1.1) rotate(5deg);
        }

        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Focus States for Accessibility */
        .card:focus,
        .sidebar a:focus {
            outline: 3px solid var(--primary-color);
            outline-offset: 2px;
        }

        /* Professional animations */
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

        .card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .card:nth-child(1) { animation-delay: 0.1s; }
        .card:nth-child(2) { animation-delay: 0.2s; }
        .card:nth-child(3) { animation-delay: 0.3s; }
        .card:nth-child(4) { animation-delay: 0.4s; }
        .card:nth-child(5) { animation-delay: 0.5s; }
    </style>
</head>
<body>
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" id="mobileMenuBtn" style="display: none;">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2>Admin Panel</h2>
            <div class="sidebar-subtitle">Quiz Management</div>
        </div>
        <nav class="sidebar-nav">
            <a href="dashboard.php" class="active">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="add_quiz.php">
                <i class="fas fa-plus-circle"></i> Add Quiz
            </a>
            <a href="manage_quiz.php">
                <i class="fas fa-edit"></i> Manage Quizzes
            </a>
            <a href="add_question.php">
                <i class="fas fa-question-circle"></i> Add Question
            </a>
            <a href="manage_questions.php">
                <i class="fas fa-list-alt"></i> Manage Questions
            </a>
            <a href="view_results.php">
                <i class="fas fa-chart-bar"></i> View Results
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="topbar">
            <div class="topbar-content">
                <div class="welcome-section">
                    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin_name']); ?>!</h2>
                    <div class="welcome-subtitle">Manage your quiz system efficiently</div>
                </div>
                <div class="user-info">
                    <div class="user-avatar">
                        <?php echo strtoupper(substr($_SESSION['admin_name'], 0, 1)); ?>
                    </div>
                    <div class="user-details">
                        <h4><?php echo htmlspecialchars($_SESSION['admin_name']); ?></h4>
                        <div class="user-role">System Administrator</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            <h3 class="section-title">Quick Actions</h3>
            <div class="cards">
                <a href="add_quiz.php" class="card add-quiz">
                    <div class="card-icon">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <div class="card-title">Add Quiz</div>
                    <div class="card-description">Create a new quiz for your students</div>
                </a>

                <a href="manage_quiz.php" class="card manage-quiz">
                    <div class="card-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div class="card-title">Manage Quizzes</div>
                    <div class="card-description">Edit or delete existing quizzes</div>
                </a>

                <a href="add_question.php" class="card add-question">
                    <div class="card-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <div class="card-title">Add Question</div>
                    <div class="card-description">Add new questions to your quiz bank</div>
                </a>

                <a href="manage_questions.php" class="card manage-questions">
                    <div class="card-icon">
                        <i class="fas fa-list-alt"></i>
                    </div>
                    <div class="card-title">Manage Questions</div>
                    <div class="card-description">Edit or organize your question bank</div>
                </a>

                <a href="view_results.php" class="card view-results">
                    <div class="card-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="card-title">View Results</div>
                    <div class="card-description">Check student performance and analytics</div>
                </a>
            </div>
        </div>
    </div>

    <script>
        // Mobile sidebar toggle functionality
        const sidebar = document.getElementById('sidebar');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        
        // Show mobile menu button on small screens
        function checkScreenSize() {
            if (window.innerWidth <= 768) {
                mobileMenuBtn.style.display = 'block';
            } else {
                mobileMenuBtn.style.display = 'none';
                sidebar.classList.remove('active');
            }
        }
        
        // Toggle sidebar on mobile
        mobileMenuBtn.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 768 && 
                !sidebar.contains(e.target) && 
                !mobileMenuBtn.contains(e.target) && 
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });
        
        // Check screen size on load and resize
        window.addEventListener('load', checkScreenSize);
        window.addEventListener('resize', checkScreenSize);
        
        // Add smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Add loading state for card clicks
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('click', function(e) {
                if (!this.classList.contains('loading')) {
                    this.classList.add('loading');
                    this.style.opacity = '0.7';
                    this.style.transform = 'scale(0.98)';
                    
                    // Reset after navigation (in case it fails)
                    setTimeout(() => {
                        this.classList.remove('loading');
                        this.style.opacity = '';
                        this.style.transform = '';
                    }, 2000);
                }
            });
        });
    </script>
</body>
</html>