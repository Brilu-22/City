<?php
session_start();
include '../includes/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security

    // Database credentials
    $servername = "localhost"; // Your server name
    $username = "root"; // Your database username
    $password_db = ""; // Your database password
    $dbname = "meter_box_app"; // Your database name

    try {
        // Create a new PDO instance
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password_db);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement to insert user
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to the login page after successful signup
            header("Location: login.php");
            exit();
        } else {
            echo "Error: Could not execute the statement.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close the connection
    $conn = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/sign.css"> <!-- Link to CSS -->
    <title>Sign Up</title>
</head>
<body>
    <div class="container">
        <div class="signup-box">
            <h2>Create an Account</h2>
            <form method="POST" action="">
                <div class="input-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" required>
                </div>

                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a password" required>
                </div>

                <button type="submit" class="btn">Sign Up</button>
            </form>
            <p>Already have an account? <a href="../pages/login.php">Login here</a></p>
        </div>
    </div>
</body>
</html>
