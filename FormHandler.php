<?php
require_once "email.php";

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

/**
 * Handles form submission, file uploads, create marks array and store doc.
 */
class FormHandler {

  /** 
   * Upload directory for image.
   *
   * @var string
   */
  private $uploadDir = "upload/";

  /**
   * Submission folder where the doc file is stored.
   * 
   * @var string 
   */
  private $submissionDir = "submissions/";

  /**
   * Full name of user.
   * 
   * @var string 
   */
  public $fullName;

  /**
   * Phone number of user.
   * 
   * @var int 
   */
  public $phone;

  /**
   * For storing the email of user.
   * 
   * @var string 
   */
  public $email;

  /**
   * Store the marks of the user.
   * 
   * @var array 
   */
  public $marksArray = [];

  /**
   * Store the api key.
   * 
   * @var string 
   */
  private $apiKey = "79272e830032156a949263bd8d4f0383";

  /**
   * The full name.
   *
   * @var string
   */
  public $filePath;

  /**
   * Take input from the user and clean the unnecessary things.
   *
   * @param string|int $input
   *   Take input from the user.
   *
   * @return string|int
   *   Remove unnecessary things.
   */
  public function sanitizeInput(string|int $input) {
    return htmlspecialchars(trim($input));
  }

  /**
   * Move the image to the upload directory.
   * 
   * @param array $file 
   *   The uploaded file of image.
   * 
   * @return string 
   *   The path to the uploaded image or an empty string on failure.
   */
  public function handleImageUpload(array $file): string {
    if (!isset($file) || $file["error"] !== 0) {
      echo "No file uploaded or file upload error!";
      return "";
    }

    if (!is_dir($this->uploadDir)) {
      mkdir($this->uploadDir, 0777, TRUE);
    }

    $target_file = $this->uploadDir . basename($file["name"]);

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
      echo "<img class='uploadedImg' src='$target_file' alt='Uploaded Image'>";
      return $target_file;
    }
    else {
      echo "Error moving uploaded file! Check folder permissions.<br>";
      return "";
    }
  }

  /**
   * Make a marks array to store marks.
   * 
   * @param string $marks_input 
   *   Take input in Format: subject|marks (e.g., "Maths|78").
   * 
   * @return array 
   *   Array of marks and subject.
   */
  public function parseMarks(string $marks_input) {

    $marks_array = [];
    $marks_lines = preg_split("/\r\n|\n|\r/", trim($marks_input));

    foreach ($marks_lines as $line) {
      $subject_marks = explode("|", trim($line));
      if (count($subject_marks) === 2) {
        $subject = htmlspecialchars(trim($subject_marks[0]));
        $marks = htmlspecialchars(trim($subject_marks[1]));
        $marks_array[$subject] = $marks;
      }
    }
    return $marks_array;
  }

  /**
   * check email is exists or not through api.
   * 
   * @var string $email 
   *   User's email address.
   * 
   * @return boolean 
   *   Return boolean value.
   */
  public function validate($email) {
    $url = "https://apilayer.net/api/check?access_key=" . urlencode($this->apiKey) . "&email=" . urlencode($email);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

    $response = curl_exec($ch);
    if ($response === FALSE) {
      error_log("cURL error: " . curl_error($ch));
      curl_close($ch);
      return FALSE;
    }

    curl_close($ch);
    $data = json_decode($response, TRUE);

    if (isset($data['success']) && $data['success'] === FALSE) {
      return FALSE;
    }
    if (!isset($data['smtp_check'])) {
      return FALSE;
    }
    return $data['smtp_check'] === TRUE;
  }

  /**
   * Generate and store the result after submission.
   *
   * @param string $image_path
   *   The path of the file where the doc file is stored.
   * 
   * @return string
   *   Return the pdf file name.
   */
  public function generateAndStoreDoc($image_path = '') {
    if (!is_dir($this->submissionDir)) {
      mkdir($this->submissionDir, 0777, TRUE);
    }

    $file_name = $this->submissionDir . time() . "_User_Details.docx";
    $php_word = new PhpWord();
    $section = $php_word->addSection();
    
    // Add contenets in pdf file.
    $section->addText("User Submission Details", ['bold' => TRUE, 'size' => 16, 'underline' => 'single']);
    $section->addTextBreak(1);
    $section->addText("Full Name: " . $this->fullName, ['size' => 12]);
    $section->addText("Phone: " . $this->phone, ['size' => 12]);
    $section->addText("Email: " . $this->email, ['size' => 12]);
    $section->addTextBreak(1);

    // Add marks in pdf.
    if (!empty($this->marksArray)) {
      $section->addText("Marks Details:", ['bold' => TRUE, 'size' => 14]);
      $table = $section->addTable();
      $table->addRow();
      $table->addCell(4000, ['bgColor' => 'cccccc'])->addText("Subject", ['bold' => TRUE]);
      $table->addCell(2000, ['bgColor' => 'cccccc'])->addText("Marks", ['bold' => TRUE]);

      foreach ($this->marksArray as $subject => $score) {
        $table->addRow();
        $table->addCell(4000)->addText($subject);
        $table->addCell(2000)->addText($score);
      }
      $section->addTextBreak(1);
    }

    if (!empty($image_path) && file_exists($image_path)) {
      $section->addText("Uploaded Image:");
      $section->addImage($image_path, ['width' => 150, 'height' => 150, 'alignment' => 'center']);
      $section->addTextBreak(1);
    }

    // Creating the pdf file and store it.
    $obj_writer = IOFactory::createWriter($php_word, 'Word2007');
    $obj_writer->save($file_name);

    return $file_name;
  }

  /**
   * Handle form submission.
   */
  public function handleFormSubmission() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $this->fullName = $this->sanitizeInput($_POST["fullName"] ?? "");
      $this->phone = $this->sanitizeInput($_POST["phone"] ?? "");
      $this->email = $this->sanitizeInput($_POST["email"] ?? "");
      $this->marksArray = $this->parseMarks($_POST["addMarks"] ?? "");
      $image_path = $this->handleImageUpload($_FILES["chooseImg"] ?? []);

      $this->filePath = $this->generateAndStoreDoc($image_path);
    }
  }
}
?>

