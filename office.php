<?php

require 'includes/connection.php'; // Assuming connection.php is in the includes directory


// Fetch office locations and consultants from the database
$offices = [];
$query = "SELECT departments_location.dept_name AS name, departments_location.latitude AS lat, departments_location.longitude AS lng, COUNT(consultants.consultant_id) AS consultants
          FROM departments_location
          LEFT JOIN consultants ON departments_location.dept_id = consultants.dept_id
          GROUP BY departments_location.dept_id";

$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $offices[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office Locations</title>
    <link rel="stylesheet" href="css/office.css">
</head>
<body>

<header class="site-header">
    <div class="smiley" id="smiley"><img src="pics/k.svg" alt="" width="120" height="120"></div>
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
    <h2>Dashboard</h2>
    <div class="dashboard-container">
        <div class="card">
            <h3>Total Offices</h3>
            <p id="totalOffices"><?php echo count($offices); ?></p>
        </div>
        <div class="card">
            <h3>Active Consultants</h3>
            <p id="activeConsultants">10</p>
        </div>
        <div class="card">
            <h3>Walking Distances</h3>
            <p id="walkingDistance">10 km</p>
        </div>
        <div class="card">
            <h3>Driving Distances</h3>
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

<div id="map" style="height: 500px; width: 100%;"></div>

<div class="office-info">
    <h2>Available Consultants and Distance Information</h2>
    <ul id="officeList">
        <!-- Office data will populate here -->
    </ul>
</div>

<footer>
    <p>&copy; 2024 Meter Box Web App. All rights reserved.</p>
</footer>

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
                            <h3>${office.name}</h3>
                            <p>Consultants available: ${office.consultants}</p>
                            <p>Walking Distance: ${walkingDistance} (${walkingDuration})</p>
                            <p>Driving Distance: ${drivingDistance} (${drivingDuration})</p>
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

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDFGQlOjM8Q71Izd_QpFl1YVnfP9IKnpKY&callback=initMap" async defer></script>
</body>
</html>
