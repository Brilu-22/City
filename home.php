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
    <link rel="stylesheet" href="css/h.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <title>Home - Meter Box Web App</title>
</head>
<body>

    <header class="site-header">
        <h1>Meter Box Web App</h1>
        <div class="smiley" id="smiley"><img src="pics/llogo.svg" alt="" width="90" height="90"></div>
    </header>

    <nav class="menu" id="menu">
        <button id="close-btn">&times;</button>
        <a href="home.php">Home</a>
        <a href="#">Buy Tokens</a>
        <a href="#">My Account</a>
        <a href="../logout.php">Logout</a>
    </nav>

    <section class="hero">
        <img src="pics/power.svg" alt="">
    </section>

    <div class="slider">
        <div class="slide-track">
            <h1>
                <img src="pics/star.svg" alt="">
                <span class="text">BUY YOUR TOKENS</span>
                <img src="pics/star.svg" alt="">
                <span class="text">KHANYISA YOUR HOUSE</span>
                <img src="pics/star.svg" alt="">
                <span class="text">BUY YOUR TOKENS</span>
                <img src="pics/star.svg" alt="">
                <span class="text">KHANYISA@CITYOFTSHWANE.CO.ZA</span>
                <img src="pics/star.svg" alt="">
                 <span class="text">BUY YOUR TOKENS</span>
                 <img src="pics/star.svg" alt="">
                <span class="text">KHANYISA YOUR HOUSE</span>
                <img src="pics/star.svg" alt="">
                <span class="text">BUY YOUR TOKENS</span>
                <img src="pics/star.svg" alt=""> 
                <span class="text">KHANYISA@CITYOFTSHWANE.CO.ZA</span>
                <img src="pics/star.svg" alt=""> 
                 <span class="text">BUY YOUR TOKENS</span>
                 <img src="pics/star.svg" alt="">
                <span class="text">KHANYISA YOUR HOUSE</span>
                <img src="pics/star.svg" alt=""> 
                <span class="text">BUY YOUR TOKENS</span>
                <img src="pics/star.svg" alt="">
                <span class="text">KHANYISA@CITYOFTSHWANE.CO.ZA</span>
                <img src="pics/star.svg" alt=""> 
                
            </h1>
        </div>

    </div>

    <section class="features">
    <div class="feature-card" id="card1">
        <h3>Buy Tokens</h3>
        <p>Get your electricity tokens instantly after purchase.</p>
    </div>
    <div class="feature-card" id="card2">
        <h3>Automatic Updates</h3>
        <p>Your meter gets updated automatically after buying tokens.</p>
    </div>
    <div class="feature-card" id="card3">
        <h3>Easy Management</h3>
        <p>View your purchase history and manage your meter settings.</p>
    </div>
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
    <script>
    // GSAP Hover Animation
    document.querySelectorAll('.feature-card h3 p').forEach(card => {
        card.addEventListener('mouseenter', () => {
            gsap.to(card, { duration: 0.5, y: -15, ease: "power3.out", boxShadow: "0 12px 24px rgba(0,0,0,0.2)" });
        });
        
        card.addEventListener('mouseleave', () => {
            gsap.to(card, { duration: 0.5, y: 0, ease: "power3.inOut", boxShadow: "0 4px 8px rgba(0,0,0,0.1)" });
        });
    });
</script>

</body>
</html>
