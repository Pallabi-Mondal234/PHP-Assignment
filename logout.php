<?php
session_start();
session_unset();
session_destroy();

header("Location: /PHP-Assignment-New/Login/");
exit();
?>

