<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $transmission = $_POST['transmission'];

    if ($transmission == "electronic") {
        // Simulate successful electronic transmission
        echo "<script>alert('Your tokens have been successfully loaded to your meter box. Thank you for using Khanyisa!');</script>";
    } else {
        header("Location: tokens.php"); // Redirect to the manual option if chosen
    }
}
?>
