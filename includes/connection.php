<?php
$servername = "localhost"; // Change if your database is hosted elsewhere
$username = "root"; // Your database username
$password = " "; // Your database password
$dbname = "meter_box_app"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
