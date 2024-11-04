<?php
// Fetch environment variables
$cloudSqlUser = getenv('CLOUDSQL_USER');
$cloudSqlPassword = getenv('CLOUDSQL_PASSWORD');
$cloudSqlDatabase = getenv('CLOUDSQL_DB');

// Use the public IP address for the connection
$cloudSqlDsn = "mysql:host=34.56.182.207;dbname={$cloudSqlDatabase}";

// Create a new PDO instance
try {
    $pdo = new PDO($cloudSqlDsn, $cloudSqlUser, $cloudSqlPassword);
    
    // Set the PDO error mode to exception for easier debugging
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Optional: Set the character set to UTF-8
    $pdo->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    // Handle connection error and display a user-friendly message
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Now you can use $pdo for your database operations
?>
