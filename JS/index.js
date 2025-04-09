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
    let phoneInput = document.getElementById("phone");

    if (!firstName || !lastName || !phoneInput) {
        console.error("Missing input fields");
        return;
    }

    limitNameInput(firstName);
    limitNameInput(lastName);

    phoneInput.addEventListener("input", function () {
        let digitsOnly = this.value.replace(/\D/g, '');
        this.value = digitsOnly.slice(0, 10);
    });
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

//validate image
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

//validate marks
function validateMarks() {
    const marksField = document.getElementById("marks");
    const marksValue = marksField.value.trim();
    const marksError = document.getElementById("marksError");

    marksError.textContent = ""; // Clear previous error

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

// Validate Indian phone number only
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
    } else if (!phonePattern.test(phone)) {
        phoneError.textContent = "Enter a valid 10-digit Indian phone number starting with 6, 7, 8, or 9.";
        isValid = false;
    }

    return isValid;
}

// Validate email format and check existence
async function validateEmail() {
    let email = document.getElementById('email').value.trim();
    let emailError = document.getElementById('mail-error');
    let successMessage = document.getElementById('success-message');
    let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    emailError.textContent = "";
    successMessage.textContent = "";

    if (email === "") {
        emailError.textContent = "Email-id is required.";
        return false;
    } else if (!emailPattern.test(email)) {
        emailError.textContent = "Invalid email syntax.";
        return false;
    }

    try {
        const formData = new FormData();
        formData.append("email", email);

        const response = await fetch("form.php", {
            method: "POST",
            body: formData
        });

        const data = await response.json();
        if (data.valid) {
            successMessage.textContent = "Valid email syntax and exists.";
            return true;
        } else {
            emailError.textContent = "This email address does not exist.";
            return false;
        }
    } catch (error) {
        emailError.textContent = "Error checking email. Try again.";
        return false;
    }
}


// Main form validation
async function formValidate(event) {
    event.preventDefault(); // Prevent form submission first

    updateFullname();

    let nameValid = isValidName(event);
    let imageValid = validateImageUpload();
    let marksValid = validateMarks();
    let phoneValid = validatePhoneNumber();
    let emailValid = await validateEmail();

    if (nameValid && imageValid && phoneValid && emailValid && marksValid) {
        document.getElementById("form-data").submit();
    } else {
        console.log("Validation failed. Form not submitted.");
    }
}

