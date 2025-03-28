<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName=isset($_POST["fullName"])?trim($_POST["fullName"]):"";
    $fullName=htmlspecialchars($fullName);
}

//show image
$target_dir = "upload/";
$target_file = $target_dir . basename($_FILES["UploadImg"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
} else {
  if (move_uploaded_file($_FILES["UploadImg"]["tmp_name"], $target_file)) {
    echo "<img src='$target_file' alt='uploaded-img'>";
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
