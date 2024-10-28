const totalSpots = 20;
const parkingSpotsContainer = document.getElementById("parking-spots");
const selectedSpotInput = document.getElementById("selected_spot");
const userReservedSpotsContainer = document.getElementById(
  "user-reserved-spots"
);
const previousReservationsContainer = document.getElementById(
  "previous-reservations"
);

// Load parking spots from the server
async function loadParkingSpots() {
  const response = await fetch("../src/get_reserved_spots.php");
  const {
    reservedSpots,
    userReservedSpots,
    previousReservations = [],
  } = await response.json();

  parkingSpotsContainer.innerHTML = "";
  userReservedSpotsContainer.innerHTML = "";
  previousReservationsContainer.innerHTML = "";

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
      spotButton.disabled = true;
    } else {
      spotButton.addEventListener("click", () => selectSpot(spotId));
    }

    parkingSpotsContainer.appendChild(spotButton);
  }

  // Display user's reserved spots in a list with release option
  if (userReservedSpots.length === 0) {
    const noSpotsMessage = document.createElement("p");
    noSpotsMessage.textContent = "No spot reserved.";
    noSpotsMessage.style.textAlign = "left";
    noSpotsMessage.classList.add("no-spots-message");
    userReservedSpotsContainer.appendChild(noSpotsMessage);
  } else {
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

      spotDiv.appendChild(spotNumber);
      spotDiv.appendChild(vehicleNumber);
      spotDiv.appendChild(releaseButton);

      userReservedSpotsContainer.appendChild(spotDiv);
    });
  }

  // Display user's previous reservations
  if (previousReservations.length === 0) {
    const noPreviousSpotsMessage = document.createElement("p");
    noPreviousSpotsMessage.textContent = "No previous reservations.";
    noPreviousSpotsMessage.style.textAlign = "left";
    noPreviousSpotsMessage.classList.add("no-spots-message");
    previousReservationsContainer.appendChild(noPreviousSpotsMessage);
  } else {
    previousReservations.forEach((reservation) => {
      const spotDiv = document.createElement("div");
      spotDiv.classList.add("spot");

      const spotNumber = document.createElement("p");
      spotNumber.textContent = `Spot: ${reservation.spot}`;
      spotNumber.classList.add("spot-number");

      const vehicleNumber = document.createElement("p");
      vehicleNumber.textContent = `Vehicle: ${reservation.vehicle_number}`;
      vehicleNumber.classList.add("vehicle-number");

      const releaseTime = document.createElement("p");
      releaseTime.textContent = `Released on: ${reservation.release_time}`;
      releaseTime.classList.add("release-time");

      spotDiv.appendChild(spotNumber);
      spotDiv.appendChild(vehicleNumber);
      spotDiv.appendChild(releaseTime);

      previousReservationsContainer.appendChild(spotDiv);
    });
  }
}

// Handle selecting a parking spot
function selectSpot(spotId) {
  selectedSpotInput.value = spotId;
}

// Function to show popup notification
function showPopupNotification(message, color = "green") {
  const popupNotification = document.getElementById("popupNotification");

  popupNotification.textContent = message;
  popupNotification.style.backgroundColor = color;

  popupNotification.classList.remove("hidden");
  popupNotification.classList.add("visible");

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
    showPopupNotification("Parking spot released successfully!", "#4CAF50");
    loadParkingSpots();
  } else {
    showPopupNotification("Failed to release the parking spot.", "#D32F2F");
  }
}

document.addEventListener("DOMContentLoaded", loadParkingSpots);
