<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName=isset($_POST["fullName"])?trim($_POST["fullName"]):"";
    $fullName=htmlspecialchars($fullName);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Output</title>
</head>
<body>
    <h2>Hello
        <?php echo $fullName ?>
    </h2>
</body>
</html>
