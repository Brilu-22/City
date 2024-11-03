<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Successful</title>
    <link rel="stylesheet" href="css/success.css"> 

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

    <?php
    // Retrieve token, amount, and meter box number from query parameters
    $token = isset($_GET['token']) ? htmlspecialchars($_GET['token']) : 'N/A';
    $amount = isset($_GET['amount']) ? htmlspecialchars($_GET['amount']) : '0.00';
    $meterbox_number = isset($_GET['meterbox_number']) ? htmlspecialchars($_GET['meterbox_number']) : '';
    ?>

    <div class="ticket">
        <div class="content">
            <h1>Purchase Successful</h1>
            <p>Thank you for purchasing electricity tokens.</p>
            <p>Amount Purchased: ZAR <?php echo $amount; ?></p>
            <p>Tokens: <?php echo $token; ?></p>
        </div>
        <form action="transmit.php" method="POST">
            <label for="transmission">Choose Transmission Method:</label>
            <div>
                <input type="radio" id="manual" name="transmission" value="manual" required> Manual Transmit<br>
                <input type="radio" id="electronic" name="transmission" value="electronic" required> Electronic Transmit<br>
            </div>
            <button type="submit">Transmit</button>
        </form>
        <div class="barcode"></div>
    </div>
    <div class="gif-container">
        <img src="pics/Walking Animation.gif" alt="" style="width:550px; height: 520px;">
    </div>

    <div id="modal" style="display: none;">
        <p>Your tokens have been successfully loaded to your meter box <?php echo $meterbox_number; ?>. Thank you for using Khanyisa!</p>
        <button onclick="closeModal()">X</button>
    </div>
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

    <script>
        document.getElementById('electronic').addEventListener('change', function() {
            if (this.checked) {
                showModal();
            }
        });

        function showModal() {
            document.getElementById('modal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>
</body>
</html>
