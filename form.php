<?php

class FormHandler
{
    public $fullName;

    public function sanitizeInput($input)
    {
        return htmlspecialchars(trim($input));
    }

    public function handleFormSubmission()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->fullName = $this->sanitizeInput($_POST["fullName"] ?? "");
        }
    }
}

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
</head>

<body>
    <div class="container">
        <h2>Hello <?php echo $formHandler->fullName; ?></h2>
    </div>
</body>

</html>

