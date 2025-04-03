<?php
//clean user input to prevent security
function sanitizeInput($input)
{
    return htmlspecialchars(trim($input));
}
//handle the submission of form
function handleFormSubmission()
{
    global $fullName;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fullName = sanitizeInput($_POST["fullName"] ?? "");
    }
}
handleFormSubmission();
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
