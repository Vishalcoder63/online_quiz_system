<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// DB connection
require_once __DIR__ . '/../config/db.php';

/**
 * Secure input
 */
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

/**
 * Check if student is logged in (snake_case)
 */
function check_student_login() {
    if (!isset($_SESSION['student_id'])) {
        // redirect relative to calling file; using student/login.php one level up
        header("Location: ../student/login.php");
        exit();
    }
}

/**
 * Check if admin is logged in (snake_case)
 */
function check_admin_login() {
    if (!isset($_SESSION['admin_id'])) {
        header("Location: ../student/login.php"); // common login in student folder
        exit();
    }
}

/* --- Provide camelCase wrappers so old calls still work --- */

/**
 * CamelCase wrapper for check_admin_login()
 */
function checkAdminLogin() {
    return check_admin_login();
}

/**
 * CamelCase wrapper for check_student_login()
 */
function checkStudentLogin() {
    return check_student_login();
}

/* Optional helpers you can use later */
function isStudentLoggedIn() {
    return isset($_SESSION['student_id']);
}
function isAdminLoggedIn() {
    return isset($_SESSION['admin_id']);
}
?>
