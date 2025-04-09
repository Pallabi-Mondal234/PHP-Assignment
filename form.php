<?php
// Logout handler.
include '../Login/logout.php';

// Autoload dependencies.
require __DIR__ . '/../../vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

// Email validation helper class.
class EmailValidator
{
    // private $apiKey = "3803df1be2a145bd9ddde411d50c0144";
    private $apiKey = "c1d992ef5c074671bfacc25d4bed28ff";
    
    // validate email.
    public function validate($email)
    {
        $url = "http://apilayer.net/api/check?access_key=" . urlencode($this->apiKey) . "&email=" . urlencode($email);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($ch);
        curl_close($ch);

        if (!$response) {
            return false;
        }

        $data = json_decode($response, true);

        // Debug only
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        exit;

        return (
            isset($data['format_valid']) && $data['format_valid'] === true &&
            isset($data['mx_found']) && $data['mx_found'] === true
        );
    }
}

// Handle AJAX email validation.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && !isset($_POST['fullName'])) {
    header('Content-Type: application/json');
    $email = htmlspecialchars(trim($_POST['email']));
    $validator = new EmailValidator();
    $isValid = $validator->validate($email);
    echo json_encode(['valid' => $isValid]);
    exit;
}

// Form handler class.
class FormHandler
{
    private $uploadDir = "upload/";
    private $submissionDir = "submissions/";

    public $fullName;
    public $phone;
    public $email;
    public $marksArray = [];
    public $filePath;
    //clear unnecessary space.
    public function sanitizeInput($input)
    {
        return htmlspecialchars(trim($input));
    }
    //move image to upload directory.
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
            echo "<img class='uploadedImg' src='$targetFile' alt='Uploaded Image'>";
            return $targetFile;
        } else {
            echo "Error moving uploaded file! Check folder permissions.<br>";
            return "";
        }
    }
    //make a marks array to store marks.
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
    //generate and store the result after submission.
    public function generateAndStoreDoc($imagePath = '')
    {
        if (!is_dir($this->submissionDir)) {
            mkdir($this->submissionDir, 0777, true);
        }

        $fileName = $this->submissionDir . time() . "_User_Details.docx";
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $section->addText("User Submission Details", ['bold' => true, 'size' => 16, 'underline' => 'single']);
        $section->addTextBreak(1);
        $section->addText("Full Name: " . $this->fullName, ['size' => 12]);
        $section->addText("Phone: " . $this->phone, ['size' => 12]);
        $section->addText("Email: " . $this->email, ['size' => 12]);
        $section->addTextBreak(1);

        if (!empty($this->marksArray)) {
            $section->addText("Marks Details:", ['bold' => true, 'size' => 14]);
            $table = $section->addTable();
            $table->addRow();
            $table->addCell(4000, ['bgColor' => 'cccccc'])->addText("Subject", ['bold' => true]);
            $table->addCell(2000, ['bgColor' => 'cccccc'])->addText("Marks", ['bold' => true]);

            foreach ($this->marksArray as $subject => $score) {
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

        return $fileName;
    }
    //handle form submission.
    public function handleFormSubmission()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->fullName = $this->sanitizeInput($_POST["fullName"] ?? "");
            $this->phone = $this->sanitizeInput($_POST["phone"] ?? "");
            $this->email = $this->sanitizeInput($_POST["email"] ?? "");
            $this->marksArray = $this->parseMarks($_POST["addMarks"] ?? "");
            $imagePath = $this->handleImageUpload($_FILES["chooseImg"] ?? []);

            $this->filePath = $this->generateAndStoreDoc($imagePath);
        }
    }
}

// object creation.
$formHandler = new FormHandler();
$formHandler->handleFormSubmission();
$validator = new EmailValidator();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Output</title>
    <link rel="stylesheet" href="CSS/index.css" />
    <link rel="stylesheet" href="/PHP-Assignment-New/Login/CSS/style.css" />
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

        <p>Phone Number: +91<?php echo $formHandler->phone; ?></p>

        <p>
            <?php
            if ($validator->validate($formHandler->email)) {
                echo "Email is valid: {$formHandler->email}<br>";
            } else {
                echo "Invalid email address. Please enter a valid email.";
            }
            ?>
        </p>

        <p>Document saved successfully: <a href='<?php echo $formHandler->filePath; ?>' download>Download Here</a></p>
    </div>
</body>

</html>