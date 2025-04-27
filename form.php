<?php
include '../Login/logout.php';

class FormHandler
{
    public $fullName;
    //clear spaces.
    public function sanitizeInput($input)
    {
        return htmlspecialchars(trim($input));
    }
    //handle submission form.
    public function handleFormSubmission()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->fullName = $this->sanitizeInput($_POST["fullName"] ?? "");
        }
    }
}
//object creation.
$formHandler = new FormHandler();
$formHandler->handleFormSubmission();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Output</title>
    <link rel="stylesheet" href="CSS/index.css">
    <link rel="stylesheet" href="/PHP-Assignment-New/Login/CSS/style.css">
</head>

<body>
    <div class="container">
        <h2>Hello <?php echo $formHandler->fullName; ?></h2>
    </div>
</body>

</html>

