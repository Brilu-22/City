<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the user's name if set
$userName = isset($_SESSION['name']) ? $_SESSION['name'] : 'User'; // Fallback to 'User' if not set
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/home.css"> <!-- Linking the CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Home - Meter Box Web App</title>
</head>
<body>

    <header class="site-header">
        <h1>Meter Box Web App</h1>
        <div class="smiley" id="smiley"><img src="pics/mm.svg" alt="" width="90" height="90"></div>
    </header>

    <nav class="menu" id="menu">
        <button id="close-btn">&times;</button>
        <a href="home.php">Home</a>
        <a href="#">Buy Tokens</a>
        <a href="#">My Account</a>
        <a href="../logout.php">Logout</a>
    </nav>

    <section class="hero">
        <img src="pics/head.svg" alt="">
    </section>

    <div class="slider">
        <div class="slide-track">
    <!-- Existing logos -->
    <div class="slide">
        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/557257/1.png" height="100" width="250" alt="" class="bw-logo" />
    </div>
    <div class="slide">
        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/557257/2.png" height="100" width="250" alt="" class="bw-logo" />
    </div>
    <div class="slide">
        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/557257/3.png" height="100" width="250" alt="" class="bw-logo" />
    </div>
    <div class="slide">
        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/557257/4.png" height="100" width="250" alt="" class="bw-logo" />
    </div>
    <div class="slide">
        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/557257/5.png" height="100" width="250" alt="" class="bw-logo" />
    </div>
    <div class="slide">
        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/557257/6.png" height="100" width="250" alt="" class="bw-logo" />
    </div>
    <div class="slide">
        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/557257/7.png" height="100" width="250" alt="" class="bw-logo" />
    </div>

    <!-- New logos for Instagram, Twitter, Notion, and OneNote -->
    <div class="slide">
        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/557257/4.png" height="100" width="250" alt="Instagram" class="bw-logo" />
    </div>
    <div class="slide">
        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/557257/2.png" height="100" width="250" alt="Twitter" class="bw-logo" />
    </div>
    <div class="slide">
        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/557257/6.png" height="100" width="250" alt="Notion" class="bw-logo" />
    </div>
    <div class="slide">
        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/557257/3.png" height="100" width="250" alt="OneNote" class="bw-logo" />
    </div>

    <!-- Repeat slides to create a continuous loop -->
    <div class="slide">
        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/557257/1.png" height="100" width="250" alt="" class="bw-logo" />
    </div>
</div>

        </div>

    <section class="features">
        <div class="feature">
            <h3>Buy Tokens</h3>
            <p>Get your electricity tokens instantly after purchase.</p>
        </div>
        <div class="feature">
            <h3>Automatic Updates</h3>
            <p>Your meter gets updated automatically after buying tokens.</p>
        </div>
        <div class="feature">
            <h3>Easy Management</h3>
            <p>View your purchase history and manage your meter settings.</p>
        </div>
    </section>
    <section class="hero2">
        <h2>Welcome, <?php echo htmlspecialchars($userName); ?>!</h2>
        <p>Manage Your Meter Box Tokens Efficiently</p>
        <a href="#" class="cta-button">Buy Now</a>
    </section>

    <footer>
        <p>&copy; 2024 Meter Box Web App. All rights reserved.</p>
    </footer>

    <script>
        const menu = document.getElementById('menu');
        const closeBtn = document.getElementById('close-btn');
        const smiley = document.getElementById('smiley');

        // Function to show the menu
        function showMenu() {
            menu.style.left = '0'; // Show menu
        }

        // Function to hide the menu
        function hideMenu() {
            menu.style.left = '-250px'; // Hide menu
        }

        // Add event listeners
        smiley.addEventListener('click', showMenu);
        closeBtn.addEventListener('click', hideMenu);
    </script>

</body>
</html>
