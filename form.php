<?php

class FormHandler
{
    private $uploadDir = "upload/";

    public $fullName;
    public $marksArray = [];

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

    public function parseMarks($marksInput)
    {
        $marksArray = [];
        $marksLines = preg_split("/\r\n|\n|\r/", trim($marksInput));

        foreach ($marksLines as $line) {
            $subjectMarks = explode("|", trim($line));
            if (count($subjectMarks) === 2) {
                $subject = htmlspecialchars(trim($subjectMarks[0]));
                $marks = htmlspecialchars(trim($subjectMarks[1]));
                $marksArray[$subject] = $marks;
            }
        }

        return $marksArray;
    }

    public function handleFormSubmission()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->fullName = $this->sanitizeInput($_POST["fullName"] ?? "");
            $this->marksArray = $this->parseMarks($_POST["addMarks"] ?? "");
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

        <h3>Submitted Marks</h3>
        <table border="1">
            <tr>
                <th>Subject</th>
                <th>Marks</th>
            </tr>
            <?php foreach ($formHandler->marksArray as $subject => $marks): ?>
                <tr>
                    <td><?php echo htmlspecialchars($subject); ?></td>
                    <td><?php echo htmlspecialchars($marks); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>

