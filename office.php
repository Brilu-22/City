<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office Locations</title>
    <link rel="stylesheet" href="office.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhG2hU7WMUjhOZTbO1xoxy4NZL6boK5I0&libraries=places"></script>
</head>
<body>
    <section class="map-section">
        <h1>Offices Near You</h1>
        <div id="map"></div>
        <div class="distance-info">
            <button id="walking-btn">Walking Distance</button>
            <button id="driving-btn">Driving Distance</button>
            <p id="distance-result"></p>
        </div>
    </section>

    <section class="consultants">
        <h2>Available Consultants</h2>
        <div id="consultant-list">
            <!-- Consultant availability data will be injected here -->
        </div>
    </section>

    <section class="graphs">
        <h2>Office Metrics</h2>
        <canvas id="visitorsChart"></canvas>
        <canvas id="consultantsChart"></canvas>
    </section>

    <script src="script.js"></script>
</body>
</html>
