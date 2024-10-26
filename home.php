<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the user's name from session
$userName = isset($_SESSION['name']) ? $_SESSION['name'] : 'User'; // Fallback to 'User' if not set
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/home2.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chicle&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <title>Home - Meter Box Web App</title>
    <style>
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 182, 193, 0.7); /* Light pink color with some transparency */
            display: none; /* Initially hidden */
            z-index: 998; /* Ensure it’s above other elements */
        }

        .menu {
            z-index: 999; /* Ensure menu is above the overlay */
        }

        .slider img {
            filter: invert(100%); /* Change the SVG color to white */
        }
    </style>
</head>
<body>

    <header class="site-header">
        
        <div class="smiley" id="smiley"><img src="pics/k.svg" alt="" width="120" height="120"></div>
    </header>

    <nav class="menu" id="menu">
        <button id="close-btn">&times;</button>
        <a href="home.php">Home</a>
        <a href="tokens.php">Buy Tokens</a>
        <a href="#">Offices</a>
        <a href="#">My Account</a>
        <a href="../logout.php">Logout</a>
    </nav>

    <div id="overlay" class="overlay"></div> <!-- Overlay div -->

    <section class="hero">
        <img src="pics/Top.svg" alt="">
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
                <img src="pics/star.svg" alt="">
                <span class="text">BUY YOUR TOKENS</span>
                <img src="pics/star.svg" alt="">
                <span class="text">KHANYISA YOUR HOUSE</span>
                <img src="pics/star.svg" alt="">
                <span class="text">BUY YOUR TOKENS</span>
                <img src="pics/star.svg" alt="">
                <span class="text">KHANYISA@CITYOFTSHWANE.CO.ZA</span>
                <img src="pics/star.svg" alt="">
                <!-- Add more sliding elements as needed -->
            </h1>
        </div>
    </div>

    <section class="features">
        <div class="feature-card1" id="card1" style="display: flex; justify-content: center; align-items: center; height: 450px;">
            <img src="pics/buy.svg" alt="" style="width: 350px; height: auto;">
            
            
        </div>
        <div class="feature-card2" id="card2" style="display: flex; justify-content: center; align-items: center; height: 450px;">
            <img src="pics/auto.svg" alt="" style="width: 350px; height: auto;">
            <!--<p>Your meter gets updated automatically after buying tokens.</p>-->
        </div>
        <div class="feature-card3" id="card3" style="display: flex; justify-content: center; align-items: center; height: 450px;">
            <img src="pics/easy.svg" alt="" style="width: 350px; height: auto;">
            <!--<p>View your purchase history and manage your meter settings.</p>-->
        </div>
    </section>

    <!-- Hero Section with Welcome Message -->
    <section class="welcome-hero">
        <div class="hero-content">
            <h1>Welcome, <?php echo htmlspecialchars($userName); ?>!</h1>
            <p class="welcome-message">We’re delighted to welcome you to Khanyisa, your go-to platform for managing your electricity needs with ease!
                At Khanyisa, we strive to provide you with a seamless and efficient experience. With our user-friendly interface, you can quickly buy electricity tokens, track your purchase history, and manage your meter settings—all from the comfort of your home.</p>
            <a href="tokens.php" class="hero-btn">Get Started</a>
        </div>
        <img src="pics/Walking Animation.gif" alt="Welcome Image">
    </section>

    <section class="header">
        <div class="header-content">
            <p >We’re delighted to welcome you to Khanyisa, your go-to platform for managing your electricity needs with ease!
                At Khanyisa, we strive to provide you with a seamless and efficient experience. With our user-friendly interface, you can quickly buy electricity tokens, track your purchase history, and manage your meter settings—all from the comfort of your home.</p>
            <a href="tokens.php" class="hero-btn">Get Started</a>
        </div>
        <img src="" alt="Welcome Image">
    </section>

    <footer>
        <p>&copy; 2024 Meter Box Web App. All rights reserved.</p>
    </footer>

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
        // GSAP Animations
        // Load animation (fading in with scale and vertical movement)
        gsap.from("#buy-img, #auto-img, #easy-img", {
            duration: 1.5, 
            y: 50, // Images will rise into place from below
            scale: 0.9, 
            opacity: 0, 
            ease: "power3.out", 
            stagger: 0.3
        });

        // Hover animations for each image
        document.querySelectorAll(".features img").forEach((img) => {
            img.addEventListener("mouseenter", () => {
                gsap.to(img, {
                    duration: 0.6, 
                    scale: 1.1,  // Slightly increase the size
                    y: -10,      // Move upwards on hover
                    ease: "power3.out",
                    boxShadow: "0px 15px 30px rgba(0, 0, 0, 0.1)" // Add soft shadow on hover
                });
            });
            
            img.addEventListener("mouseleave", () => {
                gsap.to(img, {
                    duration: 0.6, 
                    scale: 1,     // Reset to original size
                    y: 0,         // Move back to original position
                    ease: "power3.inOut", 
                    boxShadow: "none" // Remove shadow
                });
            });
        });
    </script>
</body>
</html>
