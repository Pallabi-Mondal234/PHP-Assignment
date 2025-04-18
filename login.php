<?php
session_start();

$usersFile = "users.txt";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = trim($_POST["username"]);
  $password = trim($_POST["password"]);

  header("Content-Type: application/json");

  if (empty($username) || empty($password)) {
    echo json_encode([
      "success" => false,
      "message" => "Username and password are required."
    ]);
    exit();
  }

  $users = file($usersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

  foreach ($users as $user) {
    list($storedUsername, $storedPassword) = explode("|", trim($user));

    if ($storedUsername === $username && $storedPassword === $password) {
      $_SESSION["username"] = $username;

      // Send success and redirect location
      echo json_encode([
        "success" => true,
        "redirect" => "http://myhost.com/PHP-Assignment-New/PHP-Assignment4/"
      ]);
      exit();
    }
  }

  echo json_encode([
    "success" => false,
    "message" => "Incorrect username or password."
  ]);
  exit();
}

