<?php
//clean user input to prevent security
function sanitizeInput($input)
{
    return htmlspecialchars(trim($input));
}
//move image to upload directory
function handleImageUpload($file, $uploadDir = "upload/")
{
    if (!isset($file) || $file["error"] !== 0) {
        echo "No file uploaded or file upload error!";
        return "";
    }

    // Ensure the upload directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $targetFile = $uploadDir . basename($file["name"]);

    // Move file from temp directory to upload folder
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        echo "File uploaded successfully! <br>";
        echo "<img src='$targetFile' alt='Uploaded Image'>";
        return $targetFile;
    } else {
        echo "Error moving uploaded file! Check folder permissions.<br>";
        return "";
    }
}
//handle form submission
function handleFormSubmission()
{
    global $fullName;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fullName = sanitizeInput($_POST["fullName"] ?? "");
        $imagePath = handleImageUpload($_FILES["chooseImg"] ?? []);
    }
}
//function call
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