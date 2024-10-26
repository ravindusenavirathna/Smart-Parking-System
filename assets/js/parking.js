// Array of parking spots (1-20 for example)
const totalSpots = 20;
const parkingSpots = Array.from({ length: totalSpots }, (_, i) => ({
  id: `Spot ${i + 1}`,
  isReserved: Math.random() < 0.3, // Randomly mark some spots as reserved for demonstration
}));

const parkingSpotsContainer = document.getElementById("parking-spots");
const selectedSpotInput = document.getElementById("selected_spot");

// Load parking spots
function loadParkingSpots() {
  parkingSpotsContainer.innerHTML = "";
  parkingSpots.forEach((spot) => {
    const spotButton = document.createElement("button");
    spotButton.textContent = spot.id;
    spotButton.classList.add(
      "spot-button",
      spot.isReserved ? "reserved" : "available"
    );
    spotButton.disabled = spot.isReserved;

    if (!spot.isReserved) {
      spotButton.addEventListener("click", () => selectSpot(spot.id));
    }

    parkingSpotsContainer.appendChild(spotButton);
  });
}

// Handle selecting a parking spot
function selectSpot(spotId) {
  selectedSpotInput.value = spotId;
}

// Load spots on page load
document.addEventListener("DOMContentLoaded", loadParkingSpots);
