<?php
include '../Login/navbar.php';

include '../session_start.php';
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
    <h1>Assignment Three</h1>
    <form id="form-data" action="form.php" method="POST" enctype="multipart/form-data"
      onsubmit="return formValidate(event)">
      <label for="first-name">First Name</label>
      <input type="text" name="firstName" id="first-name" placeholder="First Name" oninput="updateFullname()">
      <span id="first-name-error"></span>
      <label for="last-name">Last Name</label>
      <input type="text" name="lastName" id="last-name" placeholder="Last Name" oninput="updateFullname()">
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
      <button id="submit-btn" type="submit">Submit</button>
    </form>
  </div>
  <script src="js/function.js"></script>
</body>

</html>

