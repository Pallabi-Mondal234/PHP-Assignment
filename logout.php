<?php
session_start();

// If logout is requested via GET
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: http://myhost.com/PHP-Assignment-New/Login/");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
    <!-- Logout button (anchor tag) -->
    <a href="?logout=true" class="form-logout-btn">Logout</a>
</body>

</html>
