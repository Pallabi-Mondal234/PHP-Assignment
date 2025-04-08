<?php

class FormHandler
{
    private $uploadDir = "upload/";

    public $fullName;

    public function sanitizeInput($input)
    {
        return htmlspecialchars(trim($input));
    }

    public function handleImageUpload($file)
    {
        if (!isset($file) || $file["error"] !== 0) {
            echo "No file uploaded or file upload error!";
            return "";
        }

        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }

        $targetFile = $this->uploadDir . basename($file["name"]);

        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            echo "<img class=uploadedImg src='$targetFile' alt='Uploaded Image'>";
            return $targetFile;
        } else {
            echo "Error moving uploaded file! Check folder permissions.<br>";
            return "";
        }
    }

    public function handleFormSubmission()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->fullName = $this->sanitizeInput($_POST["fullName"] ?? "");
            $imagePath = $this->handleImageUpload($_FILES["chooseImg"] ?? []);
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

