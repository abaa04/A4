<?php
session_start();
require_once '../config/db.php';

if (!in_array($_SESSION['role'], ['admin', 'office_staff', 'teacher_employee', 'department'])) {
    die("Access Denied");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = $_POST['category'];
    $type = $_POST['type'];
    $year = $_POST['year'];

    $target_dir = "../uploads/";
    $file = $_FILES['file'];
    $filename = basename($file['name']);
    $target_file = $target_dir . uniqid() . "_" . $filename;

    $allowed_ext = ['pdf', 'docx', 'jpg'];
    $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if (in_array($file_ext, $allowed_ext)) {
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO files (filename, filepath, category, type, year, uploader_id, upload_date) VALUES (?, ?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssssii", $filename, $target_file, $category, $type, $year, $_SESSION['user_id']);
            $stmt->execute();
            echo "File uploaded successfully.";
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Invalid file type.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Upload Files</title>
<link rel="stylesheet" href="../styles.css">
</head>
<body>
<h2>Upload Files</h2>
<form method="POST" enctype="multipart/form-data">
    Select file: <input type="file" name="file" required><br>
    Category: <input type="text" name="category" required><br>
    Type: <input type="text" name="type" required><br>
    Year: <input type="number" name="year" required><br>
    <button type="submit">Upload</button>
</form>
</body>
</html>