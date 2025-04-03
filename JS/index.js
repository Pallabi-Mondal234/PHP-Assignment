let firstNameError = document.getElementById("first-name-error");
let lastNameError = document.getElementById("last-name-error");

//update full name.
function updateFullname() {
    let firstName = document.getElementById("first-name").value;
    let lastName = document.getElementById("last-name").value;
    document.getElementById("full-name").value = firstName + " " + lastName;
}
//check name validation.
function isValidName(event) {
    let firstName = document.getElementById("first-name").value;
    let lastName = document.getElementById("last-name").value;
    let check = /^[A-Za-z]+$/;

    if (!check.test(firstName) && !check.test(lastName)) {
        firstNameError.textContent = "Only alphabets contain";
        lastNameError.textContent = "Only alphabets contain";
        event.preventDefault();
    }
    else if (!check.test(firstName)) {
        firstNameError.textContent = "Only alphabets contain";
        event.preventDefault();
    }
    else if (!check.test(lastName)) {
        lastNameError.textContent = "Only alphabets contain";
        event.preventDefault();
    }
}

// Phone number validation.
function validatePhoneNumber() {
    let phoneInput = document.getElementById('phone');
    let phone = phoneInput.value;
    let countryCode = document.getElementById('country-code').value;
    let phoneError = document.getElementById('phone-error');
    let submitButton = document.getElementById('submit-btn');

    let regex = /^[6-9]\d{9}$/; // Validates 10-digit Indian phone numbers starting with 6, 7, 8, or 9.
    phoneError.textContent = "";
    submitButton.disabled = true;

    // Check if the country code is India (+91).
    if (countryCode !== "+91") {
        phoneError.textContent = "Only Indian phone numbers are allowed.";
        return false;
    }

    // Validate phone number.
    if (!regex.test(phone)) {
        phoneError.textContent = "Enter a valid 10-digit Indian phone number starting with 6, 7, 8, or 9.";
        return false;
    }

    // If all checks pass, enable the submit button.
    submitButton.disabled = false;
    return true;
}
//validate email.
function validateEmail(event) {
    let emailInput = document.getElementById('email').value;
    let emailError = document.getElementById('mail-error');
    let successMessage = document.getElementById('success-message');

    let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    emailError.textContent = "";
    successMessage.textContent = "";

    if (!emailRegex.test(emailInput)) {
        emailError.textContent = "Invalid email syntax";
        successMessage.textContent = "";
        event.preventDefault();
    }
    else {
        successMessage.textContent = "Valid email syntax";
        emailError.textContent = "";
    }
}

//form validate function.
function formValidate() {
    updateFullname();
    isValidName();
    validatePhoneNumber();
    validateEmail();
}



