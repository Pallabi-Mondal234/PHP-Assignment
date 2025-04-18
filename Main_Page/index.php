<?php
include 'PHP-Assignment-New/Login/navbar.php';
session_start();

// Redirect to login if not logged in.
if (!isset($_SESSION["username"])) {
  header("Location: http://myhost.com/PHP-Assignment-New/Login/index.php");
  exit();
}

// Check if query param ?q=4 exists.
if (isset($_GET["q"])) {
  $q = intval($_GET["q"]);
  $web_path = "/PHP-Assignment-New/PHP-Assignment$q/";

  // Real file system path to check existence.
  $server_path = $_SERVER["DOCUMENT_ROOT"] . $web_path;

  if (is_dir($server_path)) {
    header("Location: $webPath");
    exit();
  }
  else {
    echo "Assignment folder 'PHP-Assignment$q' not found on server.<br>";
    echo "Checked path: <code>$server_path</code>";
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="/PHP-Assignment-New/Login/CSS/style.css">
</head>

<body>
  <nav>
    <a href="http://myhost.com/PHP-Assignment-New/Login/">Login</a>
  </nav>
  <div class="content-wrapper">
    <div class="content">
      <h2>Welcome to My PHP <span>Assignment Portal</span></h2>
      <p>Visit <code>?q=1</code> to <code>?q=6</code> to open an assignment.</p>
    </div>
  </div>
</body>

</html>

