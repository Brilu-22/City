<?php
session_start();
include '../includes/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "meter_box_app";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password_db);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            echo "Error: Could not execute the statement.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/sign.css">
    <link rel="icon" href="../pics/MeterBox.png" type="favicon" style="width:800px; height:800px;">
    <title>Sign Up</title>
</head>
<body>
    <div class="container">
        <header>
            <img src="../pics/Klogo.svg" alt="" class="logo" style="width: 90px;">
        </header>

        <div class="signup-box">
            <!-- Form Container -->
            <div class="form-container">
                <form method="POST" action="">
                    <h2>Create an Account</h2>
                    
                    <div class="input-group">
                        <input type="text" id="name" name="name" placeholder=" " required>
                        <label for="name">Name</label>
                    </div>
                    
                    <div class="input-group">
                        <input type="email" id="email" name="email" placeholder=" " required>
                        <label for="email">Email</label>
                    </div>

                    <div class="input-group">
                        <input type="password" id="password" name="password" placeholder=" " required>
                        <label for="password">Create a password</label>
                    </div>
                    
                    <button type="submit" class="btn">Sign Up</button>
                    
                    <p class="footer-text">Already have an account? <a href="login.php">Login here</a></p>
                </form>
            </div>

            
            
        </div>
    </div>
    <div class="gif-container">
        <img src="../pics/Walking Animation.gif" alt="" class="signup-gif">
    </div>
</body>
</html>
