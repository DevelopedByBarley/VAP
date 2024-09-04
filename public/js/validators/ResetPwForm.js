document.addEventListener("DOMContentLoaded", function () {
  const labels = document.querySelectorAll(".required");


  const lang = getCookie('lang');

  const text = {
    passwordText: {
      0: {
        Hu: "A jelszónak legalább 8 karakterből, kis- és nagybetűből, valamint számból kell állnia!",
        En: "The password must consist of at least 8 characters, uppercase and lowercase letters, and numbers!"
      },
      1: {
        Hu: "Kérlek add meg a jelszavadat!",
        En: "Please enter your password!"
      },
      2: {
        Hu: "A két jelszó értéknek meg kell egyeznie!",
        En: "The two password values ​​must match"
      },
    },
  }

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
        text.passwordText[0][lang]
      );
      pwInputAlert.innerHTML =
        text.passwordText[0][lang]
    } else if (passwordValue === "") {
      this.setCustomValidity(text.passwordText[1][lang]);
      pwInputAlert.innerHTML = text.passwordText[1][lang];
    } else {
      this.setCustomValidity("");
      pwInputAlert.innerHTML = "";
    }

    checkCurrentValidility(this.checkValidity(), this);
  });

  pwRepeat.addEventListener("input", function () {
    if (pwInput.value !== this.value) {
      console.log("Hello");
      this.setCustomValidity(text.passwordText[2][lang]);
      pwRepeatInputAlert.innerHTML = text.passwordText[2][lang];
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
