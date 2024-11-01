<?php
session_start();
include '../includes/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Database credentials
    $servername = "localhost"; // Your server name
    $username = "root"; // Your database username
    $password_db = ""; // Your database password
    $dbname = "meter_box_app"; // Your database name

    try {
        // Create a new PDO instance
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password_db);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement to find the user
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            header("Location: ../home.php"); // Redirect to home page after login
            exit();
        } else {
            echo "Invalid email or password.";
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
    <link rel="stylesheet" href="../css/login2.css"> 
    <title>Login</title>
</head>
<body>
    <div class="container">
        <header>
            <img src="../pics/Klogo.svg" alt="DOGIES Logo" class="logo" style="width: 90px;">
        </header>
        <div class="signup-box">
            <div class="form-container">
                <form method="POST" action="">
                    <h2>Login to Your Account</h2>
                    <div class="input-group">
                        <input type="email" id="email" name="email" placeholder="" required>
                        <label for="email">Email</label>
                    </div>

                    <div class="input-group">
                        <input type="password" id="password" name="password" placeholder="" required>
                        <label for="password">Password</label>
                    </div>

                    <button type="submit" class="btn">Login</button>
                </form>
                <p class="footer-text">Don't have an account? <a href="signup.php">Sign up here</a></p>
            </div>
            
        </div>
    </div>
    <div class="gif-container">
        <img src="../pics/pull up.gif" alt="" class="signup-gif">
    </div>
</body>
</html>
