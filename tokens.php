<?php
include 'includes/connection.php'; // Ensure this path is correct
session_start();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $meterbox_number = $_POST['meterbox_number'];
    $banking_institution = $_POST['banking_institution'];
    $amount = $_POST['amount'];

    // Prepare and bind the SQL statement using MySQLi
    $stmt = $conn->prepare("INSERT INTO purchases (meterbox_number, banking_institution, amount) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $meterbox_number, $banking_institution, $amount);

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

    // Close the statement
    $stmt->close();
    mysqli_close($conn); // Close the connection
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
    <link rel="stylesheet" href="css/tokens.css">
    <style>
        .custom-select {
            position: relative;
            width: 100%;
            margin: 10px 0;
        }
        .select-selected {
            background-color: #f1f1f1;
            padding: 10px;
            border: 1px solid #ccc;
            cursor: pointer;
        }
        .select-items {
            position: absolute;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            z-index: 99;
            display: none;
            max-height: 200px;
            overflow-y: auto;
        }
        .select-items div {
            padding: 10px;
            cursor: pointer;
        }
        .select-items div:hover {
            background-color: #ddd;
        }
        .select-items img {
            width: 20px; /* Default size */
            height: auto;
            margin-right: 10px;
            vertical-align: middle;
        }
       
        .selected-logo {
            width: 50px; /* Resized to 50px */
            height: auto;
        }
    </style>
</head>
<body>
<header class="site-header">
    <h1></h1>
    <div class="smiley" id="smiley"><img src="pics/Klogo.svg" alt="" width="120" height="120"></div>
</header>

<nav class="menu" id="menu">
    <button id="close-btn">&times;</button>
    <a href="home.php">Home</a>
    <a href="tokens.php">Buy Tokens</a>
    <a href="office.php">Offices</a>  
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

        <div class="form-group custom-select">
            <label for="banking_institution">Banking Institution:</label>
            <div class="select-selected">Select Bank</div>
            <div class="select-items">
                <div data-value="Standard Bank">
                    <img src="pics/standard.png" alt="Standard Bank" class="selected-logo">Standard Bank
                </div>
                <div data-value="Absa">
                    <img src="pics/absa.png" alt="Absa" class="selected-logo">Absa
                </div>
                <div data-value="Nedbank">
                    <img src="pics/nedbank.png" alt="Nedbank"  class="selected-logo">Nedbank
                </div>
                <div data-value="FNB">
                    <img src="pics/fnb.png" alt="FNB"  class="selected-logo">FNB
                </div>
                <div data-value="Capitec">
                    <img src="pics/capitec.png" alt="Capitec"  class="selected-logo">Capitec
                </div>
            </div>
            <input type="hidden" id="banking_institution" name="banking_institution" required>
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
    // Dropdown functionality
    const selected = document.querySelector('.select-selected');
    const items = document.querySelector('.select-items');
    const hiddenInput = document.querySelector('#banking_institution');

    selected.addEventListener('click', function() {
        items.style.display = items.style.display === 'block' ? 'none' : 'block';
    });

    items.addEventListener('click', function(e) {
        if (e.target && e.target.matches('div')) {
            selected.innerHTML = e.target.innerHTML; // Display the selected option
            hiddenInput.value = e.target.getAttribute('data-value'); // Set the value of the hidden input
            
            // Find the selected image and resize it
            const img = e.target.querySelector('img');
            img.classList.add('selected-logo'); // Add the class to resize the logo
            
            items.style.display = 'none'; // Hide the dropdown
        }
    });

    window.addEventListener('click', function(e) {
        if (!e.target.matches('.select-selected')) {
            items.style.display = 'none'; // Hide dropdown if clicking outside
        }
    });
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
<script>
        const menu = document.getElementById('menu');
        const closeBtn = document.getElementById('close-btn');
        const smiley = document.getElementById('smiley');
        const overlay = document.getElementById('overlay');

        // Function to show the menu and overlay
        function showMenu() {
            menu.style.left = '0'; // Show menu
            overlay.style.display = 'block'; // Show overlay
        }

        // Function to hide the menu and overlay
        function hideMenu() {
            menu.style.left = '-250px'; // Hide menu
            overlay.style.display = 'none'; // Hide overlay
        }

        // Add event listeners
        smiley.addEventListener('click', showMenu);
        closeBtn.addEventListener('click', hideMenu);
    </script>
</body>
</html>
