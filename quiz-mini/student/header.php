<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get current page for active navigation
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Professional Online Quiz System - Test your knowledge with interactive quizzes">
    <meta name="keywords" content="quiz, online test, education, learning, assessment">
    <meta name="author" content="Online Quiz System">
    
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>QuizMaster Pro</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/online_quiz_system/assets/images/favicon.ico">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="..includes/style.css">
    
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1e293b;
            --light-color: #f8fafc;
            --border-color: #e2e8f0;
        }
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--dark-color) 0%, #334155 100%) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: #ffffff !important;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .navbar-brand:hover {
            transform: scale(1.05);
            color: var(--primary-color) !important;
        }
        
        .brand-logo {
            width: 45px;
            height: 45px;
            margin-right: 12px;
            border-radius: 8px;
            padding: 6px;
            background: linear-gradient(45deg, var(--primary-color), #3b82f6);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .brand-logo:hover {
            transform: rotate(10deg) scale(1.1);
        }
        
        /* Fixed positioning for nav items to maintain spacing */
        .navbar-nav {
            display: flex;
            justify-content: flex-start;
            gap: 1rem; /* Fixed gap between items */
        }
        
        .nav-item {
            flex-shrink: 0; /* Prevent shrinking */
        }
        
        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            margin: 0;
            padding: 8px 20px !important; /* Increased padding to maintain button size */
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            white-space: nowrap; /* Prevent text wrapping */
            min-width: 120px; /* Fixed minimum width */
            text-align: center;
        }
        
        .nav-link:hover {
            color: #ffffff !important;
            background: rgba(255,255,255,0.1);
            transform: translateY(-2px);
        }
        
        .nav-link.active {
            background: var(--primary-color);
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            background: rgba(255,255,255,0.1);
            padding: 8px 16px;
            border-radius: 25px;
            margin-right: 16px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary-color), #3b82f6);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .user-name {
            color: rgba(255,255,255,0.95);
            font-weight: 500;
            font-size: 0.9rem;
            margin: 0;
        }
        
        .navbar-toggler {
            border: none;
            padding: 8px;
            border-radius: 6px;
            background: rgba(255,255,255,0.1);
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.3);
        }
        
        .dropdown-menu {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0,0,0,0.1);
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            margin-top: 8px;
        }
        
        .dropdown-item {
            padding: 12px 20px;
            color: var(--dark-color);
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background: var(--primary-color);
            color: white;
            transform: translateX(4px);
        }
        
        .badge-notification {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .main-container {
            margin-top: 2rem;
            min-height: calc(100vh - 100px);
        }
        
        @media (max-width: 768px) {
            .navbar {
                padding: 0.75rem 0;
            }
            
            .user-info {
                margin: 16px 0;
                justify-content: center;
            }
            
            .navbar-nav {
                gap: 0.5rem;
            }
            
            .nav-link {
                margin: 4px 0;
                text-align: center;
                min-width: auto;
                padding: 8px 16px !important;
            }
        }
        
        /* Loading animation */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
        
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(255,255,255,0.3);
            border-top: 4px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Notification toast */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1055;
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="dashboard.php">
                <div class="brand-logo">
                    <i class="bi bi-mortarboard-fill text-white"></i>
                </div>
                Online Quiz
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <?php if (isset($_SESSION['student_id']) && $_SESSION['student_id']): ?>
                    <!-- User Info (Mobile) -->
                    <div class="d-lg-none">
                        <div class="user-info mt-3 mb-3">
                            <div class="user-avatar">
                                <?php echo strtoupper(substr($_SESSION['student_name'] ?? 'U', 0, 1)); ?>
                            </div>
                            <div class="user-name"><?php echo $_SESSION['student_name'] ?? 'User'; ?></div>
                        </div>
                    </div>

                    <!-- Navigation Links (Quizzes option removed) -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>" 
                               href="dashboard.php">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'profile.php') ? 'active' : ''; ?>" 
                               href="profile.php">
                                <i class="bi bi-graph-up me-2"></i>Results
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>" 
                               href="contact.php">
                                <i class="bi bi-chat-dots me-2"></i>Feedback
                            </a>
                        </li>
                    </ul>

                    <!-- User Section (Desktop) -->
                    <div class="d-none d-lg-flex align-items-center">
                        <div class="user-info me-3">
                            <div class="user-avatar">
                                <?php echo strtoupper(substr($_SESSION['student_name'] ?? 'U', 0, 1)); ?>
                            </div>
                            <div class="user-name"><?php echo $_SESSION['student_name'] ?? 'User'; ?></div>
                        </div>

                        <!-- User Dropdown -->
                        <div class="dropdown">
                            <button class="nav-link dropdown-toggle border-0 bg-transparent" type="button" 
                                    id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="logout.php"
                                       onclick="return confirm('Are you sure you want to logout?')">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Mobile Logout -->
                    <div class="d-lg-none mt-3">
                        <a class="nav-link text-danger" href="/online_quiz_system/student/logout.php"
                           onclick="return confirm('Are you sure you want to logout?')">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a>
                    </div>

                <?php else: ?>
                    <!-- Guest Navigation -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">
                                <i class="bi bi-person-plus me-2"></i>Register
                            </a>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <main class="container main-container">
        <!-- Toast Notifications Container -->
        <div class="toast-container"></div>

        <!-- Page Content Goes Here -->

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide navbar on scroll
            let lastScrollTop = 0;
            const navbar = document.querySelector('.navbar');
            
            window.addEventListener('scroll', function() {
                let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                if (scrollTop > lastScrollTop && scrollTop > 100) {
                    navbar.style.transform = 'translateY(-100%)';
                } else {
                    navbar.style.transform = 'translateY(0)';
                }
                lastScrollTop = scrollTop;
            });

            // Loading overlay functions
            window.showLoading = function() {
                document.getElementById('loadingOverlay').style.display = 'flex';
            };

            window.hideLoading = function() {
                document.getElementById('loadingOverlay').style.display = 'none';
            };

            // Toast notification function
            window.showToast = function(message, type = 'success') {
                const toastContainer = document.querySelector('.toast-container');
                const toastId = 'toast-' + Date.now();
                
                const toastHTML = `
                    <div id="${toastId}" class="toast align-items-center text-bg-${type}" role="alert">
                        <div class="d-flex">
                            <div class="toast-body">
                                <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                                ${message}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" 
                                    data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                `;
                
                toastContainer.insertAdjacentHTML('beforeend', toastHTML);
                const toast = new bootstrap.Toast(document.getElementById(toastId));
                toast.show();
                
                // Remove toast element after it's hidden
                document.getElementById(toastId).addEventListener('hidden.bs.toast', function() {
                    this.remove();
                });
            };

            // Smooth transitions for navigation
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.getAttribute('href').startsWith('/')) {
                        showLoading();
                        setTimeout(hideLoading, 1000);
                    }
                });
            });
        });
    </script>
</body>
</html>