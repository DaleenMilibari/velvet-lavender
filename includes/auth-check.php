<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If user is not logged in, redirect to admin login page
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['error'] = 'Please login first';

    // Redirect to login page using BASE_URL
    require_once __DIR__ . '/../config.php';
    header('Location: ' . BASE_URL . 'admin-login.php');
    exit();
}
