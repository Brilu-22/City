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
            <p id="totalOffices">3</p>
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
        
        // Office locations
        const offices = [
            { name: "Office 1", lat: -25.754, lng: 28.191, consultants: 3 },
            { name: "Office 2", lat: -25.749, lng: 28.205, consultants: 5 },
            { name: "Office 3", lat: -25.762, lng: 28.222, consultants: 2 },
        ];

        function initMap() {
            const map = new google.maps.Map(document.getElementById("map"), {
                center: userLocation,
                zoom: 13,
            });

            // Add a marker for user's location
            new google.maps.Marker({
                position: userLocation,
                map: map,
                icon: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
                title: "Your Location",
            });

            // Initialize the Distance Matrix Service
            const distanceService = new google.maps.DistanceMatrixService();

            // Loop through each office and add a marker
            offices.forEach((office) => {
                const marker = new google.maps.Marker({
                    position: { lat: office.lat, lng: office.lng },
                    map: map,
                    title: office.name,
                });

                // Calculate distances for each office
                calculateDistances(office, distanceService);
            });
        }

        function calculateDistances(office, distanceService) {
            const officeList = document.getElementById("officeList");
            const listItem = document.createElement("li");

            // Get distances
            const request = {
                origins: [userLocation],
                destinations: [{ lat: office.lat, lng: office.lng }],
                travelMode: "WALKING",
                unitSystem: google.maps.UnitSystem.METRIC,
            };

            // Get walking distance
            distanceService.getDistanceMatrix(request, (response, status) => {
                if (status === "OK") {
                    const walkingResult = response.rows[0].elements[0];
                    const walkingDistance = walkingResult.distance ? walkingResult.distance.text : "Unavailable";
                    const walkingDuration = walkingResult.duration ? walkingResult.duration.text : "Unavailable";

                    // Update the travelMode to DRIVING for driving distance
                    request.travelMode = "DRIVING";
                    distanceService.getDistanceMatrix(request, (response, status) => {
                        if (status === "OK") {
                            const drivingResult = response.rows[0].elements[0];
                            const drivingDistance = drivingResult.distance ? drivingResult.distance.text : "Unavailable";
                            const drivingDuration = drivingResult.duration ? drivingResult.duration.text : "Unavailable";

                            // Display office and distance information
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

    <!-- Load Google Maps API with initMap callback -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDFGQlOjM8Q71Izd_QpFl1YVnfP9IKnpKY&callback=initMap" async defer></script>
</body>
</html>
