<?php
include '../Login/navbar.php';
session_start();

if (!isset($_SESSION["username"])) {
  header("Location: ../Login");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form</title>
  <link rel="stylesheet" href="/../css/index.css">
  <link rel="stylesheet" href="/../css/style.css">
</head>

<body>
  <div class="container">
    <h1>Assignment Six</h1>
    <form id="form-data" action="output.php" method="POST" enctype="multipart/form-data"
      onsubmit="return formValidate(event)">
      <label for="first-name">First Name</label>
      <input type="text" name="firstName" id="first-name" placeholder="First Name" maxlength="20"
        oninput="updateFullname()">
      <span id="first-name-error"></span>
      <label for="last-name">Last Name</label>
      <input type="text" name="lastName" id="last-name" placeholder="Last Name" maxlength="20"
        oninput="updateFullname()">
      <span id="last-name-error"></span>
      <label for="full-name">Full Name</label>
      <input type="text" name="fullName" id="full-name" placeholder="Full Name" readonly>
      <label for="chooseImg">Select Image</label>
      <input type="file" name="chooseImg" id="chooseImg">
      <span id="image-error"></span>
      <!-- Enter obtained marks -->
      <label for="marks">Enter Marks</label>
      <textarea name="addMarks" id="marks" placeholder="Enter marks like: Subject|Marks (e.g., English|80)"></textarea>
      <span id="marksError"></span>
      <!-- Enter phone number -->
      <label for="phone">Enter Phone Number</label>
      <div class="phone-wrapper">
        <select id="country-code" name="country-code">
          <option value="+91">+91</option>
          <option value="+1">+1</option>
          <option value="+44">+44</option>
          <option value="+61">+61</option>
          <option value="+81">+81</option>
        </select>
        <input type="tel" name="phone" id="phone" placeholder="Phone Number">
      </div>
      <span id="country-error" class="error"></span>
      <span id="phone-error" class="error"></span>
      <!-- Enter email id -->
      <label for="email">Email-id</label>
      <input type="text" name="email" id="email" placeholder="Enter Mail Id">
      <span id="mail-error"></span>
      <span id="success-message"></span>
      <button id="submit-btn">Submit</button>
    </form>
  </div>
  <script src="/../js/index.js"></script>
</body>

</html>

