<?php
session_start();
require 'includes/connection.php';

$office_name = $_GET['office_name'];
$lat = $_GET['lat'];
$lng = $_GET['lng'];
$consultants_count = $_GET['consultants'];

// Fetch consultants for this office
$consultants = [];
$query = "SELECT * FROM consultants WHERE dept_id = (SELECT dept_id FROM departments_location WHERE dept_name = ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $office_name);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $consultants[] = $row;
}

// Fetch department details
$departments_location = [];
$query_dept = "SELECT * FROM departments_location WHERE dept_name = ?";
$stmt_dept = $conn->prepare($query_dept);
$stmt_dept->bind_param("s", $office_name);
$stmt_dept->execute();
$result_dept = $stmt_dept->get_result();
if ($row_dept = $result_dept->fetch_assoc()) {
    $departments_location = $row_dept; // Store department details
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($office_name); ?> Details</title>
    <link rel="stylesheet" href="css/detail.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            margin: 20px;
        }
        #map {
            height: 500px;
            width: 60%;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        .consultants-container {
            width: 40%;
            display: flex;
            flex-direction: column;
            padding-left: 20px;
        }
        .consultant-images {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .consultant-card {
            flex: 1 1 45%;
            margin: 10px 0;
            background: #fff;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .consultant-card img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
        }
        .consultant-details {
            margin-top: 20px;
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
        <a href="office.php">Offices</a>
        <a href="#">My Account</a>
        <a href="../logout.php">Logout</a>
    </nav>

    <div id="overlay" class="overlay"></div> 
    <div class="container">
        <div id="map"></div>
        <div class="consultants-container">
            <div class="consultant-images">
                <?php foreach ($consultants as $consultant): ?>
                    <div class="consultant-card">
                        <img src="consultant_images/<?php echo htmlspecialchars($consultant['consultant_id']); ?>.jpg" alt="Consultant Image">
                        <h3><?php echo htmlspecialchars($consultant['name']); ?></h3>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="consultant-details">
                <h2>Consultants Information</h2>
                <ul>
                    <?php foreach ($consultants as $consultant): ?>
                        <li>
                            <h3><?php echo htmlspecialchars($consultant['name']); ?></h3>
                            <p>ID: <?php echo htmlspecialchars($consultant['consultant_id']); ?></p>
                            <p>Department Address: <?php echo htmlspecialchars($departments_location['address'] ?? 'N/A'); ?></p>
                            <p>Department Name: <?php echo htmlspecialchars($departments_location['dept_name'] ?? 'N/A'); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
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
        const userLocation = { lat: -25.746, lng: 28.188 };
        const officeLocation = { lat: <?php echo $lat; ?>, lng: <?php echo $lng; ?> };

        function initMap() {
            const map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: (userLocation.lat + officeLocation.lat) / 2,
                    lng: (userLocation.lng + officeLocation.lng) / 2,
                },
                zoom: 10, // Zoomed out to show both points
            });

            const userMarker = new google.maps.Marker({
                position: userLocation,
                map: map,
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    scale: 10,
                    fillColor: "#00f",
                    fillOpacity: 1,
                    strokeColor: "#fff",
                    strokeWeight: 2
                },
                title: "Your Location",
            });

            const officeMarker = new google.maps.Marker({
                position: officeLocation,
                map: map,
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    scale: 10,
                    fillColor: "#f00",
                    fillOpacity: 1,
                    strokeColor: "#fff",
                    strokeWeight: 2
                },
                title: "<?php echo $office_name; ?>",
            });

            const line = new google.maps.Polyline({
                path: createSquigglyLine(userLocation, officeLocation, 10), // Use squiggly function from before
                geodesic: true,
                strokeColor: "#FF0000",
                strokeOpacity: 1.0,
                strokeWeight: 4,
            });

            line.setMap(map);
            animateLine(line);
        }

        function createSquigglyLine(start, end, pointsCount) {
            const points = [];
            const amplitude = 0.0002; // Adjust for more or less squiggle
            const step = 1 / (pointsCount - 1);
            for (let i = 0; i < pointsCount; i++) {
                const t = i * step;
                const lat = start.lat + (end.lat - start.lat) * t + (Math.random() * amplitude - amplitude / 2);
                const lng = start.lng + (end.lng - start.lng) * t + (Math.random() * amplitude - amplitude / 2);
                points.push({ lat, lng });
            }
            return points;
        }

        function animateLine(line) {
            const path = line.getPath();
            const length = path.getLength();
            let index = 0;

            function step() {
                const start = index % length;
                const end = (start + 1) % length;
                line.setPath([path.getAt(start), path.getAt(end)]);
                index++;
                if (index < length * 10) { // Increase the iterations for smoother animation
                    requestAnimationFrame(step);
                }
            }
            requestAnimationFrame(step);
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDFGQlOjM8Q71Izd_QpFl1YVnfP9IKnpKY&callback=initMap" async defer></script>
</body>
</html>
