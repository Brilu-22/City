<?php
include 'includes/connection.php'; // Ensure this path is correct
session_start();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $meterbox_number = $_POST['meterbox_number'];
    $banking_institution = $_POST['banking_institution'];
    $amount = $_POST['amount'];

    // Connect to the database using the Database class
    $conn = Database::connect();
    
    if ($conn) {
        // Prepare and bind the SQL statement
        $stmt = $conn->prepare("INSERT INTO purchases (meterbox_number, banking_institution, amount) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $meterbox_number);
        $stmt->bindParam(2, $banking_institution);
        $stmt->bindParam(3, $amount, PDO::PARAM_STR);

        // Execute the statement
        if ($stmt->execute()) {
            // Generate a random 14-digit token
            $token = generateToken();

            // Redirect to successful.php with the generated token and amount
            header("Location: successful.php?token=$token&amount=$amount");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt = null;
        Database::disconnect();
    } else {
        echo "Database connection failed.";
    }
}

// Function to generate a random 14-digit token
function generateToken() {
    // Generate a random number between 10000000000000 and 99999999999999
    return strval(mt_rand(10000000000000, 99999999999999));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <title>Purchase Tokens</title>

    <link rel="stylesheet" href="css/token.css">
</head>
<body>
<header class="site-header">
        <h1>Meter Box Web App</h1>
        <div class="smiley" id="smiley"><img src="pics/k.svg" alt="" width="120" height="120"></div>
    </header>

    <nav class="menu" id="menu">
        <button id="close-btn">&times;</button>
        <a href="home.php">Home</a>
        <a href="tokens.php">Buy Tokens</a>
        <a href="#">My Account</a>
        <a href="../logout.php">Logout</a>
    </nav>

    <div class="container">
        <h1>Purchase Electricity Tokens</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="meterbox_number">Meter Box Number (11 digits):</label>
                <input type="text" id="meterbox_number" name="meterbox_number" required pattern="\d{11}" title="Please enter an 11-digit meter box number.">
            </div>
            <div class="form-group">
                <label for="banking_institution">Banking Institution:</label>
                <select id="banking_institution" name="banking_institution" required>
                    <option value="">Select Bank</option>
                    <option value="Standard Bank">Standard Bank</option>
                    <option value="Absa">Absa</option>
                    <option value="Nedbank">Nedbank</option>
                    <option value="FNB">FNB</option>
                    <option value="Capitec">Capitec</option>
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Amount (ZAR):</label>
                <input type="number" id="amount" name="amount" required min="1" step="0.01">
            </div>
            <button type="submit">Buy Now</button>
        </form>
        <div class="transmit-options">
            <h3>Transmission Options:</h3>
            <button onclick="showModal('manual')">Manual Transmit</button>
            <button onclick="showModal('electronic')">Electronic Transmit</button>
        </div>
    </div>

    <script>
        const menu = document.getElementById('menu');
        const closeBtn = document.getElementById('close-btn');
        const smiley = document.getElementById('smiley');

        function showMenu() {
            menu.style.left = '0';
        }

        function hideMenu() {
            menu.style.left = '-250px';
        }

        smiley.addEventListener('click', showMenu);
        closeBtn.addEventListener('click', hideMenu);
    </script>

    <div id="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0, 0, 0, 0.5); justify-content:center; align-items:center;">
        <div style="background:white; padding:20px; border-radius:8px; text-align:center;">
            <h2>Your tokens have been successfully loaded to your meter box.</h2>
            <p>Thank you for using Khanyisa.</p>
            <button onclick="closeModal()">Close</button>
        </div>
    </div>

    <script>
        function showModal(type) {
            const modal = document.getElementById('modal');
            modal.style.display = 'flex';
        }

        function closeModal() {
            const modal = document.getElementById('modal');
            modal.style.display = 'none';
        }
    </script>
</body>
</html>
