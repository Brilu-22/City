// Initialize Google Map with nearby office pins
function initMap() {
  const map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: -25.746, lng: 28.188 },
    zoom: 12,
  });

  const offices = [
    { lat: -25.746, lng: 28.188, title: "Office 1" },
    { lat: -25.753, lng: 28.197, title: "Office 2" },
    // Add more office locations here
  ];

  offices.forEach((office) => {
    const marker = new google.maps.Marker({
      position: office,
      map,
      title: office.title,
    });
  });
}

// Load walking or driving distance
document.getElementById("walking-btn").addEventListener("click", () => {
  calculateDistance("WALKING");
});

document.getElementById("driving-btn").addEventListener("click", () => {
  calculateDistance("DRIVING");
});

function calculateDistance(mode) {
  const service = new google.maps.DistanceMatrixService();
  service.getDistanceMatrix(
    {
      origins: [{ lat: -25.746, lng: 28.188 }], // User's location
      destinations: [{ lat: -25.753, lng: 28.197 }], // Example office
      travelMode: mode,
    },
    (response, status) => {
      if (status === "OK") {
        const result = response.rows[0].elements[0];
        document.getElementById(
          "distance-result"
        ).textContent = `${result.distance.text} (${result.duration.text})`;
      }
    }
  );
}

// Chart.js for graphing visitor and consultant metrics
const ctx1 = document.getElementById("visitorsChart").getContext("2d");
new Chart(ctx1, {
  type: "bar",
  data: {
    labels: ["Mon", "Tue", "Wed", "Thu", "Fri"],
    datasets: [
      {
        label: "Visitors",
        data: [10, 20, 30, 40, 50],
        backgroundColor: "rgba(255, 99, 132, 0.2)",
        borderColor: "rgba(255, 99, 132, 1)",
        borderWidth: 1,
      },
    ],
  },
});

const ctx2 = document.getElementById("consultantsChart").getContext("2d");
new Chart(ctx2, {
  type: "line",
  data: {
    labels: ["Mon", "Tue", "Wed", "Thu", "Fri"],
    datasets: [
      {
        label: "Available Consultants",
        data: [2, 3, 5, 1, 4],
        backgroundColor: "rgba(54, 162, 235, 0.2)",
        borderColor: "rgba(54, 162, 235, 1)",
        borderWidth: 1,
      },
    ],
  },
});

// Load the map
window.onload = initMap;
