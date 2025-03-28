
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
