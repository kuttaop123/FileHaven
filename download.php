<?php
if (isset($_GET['file'])) {
    $file = $_GET['file'];
    $filePath = 'uploads/' . $file;

    if (file_exists($filePath)) {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Content-Length: ' . filesize($filePath));
        
        
        readfile($filePath);
        exit;
    } else {
        echo "<p>File not found.</p>";
    }
} else {
    echo "<p>No file selected for download.</p>";
}
