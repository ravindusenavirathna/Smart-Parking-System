function validatePasswords() {
  const password = document.getElementById("password");
  const confirmPassword = document.getElementById("confirm_password");
  const popupNotification = document.getElementById("popupNotification");

  if (password.value !== confirmPassword.value) {
    popupNotification.classList.remove("hidden");
    popupNotification.classList.add("visible");

    password.classList.add("error");
    confirmPassword.classList.add("error");

    setTimeout(() => {
      popupNotification.classList.add("hidden");
      popupNotification.classList.remove("visible");
    }, 3000);

    return false;
  } else {
    password.classList.remove("error");
    confirmPassword.classList.remove("error");
    return true;
  }
}
