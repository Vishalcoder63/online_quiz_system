<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Quiz Platform</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
            margin-top: -20px;
        }
        
        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            padding: 30px;
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            color: #667eea;
        }
        
        .btn-custom {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }
        
        .stats-section {
            background-color: #f8f9fa;
            padding: 60px 0;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            color: #667eea;
        }
        
        .cta-section {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            color: white;
            padding: 60px 0;
        }
    </style>
</head>
<body>

<!-- Hero Section -->
<div class="hero-section">
    <div class="container text-center">
        <h1 class="display-3 fw-bold mb-4">🎓 Welcome to Online Quiz</h1>
        <p class="lead fs-4 mb-4">
            Test your knowledge, improve your skills, and challenge yourself with our interactive quizzes.
        </p>
        <div class="mt-4">
            <a href="student/login.php" class="btn btn-light btn-lg btn-custom text-white me-3">
                <i class="fas fa-play me-2"></i>login
            </a>
          <a href="student/register.php" class="btn btn-outline-light btn-lg">
        <i class="fas fa-user-plus me-2"></i>Sign Up Free
    </a>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="container mt-5 py-5">
    <div class="row text-center mb-5">
        <div class="col-12">
            <h2 class="display-5 fw-bold mb-4">Why Choose Our Platform?</h2>
            <p class="lead text-muted">Discover the features that make learning engaging and effective</p>
        </div>
    </div>
    
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card feature-card h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-book-open feature-icon"></i>
                    <h3 class="card-title">📚 Multiple Quizzes</h3>
                    <p class="card-text">Access a wide variety of quizzes across different subjects including Science, Math, History, and more.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card feature-card h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-bolt feature-icon"></i>
                    <h3 class="card-title">⚡ Instant Results</h3>
                    <p class="card-text">Get your quiz results instantly with detailed analysis and explanations for each answer.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card feature-card h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-user-graduate feature-icon"></i>
                    <h3 class="card-title">👨‍🎓 Easy to Use</h3>
                    <p class="card-text">Simple and user-friendly platform designed for both students and educators with intuitive navigation.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Section -->
<!-- <div class="stats-section">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3">
                <div class="stat-number">1000+</div>
                <p class="text-muted">Quiz Questions</p>
            </div>
            <div class="col-md-3">
                <div class="stat-number">50+</div>
                <p class="text-muted">Subject Categories</p>
            </div>
            <div class="col-md-3">
                <div class="stat-number">5000+</div>
                <p class="text-muted">Active Users</p>
            </div>
            <div class="col-md-3">
                <div class="stat-number">95%</div>
                <p class="text-muted">Satisfaction Rate</p>
            </div>
        </div>
    </div>
</div> -->

<!-- Additional Features -->
<div class="container py-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="display-6 fw-bold mb-4">Advanced Learning Features</h2>
            <ul class="list-unstyled">
                <li class="mb-3">
                    <i class="fas fa-check-circle text-success me-3"></i>
                    <strong>Progress Tracking:</strong> Monitor your learning journey with detailed progress reports
                </li>
                <li class="mb-3">
                    <i class="fas fa-check-circle text-success me-3"></i>
                    <strong>Timed Quizzes:</strong> Challenge yourself with time-limited assessments
                </li>
                <li class="mb-3">
                    <i class="fas fa-check-circle text-success me-3"></i>
                    <strong>Multiple Choice & Essay:</strong> Various question types to test different skills
                </li>
                <li class="mb-3">
                    <i class="fas fa-check-circle text-success me-3"></i>
                    <strong>Mobile Friendly:</strong> Take quizzes anywhere, anytime on any device
                </li>
            </ul>
        </div>
        <div class="col-md-6 text-center">
            <div class="p-4">
                <i class="fas fa-chart-line" style="font-size: 8rem; color: #667eea; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action -->
<div class="cta-section">
    <div class="container text-center">
        <h2 class="display-5 fw-bold mb-4">Ready to Test Your Knowledge?</h2>
        <p class="lead mb-4">Join thousands of learners who are already improving their skills</p>
        <!-- <a href="quiz-list.php" class="btn btn-light btn-lg me-3">
            <i class="fas fa-rocket me-2"></i>Get Started Now
        </a> -->
        <a href="about.php" class="btn btn-outline-light btn-lg">
            <i class="fas fa-info-circle me-2"></i>Learn More
        </a>
    </div>
</div>

<!-- Footer would go here -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>


