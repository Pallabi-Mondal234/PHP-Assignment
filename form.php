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
        echo "<img class=uploadedImg src='$targetFile' alt='Uploaded Image'>";
        return $targetFile;
    } else {
        echo "Error moving uploaded file! Check folder permissions.<br>";
        return "";
    }
}
//create array for marks 
function parseMarks($marksInput)
{
    $marksArray = [];
    $marksPairs = explode(",", sanitizeInput($marksInput));

    foreach ($marksPairs as $pair) {
        $subjectMarks = explode("|", trim($pair));
        if (count($subjectMarks) == 2) {
            $marksArray[trim($subjectMarks[0])] = trim($subjectMarks[1]);
        }
    }
    return $marksArray;
}

//handle form submission
function handleFormSubmission() {
    global $fullName, $marksArray,$phone;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fullName = sanitizeInput($_POST["fullName"] ?? "");
        $phone = sanitizeInput($_POST["phone"] ?? "");
        $marksArray = parseMarks($_POST["addMarks"] ?? "");
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
    <link rel="stylesheet" href="CSS/index.css">
</head>

<body>
    <div class="container">
        <h2>Hello
            <?php echo $fullName ?>
        </h2>

        <h3>Submitted Marks</h3>
        <?php
        echo "<table border='1'>";

        // Print Subject Headers
        foreach ($marksArray as $subject => $marks) {
            echo "<th>$subject</th>";
        }

        echo "</tr>";

        foreach ($marksArray as $marks) {
            echo "<td>$marks</td>";
        }

        echo "</tr></table>";
        ?>
        <p>Phone Number : <?php echo $phone?></p>
    </div>
</body>

</html>

