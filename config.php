<?php
// config.php - Database connection configuration

// Database credentials (adjust as needed for your setup)
$host = 'localhost';
$dbname = 'school_db';
$username = 'root'; // Default for Laragon/MySQL
$password = ''; // Default for Laragon/MySQL

try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection errors
    die("Database connection failed: " . $e->getMessage());
}
?>