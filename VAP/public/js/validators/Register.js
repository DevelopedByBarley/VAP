





document.addEventListener("DOMContentLoaded", function () {
  const lang = getCookie('lang');

  const text = {
    nameText: {
      0: {
        Hu: "A névnek legalább két részletből kell állnia!",
        En: "The name must consist of at least two parts!"
      },
      1: {
        Hu: "Kérlek add meg a nevedet!",
        En: "Please enter your name!"
      }
    },
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
    passwordText: {
      0: {
        Hu: "A jelszónak legalább 8 karakterből, kis- és nagybetűből, valamint számból kell állnia!",
        En: "The password must consist of at least 8 characters, uppercase and lowercase letters, and numbers!"
      },
      1: {
        Hu: "Kérlek add meg a jelszavadat!",
        En: "Please enter your password!"
      },
    },
    addressText: {
      0: {
        Hu: "Kérlek add meg a címedet!",
        En: "Please enter your address!"
      },
      1: {
        Hu: "A címnek legalább 5 karakterből, nagybetűből és számból kell állnia!",
        En: "The address must consist of at least 5 characters, capital letters and numbers!"
      },
    },
    mobileText: {
      0: {
        Hu: "Kérlek add meg a telefonszámod!",
        En: "Please enter your phone number!"
      },
      1: {
        Hu: "A telefonszámnak legalább 9 karakter hosszúnak kell lennie!",
        En: "The phone number must be at least 9 characters long!"
      },
    },
  }

  const labels = document.querySelectorAll(".required");


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
      this.setCustomValidity(text.nameText[0][lang]);
      nameInputAlert.innerHTML =
        text.nameText[0][lang];
    } else if (nameValue === "") {
      nameInputAlert.innerHTML = "";
      this.setCustomValidity(text.nameText[1][lang]);
      nameInputAlert.innerHTML = text.nameText[1][lang];
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

    console.log(emailValue.length);
    if (emailValue === "") {
      this.setCustomValidity(text.emailText[0][lang]);
      emailInputAlert.innerHTML = text.emailText[0][lang];
    } else if (!emailRegex.test(emailValue)) {
      this.setCustomValidity(text.emailText[1][lang]);
      emailInputAlert.innerHTML = text.emailText[1][lang];
    } else if (emailValue.length < 11) {
      this.setCustomValidity(text.emailText[1][lang]);
      emailInputAlert.innerHTML = text.emailText[1][lang];
    } else {
      this.setCustomValidity("");
      emailInputAlert.innerHTML = "";
    }

    checkCurrentValidility(this.checkValidity(), this);
  });

  // PASSWORD INPUT VALIDATION

  let pwInput = document.getElementById("password");
  let pwInputAlert = document.getElementById("pwInputAlert");

  if (pwInput) {
    pwInput.addEventListener("input", function () {
      // Név validáció
      // Jelszó validáció
      const passwordValue = this.value.trim();
      console.log(passwordValue);

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
  }

  let addressInput = document.getElementById("address");
  let addressInputAlert = document.getElementById("addressInputAlert");

  addressInput.addEventListener("input", function () {
    // Cím validáció
    const addressValue = this.value.trim();

    const hasUpperCase = /[A-Z]/.test(addressValue);
    const hasNumber = /\d/.test(addressValue);
    const isLengthValid = addressValue.length >= 5;

    if (addressValue === "") {
      this.setCustomValidity(text.addressText[0][lang]);
      addressInputAlert.innerHTML = text.addressText[0][lang];
    } else if (!hasUpperCase || !hasNumber || !isLengthValid) {
      this.setCustomValidity(
        text.addressText[1][lang]
      );
      addressInputAlert.innerHTML =
        text.addressText[1][lang];
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
      this.setCustomValidity(text.mobileText[0][lang]);
      phoneInputAlert.innerHTML = text.mobileText[0][lang];
    } else if (!isLengthValid) {
      this.setCustomValidity(
        text.mobileText[1][lang]
      );
      phoneInputAlert.innerHTML =
      text.mobileText[1][lang]
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
