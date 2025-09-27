<?php 
require_once "../includes/functions.php"; 
check_admin_login(); // sirf admin access kare  

// Quizzes list 
$quizzes = mysqli_query($con, "SELECT * FROM quizzes");  

// Agar koi quiz select kiya hai 
$resultsData = []; 
$quizTitle = ""; 
if (isset($_GET['quiz_id'])) {     
    $quiz_id = intval($_GET['quiz_id']);      
    
    $quizQuery = mysqli_query($con, "SELECT title FROM quizzes WHERE id=$quiz_id");     
    $quiz = mysqli_fetch_assoc($quizQuery);     
    $quizTitle = $quiz['title'];      
    
    $query = "SELECT u.name, r.score, r.total                
              FROM results r               
              JOIN users u ON r.user_id = u.id               
              WHERE r.quiz_id = $quiz_id";     
    $res = mysqli_query($con, $query);      
    
    while ($row = mysqli_fetch_assoc($res)) {         
        $resultsData[] = $row;     
    } 
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Quiz Results</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        .results-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            margin-bottom: 30px;
        }
        
        .quiz-selector-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.2s ease-in-out;
        }
        
        .quiz-selector-card:hover {
            transform: translateY(-2px);
        }
        
        .results-table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .table thead th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background-color: #f8f9ff;
            transform: scale(1.01);
        }
        
        .percentage-badge {
            font-weight: 600;
            font-size: 0.9em;
        }
        
        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-top: 30px;
        }
        
        .stats-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.2s ease-in-out;
        }
        
        .stats-card:hover {
            transform: translateY(-2px);
        }
        
        .stats-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }
        
        body {
            background-color: #f8f9fa;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="results-header text-center p-4 mb-4">
        <h1 class="mb-2">
            <i class="fas fa-chart-bar me-3"></i>
            Quiz Results Dashboard
        </h1>
        <p class="mb-0 opacity-75">Monitor and analyze student performance across all quizzes</p>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- Quiz Selection Card -->
            <div class="card quiz-selector-card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-filter me-2 text-primary"></i>
                        Select Quiz to View Results
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="" class="row g-3 align-items-end">
                        <div class="col-md-8">
                            <label for="quiz_id" class="form-label fw-semibold">Choose Quiz:</label>
                            <select name="quiz_id" id="quiz_id" class="form-select form-select-lg" required>
                                <option value="">-- Select a Quiz --</option>
                                <?php 
                                // Reset the result pointer for the quizzes query
                                mysqli_data_seek($quizzes, 0);
                                while ($quiz = mysqli_fetch_assoc($quizzes)) { 
                                ?>
                                    <option value="<?php echo $quiz['id']; ?>"
                                         <?php if (isset($quiz_id) && $quiz_id == $quiz['id']) echo "selected"; ?>>
                                        <?php echo htmlspecialchars($quiz['title']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-search me-2"></i>
                                View Results
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <?php if (!empty($resultsData)) { ?>
                <!-- Quiz Title -->
                <div class="text-center mb-4">
                    <h2 class="text-primary">
                        <i class="fas fa-trophy me-2"></i>
                        Results for "<?php echo htmlspecialchars($quizTitle); ?>"
                    </h2>
                </div>

                <?php
                // Calculate statistics
                $totalStudents = count($resultsData);
                $totalScore = array_sum(array_column($resultsData, 'score'));
                $totalPossible = array_sum(array_column($resultsData, 'total'));
                $averagePercentage = $totalPossible > 0 ? round(($totalScore / $totalPossible) * 100, 2) : 0;
                $highestScore = max(array_column($resultsData, 'score'));
                ?>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card stats-card h-100 text-center">
                            <div class="card-body">
                                <i class="fas fa-users stats-icon text-primary"></i>
                                <h3 class="mt-2 mb-1 text-primary"><?php echo $totalStudents; ?></h3>
                                <p class="text-muted mb-0">Total Students</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stats-card h-100 text-center">
                            <div class="card-body">
                                <i class="fas fa-percentage stats-icon text-success"></i>
                                <h3 class="mt-2 mb-1 text-success"><?php echo $averagePercentage; ?>%</h3>
                                <p class="text-muted mb-0">Average Score</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stats-card h-100 text-center">
                            <div class="card-body">
                                <i class="fas fa-star stats-icon text-warning"></i>
                                <h3 class="mt-2 mb-1 text-warning"><?php echo $highestScore; ?></h3>
                                <p class="text-muted mb-0">Highest Score</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stats-card h-100 text-center">
                            <div class="card-body">
                                <i class="fas fa-calculator stats-icon text-info"></i>
                                <h3 class="mt-2 mb-1 text-info"><?php echo $totalScore; ?></h3>
                                <p class="text-muted mb-0">Total Points</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Results Table -->
                <div class="card results-table mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0 text-white">
                            <i class="fas fa-table me-2"></i>
                            Detailed Results
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-user me-2"></i>Student Name</th>
                                        <th><i class="fas fa-check-circle me-2"></i>Score</th>
                                        <th><i class="fas fa-list-ol me-2"></i>Total</th>
                                        <th><i class="fas fa-percent me-2"></i>Percentage</th>
                                        <th><i class="fas fa-medal me-2"></i>Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($resultsData as $index => $row) {
                                        $percentage = round(($row['score'] / $row['total']) * 100, 2);
                                        
                                        // Determine grade and badge color
                                        if ($percentage >= 90) {
                                            $grade = 'A+';
                                            $badgeColor = 'success';
                                        } elseif ($percentage >= 80) {
                                            $grade = 'A';
                                            $badgeColor = 'success';
                                        } elseif ($percentage >= 70) {
                                            $grade = 'B';
                                            $badgeColor = 'primary';
                                        } elseif ($percentage >= 60) {
                                            $grade = 'C';
                                            $badgeColor = 'warning';
                                        } else {
                                            $grade = 'D';
                                            $badgeColor = 'danger';
                                        }
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-3">
                                                    <span class="fw-bold text-primary"><?php echo strtoupper(substr($row['name'], 0, 1)); ?></span>
                                                </div>
                                                <span class="fw-semibold"><?php echo htmlspecialchars($row['name']); ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark fs-6"><?php echo $row['score']; ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark fs-6"><?php echo $row['total']; ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php echo $badgeColor; ?> percentage-badge"><?php echo $percentage; ?>%</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php echo $badgeColor; ?> fs-6"><?php echo $grade; ?></span>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Chart Section -->
                <div class="chart-container">
                    <h5 class="text-center mb-4">
                        <i class="fas fa-chart-bar me-2 text-primary"></i>
                        Performance Visualization
                    </h5>
                    <canvas id="resultsChart" style="max-height: 400px;"></canvas>
                </div>

            <?php } else if (isset($_GET['quiz_id'])) { ?>
                <!-- No Results Found -->
                <div class="card text-center">
                    <div class="card-body py-5">
                        <i class="fas fa-search text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                        <h4 class="mt-3 text-muted">No Results Found</h4>
                        <p class="text-muted">No students have taken this quiz yet.</p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
<?php if (!empty($resultsData)) { ?>
    const ctx = document.getElementById('resultsChart').getContext('2d');
    const resultsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_column($resultsData, 'name')); ?>,
            datasets: [{
                label: 'Scores',
                data: <?php echo json_encode(array_column($resultsData, 'score')); ?>,
                backgroundColor: 'rgba(102, 126, 234, 0.8)',
                borderColor: 'rgba(102, 126, 234, 1)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }, {
                label: 'Total Possible',
                data: <?php echo json_encode(array_column($resultsData, 'total')); ?>,
                backgroundColor: 'rgba(220, 220, 220, 0.8)',
                borderColor: 'rgba(200, 200, 200, 1)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 12,
                            weight: '600'
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Student Performance Overview',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    },
                    ticks: {
                        font: {
                            size: 11
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11
                        },
                        maxRotation: 45
                    }
                }
            }
        }
    });
<?php } ?>

// Add smooth scrolling when form is submitted
document.querySelector('form').addEventListener('submit', function() {
    setTimeout(function() {
        if (document.querySelector('.results-table')) {
            document.querySelector('.results-table').scrollIntoView({ 
                behavior: 'smooth',
                block: 'start' 
            });
        }
    }, 100);
});
</script>

</body>
</html>

