document.addEventListener("DOMContentLoaded", function () {
    const labels = document.querySelectorAll(".required");
  
    console.log(labels);
  
    labels.forEach((label) => {
      const star = document.createElement("span");
      star.textContent = " *";
      star.style.color = "#00a79c";
      label.appendChild(star);
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
  
    function checkCurrentValidility(valid, element) {
      if (valid === false) {
        element.style.border = "2px solid #ec0677";
        console.log(element.style);
      } else {
        element.style.border = "2px solid #00a79c";
      }
    }
  });
  