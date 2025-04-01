
let error = document.getElementById("first-name-error");
let lerror = document.getElementById("last-name-error");

function updateFullname() {
    let fname = document.getElementById("first-name").value;
    let lname = document.getElementById("last-name").value;
    document.getElementById("full-name").value =
        fname + " " + lname;
}

function isValidName(event) {
    let fname = document.getElementById("first-name").value;
    let lname = document.getElementById("last-name").value;
    let check = /^[A-Za-z]+$/;

    if (!check.test(fname) && !check.test(lname)) {
        error.textContent = "Only alphabets contain";
        lerror.textContent = "Only alphabets contain";
        event.preventDefault(); // Stop form submission if validation fails
    }
    else if(!check.test(fname)){
        error.textContent = "Only alphabets contain";
        event.preventDefault();
    }
    else if(!check.test(lname)){
        lerror.textContent = "Only alphabets contain";
        event.preventDefault();
    }

}

// Phone number validation
function validatePhoneNumber() {
    let phoneInput = document.getElementById('phone');
    let phone = phoneInput.value;
    let countryCode = document.getElementById('country-code').value;
    let phoneError = document.getElementById('phone-error');
    let submitButton = document.getElementById('submit-btn');

    let regex = /^[6-9]\d{9}$/; // Validates 10-digit Indian phone numbers starting with 6, 7, 8, or 9

    // Reset the error message and disable submit button by default
    phoneError.textContent = "";
    submitButton.disabled = true;

    // Check if the country code is India (+91)
    if (countryCode !== "+91") {
        phoneError.textContent = "Only Indian phone numbers are allowed.";
        return false;
    }

    // Validate phone number
    if (!regex.test(phone)) {
        phoneError.textContent = "Enter a valid 10-digit Indian phone number starting with 6, 7, 8, or 9.";
        return false;
    }

    // If all checks pass, enable the submit button
    submitButton.disabled = false;
    return true;
}

