<?php
require_once __DIR__ . '/../../vendor/autoload.php';

require_once "/../FormHandler.php";

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

    <h3>Submitted Marks</h3>
    <table border="1">
      <tr>
        <th>Subject</th>
        <th>Marks</th>
      </tr>
      <?php foreach ($formHandler->marksArray as $subject => $marks): ?>
        <tr>
          <td><?php echo htmlspecialchars($subject); ?></td>
          <td><?php echo htmlspecialchars($marks); ?></td>
        </tr>
      <?php endforeach; ?>
    </table>

    <p>Phone Number: +91<?php echo $formHandler->phone; ?></p>

    <p>
      <?php
        echo "Email is valid: {$formHandler->email}<br>";
      ?>
    </p>

  </div>
</body>

</html>

