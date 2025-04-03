let firstNameError = document.getElementById("first-name-error");
let lastNameError = document.getElementById("last-name-error");

//update full name
function updateFullname() {
    let firstName = document.getElementById("first-name").value;
    let lastName = document.getElementById("last-name").value;
    document.getElementById("full-name").value = firstName + " " + lastName;
}
//check name validation
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
//form validate function
function formValidate(){
    updateFullname();
    isValidName();
}

