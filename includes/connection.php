<?php
// Fetch environment variables
$cloudSqlUser = getenv('CLOUDSQL_USER');
$cloudSqlPassword = getenv('CLOUDSQL_PASSWORD');
$cloudSqlDatabase = getenv('CLOUDSQL_DB');
$cloudSqlDsn = getenv('CLOUDSQL_DSN');

// Create a new PDO instance
try {
    // Use the Cloud SQL connection string to connect to the database
    $pdo = new PDO("mysql:unix_socket={$cloudSqlDsn};dbname={$cloudSqlDatabase}", $cloudSqlUser, $cloudSqlPassword);
    
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
