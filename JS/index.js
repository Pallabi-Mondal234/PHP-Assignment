// Update full name automatically
function updateFullname() {
    let firstName = document.getElementById("first-name").value.substring(0, 20);
    let lastName = document.getElementById("last-name").value.substring(0, 20);
    document.getElementById("full-name").value = firstName + " " + lastName;
}


// Restrict name fields to only allow alphabets and one space
function limitNameInput(inputElement) {
    inputElement.addEventListener("input", function () {
        let value = this.value.replace(/[^a-zA-Z ]/g, '');

        let parts = value.split(" ").filter(Boolean);
        value = parts.length > 2 ? parts.slice(0, 2).join(" ") : parts.join(" ");

        this.value = value.slice(0, 20);
    });
}


// Restrict phone input to digits only and limit to 10 digits
document.addEventListener("DOMContentLoaded", function () {
    let firstName = document.getElementById("first-name");
    let lastName = document.getElementById("last-name");

    if (!firstName || !lastName) {
        console.error("Missing input fields");
        return;
    }

    limitNameInput(firstName);
    limitNameInput(lastName);
});

// Validate first and last name
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
    } else if (!namePattern.test(firstName)) {
        firstNameError.textContent = "Only alphabets and one space allowed";
        isValid = false;
    }

    if (lastName === "") {
        lastNameError.textContent = "Last name is required";
        isValid = false;
    } else if (!namePattern.test(lastName)) {
        lastNameError.textContent = "Only alphabets and one space allowed";
        isValid = false;
    }

    if (!isValid) event.preventDefault();
    return isValid;
}

// Main form validation
function formValidate(event) {
    updateFullname();

    let nameValid = isValidName(event);

    if (!nameValid) {
        event.preventDefault();
        return false;
    }

    return true;
}
