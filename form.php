<?php
require __DIR__ . '/../../vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

//clean user input to prevent security.
function sanitizeInput($input)
{
    return htmlspecialchars(trim($input));
}
//move image to upload directory.
function handleImageUpload($file, $uploadDir = "upload/")
{
    if (!isset($file) || $file["error"] !== 0) {
        echo "No file uploaded or file upload error!";
        return "";
    }

    // Ensure the upload directory exists.
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $targetFile = $uploadDir . basename($file["name"]);

    // Move file from temp directory to upload folder.
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        echo "<img class=uploadedImg src='$targetFile' alt='Uploaded Image'>";
        return $targetFile;
    } else {
        echo "Error moving uploaded file! Check folder permissions.<br>";
        return "";
    }
}
//create array for marks. 
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
//validate email with the help of API.
function validateEmailWithAPI($email)
{
    $apiKey = "3803df1be2a145bd9ddde411d50c0144";
    $url = "http://apilayer.net/api/check?access_key=" . urlencode($apiKey) . "&email=" . urlencode($email);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $response = curl_exec($ch);
    if ($response === false) {
        return false;
    }

    curl_close($ch);
    $data = json_decode($response, true);

    return isset($data['smtp_check']) && $data['smtp_check'] === true;
}
//generate and store in doc format.
function generateAndStoreDoc($fullName, $phone, $email, $marksArray, $imagePath = '', $uploadPath = "submissions/") {
    if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0777, true);
    }
    
    $fileName = $uploadPath . time() . "_User_Details.docx";
    $phpWord = new PhpWord();
    $section = $phpWord->addSection();

    $section->addText("User Submission Details", ['bold' => true, 'size' => 16, 'underline' => 'single']);
    $section->addTextBreak(1);
    $section->addText("Full Name: " . $fullName, ['size' => 12]);
    $section->addText("Phone: " . $phone, ['size' => 12]);
    $section->addText("Email: " . $email, ['size' => 12]);
    $section->addTextBreak(1);

    if (!empty($marksArray)) {
        $section->addText("Marks Details:", ['bold' => true, 'size' => 14]);
        $table = $section->addTable();
        $table->addRow();
        $table->addCell(4000, ['bgColor' => 'cccccc'])->addText("Subject", ['bold' => true]);
        $table->addCell(2000, ['bgColor' => 'cccccc'])->addText("Marks", ['bold' => true]);
        foreach ($marksArray as $subject => $score) {
            $table->addRow();
            $table->addCell(4000)->addText($subject);
            $table->addCell(2000)->addText($score);
        }
        $section->addTextBreak(1);
    }
    

    if (!empty($imagePath) && file_exists($imagePath)) {
        $section->addText("Uploaded Image:");
        $section->addImage($imagePath, ['width' => 150, 'height' => 150, 'alignment' => 'center']);
        $section->addTextBreak(1);
    }

    $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save($fileName);
    
    return $fileName; // Return file path
}
//handle form submission.
function handleFormSubmission()
{
    global $fullName, $marksArray, $phone, $email,$filePath;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fullName = sanitizeInput($_POST["fullName"] ?? "");
        $phone = sanitizeInput($_POST["phone"] ?? "");
        $marksArray = parseMarks($_POST["addMarks"] ?? "");
        $email = sanitizeInput($_POST["email"] ?? "");
        $imagePath = handleImageUpload($_FILES["chooseImg"] ?? []);

        $filePath = generateAndStoreDoc($fullName, $phone, $email, $marksArray, $imagePath);
        
    }
}
//function call.
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
        <table border="1">
        <tr>
            <th>Subject</th>
            <th>Marks</th>
        </tr>
        <?php foreach ($marksArray as $subject => $marks): ?>
            <tr>
                <td><?php echo htmlspecialchars($subject); ?></td>
                <td><?php echo htmlspecialchars($marks); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
        <p>Phone Number : <?php echo $phone ?></p>
        <p><?php 
            if (validateEmailWithAPI($email)) {
                echo " Email is valid: $email<br>";
            } else {
                echo " Invalid email address. Please enter a valid email.";
            }
        ?></p>
        <p>Document saved successfully: <a href='$filePath' download>Download Here</a></p>
    </div>
</body>

</html>
