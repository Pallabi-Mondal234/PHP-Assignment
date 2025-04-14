<?php
require_once "FormHandler.php";

// This handles only AJAX-based email validation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST) && strpos($_SERVER["CONTENT_TYPE"], "application/json") !== false) {
  header('Content-Type: application/json');

  $input = json_decode(file_get_contents("php://input"), true);

  if (!isset($input['email'])) {
    echo json_encode(['valid' => false, 'error' => 'Email not provided']);
    exit;
  }

  $email = $input['email'];

  // Create an instance of FormHandler and call validate
  $formHandler = new FormHandler();
  $isValid = $formHandler->validate($email);

  echo json_encode(['valid' => $isValid]);
  exit;
}

require_once "output.php";   
?>

