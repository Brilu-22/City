// Define the user's location and offices array globally
const userLocation = { lat: -25.746, lng: 28.188 };
const offices = [
  { name: "Office 1", lat: -25.754, lng: 28.191, consultants: 3 },
  { name: "Office 2", lat: -25.749, lng: 28.205, consultants: 5 },
  { name: "Office 3", lat: -25.762, lng: 28.222, consultants: 2 },
];

// Define the initMap function globally
function initMap() {
  const map = new google.maps.Map(document.getElementById("map"), {
    center: userLocation,
    zoom: 13,
  });

  // Add a marker for the user's location
  new google.maps.Marker({
    position: userLocation,
    map: map,
    icon: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
    title: "Your Location",
  });

  // Initialize Google Maps Services
  const distanceService = new google.maps.DistanceMatrixService();

  // Loop through each office and add a marker to the map
  offices.forEach((office, index) => {
    const marker = new google.maps.Marker({
      position: { lat: office.lat, lng: office.lng },
      map: map,
      title: office.name,
    });

    // Display office details and distance information in the list
    calculateDistances(office, index, distanceService);
  });
}

// Function to calculate walking and driving distances to each office
function calculateDistances(office, index, distanceService) {
  const officeList = document.getElementById("officeList");
  const listItem = document.createElement("li");

  // Calculate walking distance
  distanceService.getDistanceMatrix(
    {
      origins: [userLocation],
      destinations: [{ lat: office.lat, lng: office.lng }],
      travelMode: "WALKING",
    },
    (response, status) => {
      if (status === "OK") {
        const walkingDistance = response.rows[0].elements[0].distance.text;
        const walkingDuration = response.rows[0].elements[0].duration.text;

        // Calculate driving distance
        distanceService.getDistanceMatrix(
          {
            origins: [userLocation],
            destinations: [{ lat: office.lat, lng: office.lng }],
            travelMode: "DRIVING",
          },
          (response, status) => {
            if (status === "OK") {
              const drivingDistance =
                response.rows[0].elements[0].distance.text;
              const drivingDuration =
                response.rows[0].elements[0].duration.text;

              // Populate list item with office info and distance data
              listItem.innerHTML = `
                <h3>${office.name}</h3>
                <p>Consultants available: ${office.consultants}</p>
                <p>Walking Distance: ${walkingDistance} (${walkingDuration})</p>
                <p>Driving Distance: ${drivingDistance} (${drivingDuration})</p>
              `;
              officeList.appendChild(listItem);
            }
          }
        );
      }
    }
  );
}
