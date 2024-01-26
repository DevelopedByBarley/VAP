document.addEventListener("DOMContentLoaded", function () {
    const labels = document.querySelectorAll(".required");
  
    console.log(labels);
  
    labels.forEach((label) => {
      const star = document.createElement("span");
      star.textContent = " *";
      star.style.color = "#ec0677";
      label.appendChild(star);
    });
  
    // NAME INPUT VALIDATION
  
    let nameInput = document.getElementById("name");
    let nameInputAlert = document.getElementById("nameInputAlert");
  
    nameInput.addEventListener("input", function () {
      // Név validáció
      const nameValue = this.value.trim();
      const nameParts = nameValue.split(" ");
  
      if (nameValue !== "" && nameParts.length < 2) {
        this.setCustomValidity("A névnek legalább két részletből kell állnia!");
        nameInputAlert.innerHTML =
          "A névnek legalább két részletből kell állnia!";
      } else if (nameValue === "") {
        nameInputAlert.innerHTML = "";
        this.setCustomValidity("Kérlek add meg a nevedet!");
        nameInputAlert.innerHTML = "Kérlek add meg a nevedet!";
      } else {
        this.setCustomValidity("");
        nameInputAlert.innerHTML = "";
      }
  
      checkCurrentValidility(this.checkValidity(), this);
    });
  
    let emailInput = document.getElementById("email");
    let emailInputAlert = document.getElementById("emailInputAlert");
  
    emailInput.addEventListener("input", function () {
      // Email validáció
      const emailValue = this.value.trim();
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  
      if (emailValue === "") {
        this.setCustomValidity("Kérlek add meg az email címedet!");
        emailInputAlert.innerHTML = "Kérlek add meg az email címedet!";
      } else if (!emailRegex.test(emailValue)) {
        this.setCustomValidity("Kérlek adj meg érvényes email címet!");
        emailInputAlert.innerHTML = "Kérlek adj meg érvényes email címet!";
      } else {
        this.setCustomValidity("");
        emailInputAlert.innerHTML = "";
      }
  
      checkCurrentValidility(this.checkValidity(), this);
    });
  

    let addressInput = document.getElementById("address");
    let addressInputAlert = document.getElementById("addressInputAlert");
  
    addressInput.addEventListener("input", function () {
      // Cím validáció
      const addressValue = this.value.trim();
  
      const hasUpperCase = /[A-Z]/.test(addressValue);
      const hasNumber = /\d/.test(addressValue);
      const isLengthValid = addressValue.length >= 5;
  
      if (addressValue === "") {
        this.setCustomValidity("Kérlek add meg a címedet!");
        addressInputAlert.innerHTML = "Kérlek add meg a címedet!";
      } else if (!hasUpperCase || !hasNumber || !isLengthValid) {
        this.setCustomValidity(
          "A címnek legalább 5 karakterből, nagybetűből és számból kell állnia!"
        );
        addressInputAlert.innerHTML =
          "A címnek legalább 5 karakterből, nagybetűből és számból kell állnia!";
      } else {
        this.setCustomValidity("");
        addressInputAlert.innerHTML = "";
      }
  
      checkCurrentValidility(this.checkValidity(), this);
    });
  
    let phoneInput = document.getElementById("phone");
    let phoneInputAlert = document.getElementById("phoneInputAlert");
  
    phoneInput.addEventListener("input", function () {
      // Telefonszám validáció
      const phoneValue = this.value.trim();
      const isLengthValid = phoneValue.length >= 9;
  
      if (phoneValue === "") {
        this.setCustomValidity("Kérlek add meg a telefonszámodat!");
        phoneInputAlert.innerHTML = "Kérlek add meg a telefonszámodat!";
      } else if (!isLengthValid) {
        this.setCustomValidity(
          "A telefonszámnak legalább 9 karakter hosszúnak kell lennie!"
        );
        phoneInputAlert.innerHTML =
          "A telefonszámnak legalább 9 karakter hosszúnak kell lennie!";
      } else {
        this.setCustomValidity("");
        phoneInputAlert.innerHTML = "";
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
  