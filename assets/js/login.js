function showPopupNotification(message) {
  const popupNotification = document.getElementById("popupNotification");
  popupNotification.textContent = message;
  popupNotification.classList.remove("hidden");
  popupNotification.classList.add("visible");

  setTimeout(() => {
    popupNotification.classList.add("hidden");
    popupNotification.classList.remove("visible");
  }, 3000);
}

if (window.location.search.includes("error=1")) {
  showPopupNotification("Incorrect username or password.");
}
