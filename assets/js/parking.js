const totalSpots = 20;
const parkingSpotsContainer = document.getElementById("parking-spots");
const selectedSpotInput = document.getElementById("selected_spot");
const userReservedSpotsContainer = document.getElementById(
  "user-reserved-spots"
);

// Load parking spots from the server
async function loadParkingSpots() {
  const response = await fetch("../src/get_reserved_spots.php");
  const { reservedSpots, userReservedSpots } = await response.json();

  parkingSpotsContainer.innerHTML = "";
  userReservedSpotsContainer.innerHTML = "";

  // Display parking spots as buttons
  for (let i = 1; i <= totalSpots; i++) {
    const spotId = `Spot ${i}`;
    const isReserved = reservedSpots.includes(spotId);

    const spotButton = document.createElement("button");
    spotButton.textContent = spotId;
    spotButton.classList.add(
      "spot-button",
      isReserved ? "reserved" : "available"
    );

    if (isReserved) {
      spotButton.disabled = true; // Disable spots reserved by other users
    } else {
      // Enable spots available or reserved by the current user
      spotButton.addEventListener("click", () => selectSpot(spotId));
    }

    parkingSpotsContainer.appendChild(spotButton);
  }

  // Display user's reserved spots in a list with release option
  if (userReservedSpots.length === 0) {
    // If no reserved spots, display a message
    const noSpotsMessage = document.createElement("p");
    noSpotsMessage.textContent = "No spot reserved.";
    noSpotsMessage.style.textAlign = "center";
    noSpotsMessage.classList.add("no-spots-message");
    userReservedSpotsContainer.appendChild(noSpotsMessage);
  } else {
    // Otherwise, display each reserved spot
    userReservedSpots.forEach((reservation) => {
      const spotDiv = document.createElement("div");
      spotDiv.classList.add("spot");

      const spotNumber = document.createElement("p");
      spotNumber.textContent = reservation.spot;
      spotNumber.classList.add("spot-number");

      const vehicleNumber = document.createElement("p");
      vehicleNumber.textContent = `Vehicle: ${reservation.vehicle_number}`;
      vehicleNumber.classList.add("vehicle-number");

      const releaseButton = document.createElement("button");
      releaseButton.textContent = "Release";
      releaseButton.classList.add("release-button");
      releaseButton.style.fontFamily = "ubuntu";
      releaseButton.onclick = () => releaseSpot(reservation.spot);

      // Append elements to the spot div
      spotDiv.appendChild(spotNumber);
      spotDiv.appendChild(vehicleNumber);
      spotDiv.appendChild(releaseButton);

      // Add spot div to container
      userReservedSpotsContainer.appendChild(spotDiv);
    });
  }
}

// Handle selecting a parking spot
function selectSpot(spotId) {
  selectedSpotInput.value = spotId;
}

// Function to show popup notification
function showPopupNotification(message) {
  const popupNotification = document.getElementById("popupNotification");

  // Set the message for the notification
  popupNotification.textContent = message;

  // Display the notification
  popupNotification.classList.remove("hidden");
  popupNotification.classList.add("visible");

  // Hide the notification after 3 seconds
  setTimeout(() => {
    popupNotification.classList.add("hidden");
    popupNotification.classList.remove("visible");
  }, 3000);
}

// Release a parking spot for other users
async function releaseSpot(spotId) {
  const response = await fetch("../src/release_spot.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({ spot_id: spotId }),
  });

  const result = await response.text();
  if (result === "success") {
    showPopupNotification("Parking spot released successfully!");
    loadParkingSpots(); // Refresh spots after release
  } else {
    showPopupNotification("Failed to release the parking spot.");
  }
}

// Load spots on page load
document.addEventListener("DOMContentLoaded", loadParkingSpots);
