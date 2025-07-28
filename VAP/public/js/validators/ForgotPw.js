document.addEventListener("DOMContentLoaded", function () {
  const labels = document.querySelectorAll(".required");

  const lang = getCookie('lang');

  const text = {
    emailText: {
      0: {
        Hu: "Kérlek add meg az e-mail címedet!!",
        En: "Please enter your e-mail address!"
      },
      1: {
        Hu: "Kérlek addj meg érvényes e-mail címet!",
        En: "Please enter a valid e-mail address!"
      },
    },
  }

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
      this.setCustomValidity(text.emailText[0][lang]);
      emailInputAlert.innerHTML = text.emailText[0][lang];
    } else if (!emailRegex.test(emailValue)) {
      this.setCustomValidity(text.emailText[1][lang]);
      emailInputAlert.innerHTML = text.emailText[1][lang];
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
