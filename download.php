<?php
if (isset($_GET['file'])) {
    $file = $_GET['file'];

    // Prevent directory traversal
    $safeFile = basename($file);
    $filePath = "submissions/" . $safeFile;

    if (file_exists($filePath)) {
        header("Content-Description: File Transfer");
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header("Content-Disposition: attachment; filename=\"" . basename($filePath) . "\"");
        header("Content-Length: " . filesize($filePath));
        flush();
        readfile($filePath);
        exit;
    } else {
        echo "Error: File does not exist.";
    }
} else {
    echo "No file specified.";
}
?>
