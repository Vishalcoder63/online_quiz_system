<?php
session_start();
include("../config/db.php");
include("../includes/functions.php");

// ✅ Only admin can access
checkAdminLogin();

// ✅ Delete quiz if requested
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $deleteQuery = "DELETE FROM quizzes WHERE id=$id";
    if (mysqli_query($con, $deleteQuery)) {
        $msg = "Quiz deleted successfully!";
    } else {
        $msg = "Error deleting quiz: " . mysqli_error($con);
    }
}

// ✅ Fetch all quizzes
$query = "SELECT * FROM quizzes ORDER BY created_at DESC";
$result = mysqli_query($con, $query);
?>



<style>
    :root {
        --primary-color: #3498db;
        --success-color: #27ae60;
        --danger-color: #e74c3c;
        --warning-color: #f39c12;
        --secondary-color: #6c757d;
        --light-color: #f8f9fa;
        --dark-color: #2c3e50;
        --border-color: #dee2e6;
        --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        --border-radius: 8px;
        --transition: all 0.3s ease;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        background: #f8f9fa;
        min-height: 100vh;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-color), #2980b9);
        color: white;
        padding: 2.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        box-shadow: var(--shadow);
        text-align: center;
    }

    .page-header h2 {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-top: 0.5rem;
    }

    .alert {
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        border: none;
        border-radius: var(--border-radius);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        box-shadow: var(--shadow);
        animation: slideInDown 0.5s ease;
    }

    .alert-success {
        background: var(--success-color);
        color: white;
    }

    .alert-error {
        background: var(--danger-color);
        color: white;
    }

    .table-container {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .table-header {
        background: var(--dark-color);
        color: white;
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .table-title {
        font-size: 1.25rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .quiz-count {
        background: var(--primary-color);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .quiz-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.95rem;
    }

    .quiz-table th {
        background: var(--light-color);
        padding: 1.25rem 1rem;
        text-align: left;
        font-weight: 600;
        color: var(--dark-color);
        border-bottom: 2px solid var(--border-color);
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .quiz-table td {
        padding: 1.25rem 1rem;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
    }

    .quiz-table tbody tr {
        transition: var(--transition);
    }

    .quiz-table tbody tr:hover {
        background: rgba(52, 152, 219, 0.05);
        transform: scale(1.01);
    }

    .quiz-id {
        font-weight: 700;
        color: var(--primary-color);
        background: rgba(52, 152, 219, 0.1);
        padding: 0.5rem;
        border-radius: var(--border-radius);
        text-align: center;
        min-width: 60px;
    }

    .quiz-title {
        font-weight: 600;
        color: var(--dark-color);
        font-size: 1.05rem;
    }

    .quiz-description {
        color: var(--secondary-color);
        line-height: 1.5;
        max-width: 300px;
    }

    .quiz-date {
        color: var(--secondary-color);
        font-size: 0.9rem;
        white-space: nowrap;
    }

    .action-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        border: none;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: var(--transition);
        cursor: pointer;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-edit {
        background: var(--warning-color);
        color: white;
    }

    .btn-edit:hover {
        background: #e67e22;
    }

    .btn-delete {
        background: var(--danger-color);
        color: white;
    }

    .btn-delete:hover {
        background: #c0392b;
    }

    .no-data {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--secondary-color);
    }

    .no-data-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .no-data h3 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        color: var(--dark-color);
    }

    .no-data p {
        font-size: 1.1rem;
    }

    .add-quiz-btn {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        background: var(--success-color);
        color: white;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 1.5rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        transition: var(--transition);
        z-index: 1000;
    }

    .add-quiz-btn:hover {
        background: #219a52;
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            padding: 1rem;
        }

        .page-header {
            padding: 2rem 1rem;
        }

        .page-header h2 {
            font-size: 2rem;
            flex-direction: column;
            gap: 0.5rem;
        }

        .table-header {
            padding: 1rem;
            flex-direction: column;
            align-items: flex-start;
        }

        .quiz-table th,
        .quiz-table td {
            padding: 1rem 0.75rem;
        }

        .action-buttons {
            flex-direction: column;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.6rem 1rem;
            font-size: 0.85rem;
        }

        .add-quiz-btn {
            bottom: 1rem;
            right: 1rem;
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }
    }

    @media (max-width: 576px) {
        .quiz-table {
            font-size: 0.85rem;
        }
        
        .quiz-description {
            max-width: 200px;
            font-size: 0.85rem;
        }
    }

    /* Animations */
    @keyframes slideInDown {
        from {
            transform: translateY(-30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes fadeInUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .table-container {
        animation: fadeInUp 0.6s ease;
    }

    /* Loading State */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    .spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>

<div class="container">
    <!-- Page Header -->
    <div class="page-header">
        <h2>📋 Manage Quizzes</h2>
        <div class="page-subtitle">View, and manage all your quizzes in one place</div>
    </div>

    <!-- Alert Messages -->
    <?php if (!empty($msg)): ?>
        <?php if (strpos($msg, 'successfully') !== false): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?= $msg; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?= $msg; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Table Container -->
    <div class="table-container">
        <div class="table-header">
            <div class="table-title">
                <i class="fas fa-list"></i>
                All Quizzes
                <span class="quiz-count"><?= mysqli_num_rows($result); ?> Total</span>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="quiz-table">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag"></i> ID</th>
                        <th><i class="fas fa-book"></i> Quiz Title</th>
                        <th><i class="fas fa-align-left"></i> Description</th>
                        <th><i class="fas fa-calendar"></i> Created At</th>
                        <th><i class="fas fa-tools"></i> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td>
                                    <div class="quiz-id"><?= $row['id']; ?></div>
                                </td>
                                <td>
                                    <div class="quiz-title"><?= htmlspecialchars($row['title']); ?></div>
                                </td>
                                <td>
                                    <div class="quiz-description"><?= htmlspecialchars($row['description']); ?></div>
                                </td>
                                <td>
                                    <div class="quiz-date">
                                        <i class="fas fa-clock"></i>
                                        <?= date('M j, Y \a\t g:i A', strtotime($row['created_at'])); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                       
                                        <a href="manage_quiz.php?delete=<?= $row['id']; ?>" 
                                           class="btn btn-delete" 
                                           onclick="return confirm('⚠️ Are you sure you want to delete this quiz?\n\nThis action cannot be undone!');">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">
                                <div class="no-data">
                                    <div class="no-data-icon">📋</div>
                                    <h3>No Quizzes Found</h3>
                                    <p>Start by creating your first quiz!</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Floating Add Button -->
    <a href="add_quiz.php" class="add-quiz-btn" title="Add New Quiz">
        <i class="fas fa-plus"></i>
    </a>
</div>

<script>
    // Enhanced delete confirmation with loading state
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const quizTitle = this.closest('tr').querySelector('.quiz-title').textContent;
            
            if (confirm(`⚠️ Are you sure you want to delete "${quizTitle}"?\n\nThis action cannot be undone and will remove all associated questions and results!`)) {
                // Add loading state
                this.innerHTML = '<span class="spinner"></span> Deleting...';
                this.classList.add('loading');
                
                // Navigate to delete URL
                window.location.href = this.href;
            }
        });
    });

    // Auto-hide alerts after 5 seconds
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'all 0.5s ease';
            alert.style.transform = 'translateY(-20px)';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // Add smooth scrolling
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

    // Add loading state for edit buttons
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            this.innerHTML = '<span class="spinner"></span> Loading...';
            this.classList.add('loading');
        });
    });

    // Responsive table handling
    function handleResponsiveTable() {
        const table = document.querySelector('.quiz-table');
        const container = document.querySelector('.table-wrapper');
        
        if (window.innerWidth <= 768) {
            container.style.overflowX = 'auto';
        }
    }

    window.addEventListener('load', handleResponsiveTable);
    window.addEventListener('resize', handleResponsiveTable);

    // Add keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            // Close any open modals or cancel operations
            const loadingElements = document.querySelectorAll('.loading');
            loadingElements.forEach(el => {
                el.classList.remove('loading');
            });
        }
    });
</script>

