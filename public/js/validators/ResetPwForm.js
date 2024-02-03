document.addEventListener("DOMContentLoaded", function () {
  const labels = document.querySelectorAll(".required");

  console.log(labels);

  labels.forEach((label) => {
    const star = document.createElement("span");
    star.textContent = " *";
    star.style.color = "#00a79c";
    label.appendChild(star);
  });

  let pwInput = document.getElementById("password");
  let pwInputAlert = document.getElementById("pwInputAlert");
  let pwRepeatInputAlert = document.getElementById("pwRepeatInputAlert");
  let pwRepeat = document.getElementById("pwRepeat");

  pwInput.addEventListener("input", function () {
    // Név validáció
    // Jelszó validáció
    const passwordValue = this.value.trim();
    console.log(passwordValue);

    console.log(this);

    const hasUpperCase = /[A-Z]/.test(passwordValue);
    const hasLowerCase = /[a-z]/.test(passwordValue);
    const hasNumber = /\d/.test(passwordValue);
    const isLengthValid = passwordValue.length >= 8;

    if (
      passwordValue !== "" &&
      (!hasUpperCase || !hasLowerCase || !hasNumber || !isLengthValid)
    ) {
      this.setCustomValidity(
        "A jelszónak legalább 8 karakterből, kis- és nagybetűből, valamint számból kell állnia!"
      );
      pwInputAlert.innerHTML =
        "A jelszónak legalább 8 karakterből, kis- és nagybetűből, valamint számból kell állnia!";
    } else if (passwordValue === "") {
      this.setCustomValidity("Kérlek add meg a jelszavadat!");
      pwInputAlert.innerHTML = "Kérlek add meg a jelszavadat!";
    } else {
      this.setCustomValidity("");
      pwInputAlert.innerHTML = "";
    }

    checkCurrentValidility(this.checkValidity(), this);
  });

  pwRepeat.addEventListener("input", function () {
    if (pwInput.value !== this.value) {
      console.log("Hello");
      this.setCustomValidity("A két jelszó értéknek meg kell egyeznie");
      pwRepeatInputAlert.innerHTML = "A két jelszó értéknek meg kell egyeznie";
    } else {
        this.setCustomValidity("");
        pwRepeatInputAlert.innerHTML = "";
    }

    checkCurrentValidility(this.checkValidity(), this);
  });

  function checkCurrentValidility(valid, element) {
    if (valid === false) {
      element.style.border = "2px solid #ec0677";
      console.log(element.style);
    } else {
      element.style.border = "2px solid #00a79c";
    }
  }
});
