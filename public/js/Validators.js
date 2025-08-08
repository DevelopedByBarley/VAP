
/**
 * Egyszerűsített validator használat
 * 
 * @example
 * <!-- Alapvető használat -->
 * <input name="email" type="email" data-validate="required|email" />
 * 
 * <!-- Paraméterekkel -->
 * <input name="name" type="text" data-validate="required|min:3|max:50" />
 * 
 * <!-- Jelszó -->
 * <input name="password" type="password" data-validate="required|password" />
 * 
 * <!-- Jelszó megerősítés -->
 * <input name="password_confirm" type="password" data-validate="required|match:password" />
 * 
 * <!-- Telefonszám -->
 * <input name="phone" type="tel" data-validate="required|phone" />
 * 
 * <!-- Csak számok -->
 * <input name="age" type="number" data-validate="required|numeric|min:18|max:99" />
 * 
 * <!-- Teljes név -->
 * <input name="full_name" type="text" data-validate="required|split" />
 * 
 * 
 */

function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(';').shift();
}

console.log(getCookie('lang'));

function validator() {
  console.log('Validator is running!');

  const lang = getCookie('lang') || 'Hu';

  // ================================
  // HIBAÜZENETEK
  // ================================
  const messages = {
    required: {
      En: "This field is required.",
      Hu: "A mező kitöltése kötelező."
    },
    email: {
      En: "Please enter a valid email address.",
      Hu: "Kérem adjon meg érvényes email címet."
    },
    min: {
      En: (value) => `Minimum ${value} characters required.`,
      Hu: (value) => `Legalább ${value} karakter szükséges.`
    },
    max: {
      En: (value) => `Maximum ${value} characters allowed.`,
      Hu: (value) => `Maximum ${value} karakter megengedett.`
    },
    numeric: {
      En: "Only numbers are allowed.",
      Hu: "Csak számok megengedettek."
    },
    phone: {
      En: "Please enter a valid phone number.",
      Hu: "Kérem adjon meg érvényes telefonszámot."
    },
    password: {
      En: "Password must be at least 8 characters with uppercase, lowercase, number and special character.",
      Hu: "A jelszónak legalább 8 karakter hosszúnak kell lennie nagy- és kisbetűvel, számmal és speciális karakterrel."
    },
    match: {
      En: "Passwords do not match.",
      Hu: "A jelszavak nem egyeznek."
    },
    split: {
      En: "Please enter at least two words.",
      Hu: "Kérem adjon meg legalább két szót."
    },
    noSpaces: {
      En: "Spaces are not allowed.",
      Hu: "Szóközök nem megengedettek."
    }
  };

  // ================================
  // VALIDÁTOR SZABÁLYOK
  // ================================
  const validators = {
    required: (value) => value.trim().length > 0,

    email: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value.trim()),

    min: (value, param) => value.trim().length >= parseInt(param),

    max: (value, param) => value.trim().length <= parseInt(param),

    numeric: (value) => /^\d+$/.test(value),

    phone: (value) => /^(?:\+36|06)\d{9}$/.test(value.replace(/[\s\-]/g, '')),

    password: (value) => {
      const pwd = value.trim();
      return pwd.length >= 8 &&
        /[A-Z]/.test(pwd) &&
        /[a-z]/.test(pwd) &&
        /\d/.test(pwd) &&
        /[!@#$%^&*(),.?":{}|<>]/.test(pwd);
    },

    match: (value, param, element) => {
      const matchElement = element.form.querySelector(`[name="${param}"]`);
      return matchElement ? value === matchElement.value : false;
    },

    split: (value) => {
      const parts = value.trim().split(' ').filter(part => part.length > 0);
      return parts.length >= 2;
    },

    noSpaces: (value) => !value.includes(' ')
  };

  // ================================
  // HELPER FÜGGVÉNYEK
  // ================================
  function getMessage(rule, param = null) {
    const msg = messages[rule];
    if (!msg) return "Validation error";

    console.log(lang);

    console.log(msg[lang]);;


    if (typeof msg[lang] === 'function') {
      return msg[lang](param);
    }


    return msg[lang] || msg.hu || msg.en || "Validation error";
  }

  function parseValidationRules(rulesString) {
    return rulesString.split('|').map(rule => {
      const [name, param] = rule.split(':');
      return { name: name.trim(), param: param?.trim() };
    });
  }

  function validateInput(element, rules) {
    const value = element.value;
    const errors = [];

    rules.forEach(rule => {
      if (validators[rule.name]) {
        const isValid = validators[rule.name](value, rule.param, element);
        if (!isValid) {
          errors.push(getMessage(rule.name, rule.param));
        }
      }
    });

    return errors;
  }

  function createErrorDisplay(element) {
    const errorId = `${element.name}-errors`;
    let errorDiv = document.getElementById(errorId);

    if (!errorDiv) {
      errorDiv = document.createElement('div');
      errorDiv.id = errorId;
      errorDiv.className = 'validation-errors';
      errorDiv.style.cssText = 'color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem;';
      element.parentNode.insertBefore(errorDiv, element.nextSibling);
    }

    return errorDiv;
  }

  function updateValidationState(element, errors) {
    const errorDiv = createErrorDisplay(element);

    // Clear previous errors
    errorDiv.innerHTML = '';

    if (errors.length > 0) {
      // Show errors
      errorDiv.innerHTML = errors.map(error => `<div>${error}</div>`).join('');
      element.style.borderColor = '#dc3545';
      element.style.boxShadow = '0 0 0 0.2rem rgba(220, 53, 69, 0.25)';
      element.setCustomValidity(errors[0]);
    } else {
      // No errors
      element.style.borderColor = '#28a745';
      element.style.boxShadow = '0 0 0 0.2rem rgba(40, 167, 69, 0.25)';
      element.setCustomValidity('');
    }
  }

  // ================================
  // INICIALIZÁLÁS
  // ================================
  const validateElements = document.querySelectorAll('[data-validate]');

  validateElements.forEach(element => {
    const rulesString = element.getAttribute('data-validate');
    const rules = parseValidationRules(rulesString);

    // Input esemény
    element.addEventListener('input', () => {
      const errors = validateInput(element, rules);
      updateValidationState(element, errors);
    });

    // Blur esemény (amikor elhagyja a mezőt)
    element.addEventListener('blur', () => {
      const errors = validateInput(element, rules);
      updateValidationState(element, errors);
    });

    // Match validáció speciális kezelése
    rules.forEach(rule => {
      if (rule.name === 'match' && rule.param) {
        const matchElement = element.form.querySelector(`[name="${rule.param}"]`);
        if (matchElement) {
          matchElement.addEventListener('input', () => {
            const errors = validateInput(element, rules);
            updateValidationState(element, errors);
          });
        }
      }
    });
  });

  // Form submit validáció
  document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', (e) => {
      let hasErrors = false;

      form.querySelectorAll('[data-validate]').forEach(element => {
        const rulesString = element.getAttribute('data-validate');
        const rules = parseValidationRules(rulesString);
        const errors = validateInput(element, rules);

        updateValidationState(element, errors);

        if (errors.length > 0) {
          hasErrors = true;
        }
      });

      if (hasErrors) {
        e.preventDefault();
        console.log('Form submission prevented due to validation errors');
      }
    });
  });
}

validator();