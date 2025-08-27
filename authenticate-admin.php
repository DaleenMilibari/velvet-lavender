<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: admin-login.php');
    exit();
}

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

// Basic server-side validation
if (strlen($username) < 3 || strlen($password) < 6) {
    $_SESSION['error'] = 'Invalid input. Please check your credentials.';
    header('Location: admin-login.php');
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        // Prevent session fixation
        session_regenerate_id(true);

        // Set session variables
        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['username'] = $admin['username'];
        $_SESSION['full_name'] = $admin['full_name'];
        $_SESSION['last_login'] = date('Y-m-d H:i:s');

        // Update last login
        $updateStmt = $pdo->prepare("UPDATE admin SET last_login = NOW() WHERE admin_id = :admin_id");
        $updateStmt->execute(['admin_id' => $admin['admin_id']]);

        header('Location: admin/manage.php');
        exit();
    } else {
        $_SESSION['error'] = 'Invalid username or password';
        header('Location: admin-login.php');
        exit();
    }
} catch (PDOException $e) {
    error_log("Admin login DB error: " . $e->getMessage());
    $_SESSION['error'] = 'A server error occurred. Please try again later.';
    header('Location: admin-login.php');
    exit();
}
?>
