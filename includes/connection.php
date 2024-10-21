<?php
class Database {
    // Database configuration as static properties
    private static $servername = "localhost"; 
    private static $username = "root";
    private static $password = ""; 
    private static $dbname = "meter_box_app";

    // Static method to connect to the database
    public static function connect() {
        try {
            // Create a new PDO instance
            $conn = new PDO("mysql:host=" . self::$servername . ";dbname=" . self::$dbname, self::$username, self::$password);
            // Set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Uncomment the line below for debugging
            // echo "Connected successfully";
            return $conn;
        } catch(PDOException $e) {
            // Return the error message in case of a connection failure
            echo "Connection failed: " . $e->getMessage();
            return null; // Optional: return null on failure
        }
    }
}

// Usage
// $dbConnection = Database::connect();
?>
