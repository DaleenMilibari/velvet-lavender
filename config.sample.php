<?php
// =============================================
// Velvet Lavender - Sample Configuration
// =============================================

// Application Configuration
define('BASE_URL', 'http://localhost:8080/velvet_lavender/');

// Database Configuration (replace with your own credentials)
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'velvet_lavender');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST .
            ";port=" . DB_PORT .
            ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
