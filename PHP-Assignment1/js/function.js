/**
 * Update full name automatically. 
 * */
function updateFullname() {
  let firstName = document.getElementById("first-name").value.substring(0, 20);
  let lastName = document.getElementById("last-name").value.substring(0, 20);
  document.getElementById("full-name").value = firstName + " " + lastName;
}

/**
 *Restrict name fields to only allow alphabets and one space.
 *
 *@param string  inputElement
 *  Take user input. 
 */
function limitNameInput(inputElement) {
  inputElement.addEventListener("input", function () {
    let value = this.value.replace(/[^a-zA-Z ]/g, '');

    let parts = value.split(" ").filter(Boolean);
    value = parts.length > 2 ? parts.slice(0, 2).join(" ") : parts.join(" ");

    this.value = value.slice(0, 20);
  });
}

/**
 * Initializes input field and add validation of phone. 
 */
document.addEventListener("DOMContentLoaded", function () {

  let firstName = document.getElementById("first-name");
  let lastName = document.getElementById("last-name");
  let phoneInput = document.getElementById("phone");

  if (!firstName || !lastName || !phoneInput) {
    console.error("Missing input fields");
    return;
  }

  limitNameInput(firstName);
  limitNameInput(lastName);
});

/**
 * Validate first and last name.
 * 
 * @param {*} event 
 * 
 * @returns bolean.
 *   Return boolean value.
 */
function isValidName(event) {
  let firstName = document.getElementById("first-name").value.trim();
  let lastName = document.getElementById("last-name").value.trim();
  let firstNameError = document.getElementById("first-name-error");
  let lastNameError = document.getElementById("last-name-error");
  let namePattern = /^[A-Za-z]+(?: [A-Za-z]+)?$/;

  let isValid = true;
  firstNameError.textContent = "";
  lastNameError.textContent = "";

  if (firstName === "") {
    firstNameError.textContent = "First name is required";
    isValid = false;
  }
  else if (!namePattern.test(firstName)) {
    firstNameError.textContent = "Only alphabets and one space allowed";
    isValid = false;
  }

  if (lastName === "") {
    lastNameError.textContent = "Last name is required";
    isValid = false;
  }
  else if (!namePattern.test(lastName)) {
    lastNameError.textContent = "Only alphabets and one space allowed";
    isValid = false;
  }

  if (!isValid) event.preventDefault();
  return isValid;
}

/**
 * Check form validation.
 * 
 * @param {*} event 
 */
async function formValidate(event) {
  event.preventDefault();

  updateFullname();

  let nameValid = isValidName(event);

  if (nameValid) {
    document.getElementById("form-data").submit();
  }
  else {
    console.log("Validation failed. Form not submitted.");
  }
}

