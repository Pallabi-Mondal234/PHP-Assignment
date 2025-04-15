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
 * validate image.
 * 
 * @returns boolean 
 *   Return boolean value.
 */
function validateImageUpload() {
  let imageInput = document.getElementById("chooseImg");
  let fileError = document.getElementById("image-error");
  fileError.textContent = "";

  if (!imageInput.files || imageInput.files.length === 0) {
    fileError.textContent = "Please select an image to upload.";
    return false;
  }

  return true;
}

/**
 * validate marks.
 * 
 * @returns boolean 
 *   Return boolean value.
 */
function validateMarks() {
  const marksField = document.getElementById("marks");
  const marksValue = marksField.value.trim();
  const marksError = document.getElementById("marksError");

  marksError.textContent = "";

  if (marksValue === "") {
    marksError.textContent = "Marks input is required.";
    return false;
  }

  const lines = marksValue.split("\n");

  for (let line of lines) {
    line = line.trim();

    // Format must be Subject|Marks with no double pipes or extra symbols
    if (!/^[A-Za-z]+[|][0-9]+$/.test(line)) {
      marksError.textContent = "Each line must be in the format: Subject|Marks (e.g., English|80)";
      return false;
    }

    const [, mark] = line.split("|");
    const numericMark = parseInt(mark, 10);

    // Check for valid integer between 0 and 100
    if (!/^\d+$/.test(mark) || numericMark < 0 || numericMark > 100) {
      marksError.textContent = "Marks must be a whole number between 0 and 100 (no decimals).";
      return false;
    }
  }

  return true;
}

/**
 * Validate Indian phone number only.
 * 
 * @returns boolean 
 *   Return boolean value.
 */
function validatePhoneNumber() {
  let phone = document.getElementById('phone').value.trim();
  let countryCode = document.getElementById('country-code').value;
  let countryError = document.getElementById('country-error');
  let phoneError = document.getElementById('phone-error');
  let phonePattern = /^[6-9]\d{9}$/;

  let isValid = true;
  countryError.textContent = "";
  phoneError.textContent = "";

  if (countryCode !== "+91") {
    countryError.textContent = "Only Indian phone numbers are allowed.";
    isValid = false;
  }

  if (phone === "") {
    phoneError.textContent = "Phone number is required.";
    isValid = false;
  }
  else if (!phonePattern.test(phone)) {
    phoneError.textContent = "Enter a valid 10-digit Indian phone number starting with 6, 7, 8, or 9.";
    isValid = false;
  }

  return isValid;
}

/**
 * check form validation.
 * 
 * @param {*} event 
 */
async function formValidate(event) {
  event.preventDefault();

  updateFullname();

  let nameValid = isValidName(event);
  let imageValid = validateImageUpload();
  let marksValid = validateMarks();
  let phoneValid = validatePhoneNumber();

  if (nameValid && imageValid && marksValid && phoneValid) {
    document.getElementById("form-data").submit();
  }
  else {
    console.log("Validation failed. Form not submitted.");
  }
}

