<?php
require_once __DIR__ . '/../vendor/autoload.php';

require_once "FormHandler.php";

// Object creation.
$formHandler = new FormHandler();
$formHandler->handleFormSubmission();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Output</title>
  <link rel="stylesheet" href="/../css/index.css">
  <link rel="stylesheet" href="/../css/style.css">
</head>

<body>
  <?php include '../Login/navbar.php'; ?>
  <div class="container">

    <h2>Hello <?php echo $formHandler->fullName; ?></h2>

  </div>
</body>

</html>

