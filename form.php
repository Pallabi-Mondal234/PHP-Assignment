<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName=isset($_POST["fullName"])?trim($_POST["fullName"]):"";
    $fullName=htmlspecialchars($fullName);
}

//show image
$target_dir = "upload/";
$target_file = $target_dir . basename($_FILES["chooseImg"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["chooseImg"]["tmp_name"]);
    if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
  }
  
  // Check if file already exists
  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }
  
  // Check file size
  if ($_FILES["chooseImg"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }
  
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  } 

if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
} else {
  if (move_uploaded_file($_FILES["chooseImg"]["tmp_name"], $target_file)) {
    echo "<img class=uploadedImg src='$target_file' alt='uploaded-img'>";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}

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

