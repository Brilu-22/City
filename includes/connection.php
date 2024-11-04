<?php
// Fetch environment variables
$cloudSqlUser = getenv('CLOUDSQL_USER');
$cloudSqlPassword = getenv('CLOUDSQL_PASSWORD');
$cloudSqlDatabase = getenv('CLOUDSQL_DB');
$cloudSqlDsn = getenv('CLOUDSQL_DSN');

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:unix_socket={$cloudSqlDsn};dbname={$cloudSqlDatabase}", $cloudSqlUser, $cloudSqlPassword);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection error
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Optional: Set character set to UTF-8
$pdo->exec("set names utf8");

// Now you can use $pdo for your database operations
?>
