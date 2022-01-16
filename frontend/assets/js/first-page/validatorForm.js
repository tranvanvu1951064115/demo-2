import {
  $,
  signUpInputs,
  submitSignFormBtn
} from "../variables.js";

export const validator = {
  arrError: [],

  // Validate for name
  validateName(value) {
    if (value.length < 2 || value.length > 50)
      return "This field have length between 2 to 50 characters";
    const regex = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
    return regex.test(value)
      ? "This field musn't contain special characters"
      : false;
  },

  // Validate for email
  validateEmail(value) {
    var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    return regex.test(value) ? false : "This field must be email";
  },

  // Validate for password
  validatePassword(valuePass, valueRepass) {
    return valuePass !== valueRepass
      ? "Confirm Re-enter incorrect password"
      : undefined;
  },

  // Validate for length of password
  validateForLengthPass(value) {
    return value.length < 6 || value.length > 15
      ? "Password length must be greater than 5 and smaller than 15 "
      : undefined;
  },

  // Push error within array error
  pushError(input, error) {
    if (error) {
      this.arrError.push({
        input,
        error,
      });
    }
  },

  removeError(input) {
    const label = input.previousElementSibling;
    const message = $('.form-group span.errorEmail');
    if(message?.classList.contains('errorEmail')) {
      message.remove();
    }
    label.setAttribute("data-error","");
    label.style.padding = "0 0 10px 0";
  },

  validate() {
    this.arrError = [];
    signUpInputs.forEach((input) => {
      // Input empty
      if (input.value.length == 0) {
        // From 4 is input without value
        this.pushError(input, "This field mustn't empty");
      } else {
        // Validate for username
        if (input.id == "firstName" || input.id == "lastName") {
          const error = this.validateName(input.value);
          this.pushError(input, error);
        }

        // Validate for email
        if (input.id == "email") {
          const error = this.validateEmail(input.value);
          this.pushError(input, error);
        }
        // Validate for password
        if (input.id == "password") {
          // Error With Length
          const error = this.validateForLengthPass(input.value);
          this.pushError(input, error);
        }
        if (input.id == "confirmPassword") {
          // Validate for confirm password
          const error = this.validateForLengthPass(input.value);
          this.pushError(input, error);

          // Validate for confirm
          // Get password value
          const valuePass = $("#password").value;
          // Error for Confirm not same as Pass
          const errorPass = this.validatePassword(valuePass, input.value);
          this.pushError(input, errorPass);
        }
      }
      this.removeError(input);
      // When input is focused, remove error
      input.addEventListener("focus", (e) => {
        this.removeError(input);
      });
    });
  },

  setErrorMessage() {
    // Check validate
    this.validate();
    // Exec when is errored
    const checkError = this.arrError.length;
    if (checkError) {
      this.arrError.forEach((item) => {
        const label = item.input.previousElementSibling;
        label.setAttribute("data-error", item.error);
        label.style.padding = "0 0 30px 0";
      });
    }
    return checkError;
  },

  handleEvents() {
    // Handle for submit button
    submitSignFormBtn.addEventListener("click", (e) => {
      // When error, display error no sumbit form
      if (this.setErrorMessage()) {
        e.preventDefault();
      } else {
        const rememberBtn = document.querySelector('#check[name="remember"]');
        const formSign = document.querySelector('.form-signup-main');
        if(rememberBtn.checked) {
          let arrInput = [];
          [...formSign.querySelectorAll('input:not(input[type="checkbox"])')].forEach(input => {
              arrInput.push({
                name: input.name,
                value: input.value
              })
          })
          arrInput = JSON.stringify(arrInput);
          localStorage.setItem("localSignUp", arrInput);
        } else {
          localStorage.removeItem("localSignUp");
        }
        e.submit();
      }
    });
    
  },

  start() {
    this.handleEvents();
  },
};

