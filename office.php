<?php
// Start session and include database connection
session_start();
require 'includes/connection.php'; 

// Fetch office locations and consultants from the database
$offices = [];
$query = "SELECT departments_location.dept_name AS name, departments_location.latitude AS lat, departments_location.longitude AS lng, COUNT(consultants.consultant_id) AS consultants
          FROM departments_location
          LEFT JOIN consultants ON departments_location.dept_id = consultants.dept_id
          GROUP BY departments_location.dept_id";

$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $offices[] = $row;
    }
} else {
    echo "Error in query: " . mysqli_error($conn); // Debugging statement
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office Locations</title>
    <link rel="stylesheet" href="css/offices.css">
</head>
<body>

<header class="site-header">
    <div class="smiley" id="smiley"><img src="pics/Kwlogo.svg" alt="" width="120" height="120"></div>
</header>

<nav class="menu" id="menu">
    <button id="close-btn">&times;</button>
    <a href="home.php">Home</a>
    <a href="tokens.php">Buy Tokens</a>
    <a href="office.php">Offices</a>
    <a href="#">My Account</a>
    <a href="../logout.php">Logout</a>
</nav>

<div id="overlay" class="overlay"></div> 

<section class="dashboard">
    <h1>Our Offices</h1>
    <div class="dashboard-container">
        <div class="card">
            <img src="pics/coat.svg" alt="Walking Distances Icon" class="card-icon">
            <h3>Total Offices</h3>
            <p id="totalOffices"><?php echo count($offices); ?></p>
        </div>
        <div class="card">
            <img src="pics/cot.png" alt="Walking Distances Icon" class="card-icon">
            <h3>Reginal Consultants</h3>
            <p id="activeConsultants">10</p>
        </div>
        <div class="card">
            <img src="pics/gauteng.png" alt="Walking Distances Icon" class="card-icon">
            <h3>City Of Tshwane</h3>
            <p id="walkingDistance">10 km</p>
        </div>
        <div class="card">
            <img src="pics/sadc.svg" alt="Walking Distances Icon" class="card-icon">
            <h3>Community Assistance</h3>
            <p id="drivingDistance">15 km</p>
        </div>
    </div>
    <div class="chart-container">
        <canvas id="myChart" width="400" height="200"></canvas>
    </div>
</section>

<div class="header">
    <h1>Nearby Offices and Consultants</h1>
</div>

<div id="map" style="height: 500px; width: 850px; margin-left: 250px; border-radius: 10px;"></div>

<div class="office-info">
    <h2>Available Consultants and Distance Information</h2>
    <ul id="officeList"  class="office-list">
        <!-- Office data will populate here -->
    </ul>
</div>

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
    // User's current location
    const userLocation = { lat: -25.746, lng: 28.188 };

    // Fetch office locations and consultants from PHP
    const offices = <?php echo json_encode($offices); ?>;

    function initMap() {
        const map = new google.maps.Map(document.getElementById("map"), {
            center: userLocation,
            zoom: 13,
        });

        new google.maps.Marker({
            position: userLocation,
            map: map,
            icon: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
            title: "Your Location",
        });

        const distanceService = new google.maps.DistanceMatrixService();

        offices.forEach((office) => {
            const marker = new google.maps.Marker({
                position: { lat: parseFloat(office.lat), lng: parseFloat(office.lng) },
                map: map,
                title: office.name,
            });

            calculateDistances(office, distanceService);
        });
    }

    function calculateDistances(office, distanceService) {
    const officeList = document.getElementById("officeList");
    const listItem = document.createElement("li");

    const request = {
        origins: [userLocation],
        destinations: [{ lat: parseFloat(office.lat), lng: parseFloat(office.lng) }],
        travelMode: "WALKING",
        unitSystem: google.maps.UnitSystem.METRIC,
    };

    distanceService.getDistanceMatrix(request, (response, status) => {
        if (status === "OK") {
            const walkingResult = response.rows[0].elements[0];
            const walkingDistance = walkingResult.distance ? walkingResult.distance.text : "Unavailable";
            const walkingDuration = walkingResult.duration ? walkingResult.duration.text : "Unavailable";

            request.travelMode = "DRIVING";
            distanceService.getDistanceMatrix(request, (response, status) => {
                if (status === "OK") {
                    const drivingResult = response.rows[0].elements[0];
                    const drivingDistance = drivingResult.distance ? drivingResult.distance.text : "Unavailable";
                    const drivingDuration = drivingResult.duration ? drivingResult.duration.text : "Unavailable";

                    listItem.innerHTML = `
                        <a href="office_detail.php?office_name=${office.name}&lat=${office.lat}&lng=${office.lng}&consultants=${office.consultants}">
                            <h3>${office.name}</h3>
                            <p>Consultants available: ${office.consultants}</p>
                            <p>Walking Distance: ${walkingDistance} (${walkingDuration})</p>
                            <p>Driving Distance: ${drivingDistance} (${drivingDuration})</p>
                        </a>
                    `;
                    officeList.appendChild(listItem);
                } else {
                    console.error('Error with driving distance:', status);
                }
            });
        } else {
            console.error('Error with walking distance:', status);
        }
    });
}

</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            gsap.from(card, {
                opacity: 0,
                scale: 0.5,
                duration: 0.5,
                delay: index * 0.1, 
                ease: "back.out(1.7)" 
            });
        });
    });
</script>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDFGQlOjM8Q71Izd_QpFl1YVnfP9IKnpKY&callback=initMap" async defer></script>
</body>
</html>
