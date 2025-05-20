<?php
session_start();
require_once '../config/db.php';

if (!isset($_GET['id'])) {
    die("Invalid request");
}
$id = $_GET['id'];

// Optional: check user permissions here

$result = $conn->query("SELECT * FROM files WHERE id=$id");
if ($result->num_rows == 0) {
    die("File not found");
}
$file = $result->fetch_assoc();

if (unlink($file['filepath'])) {
    $conn->query("DELETE FROM files WHERE id=$id");
    echo "File deleted.";
} else {
    echo "Error deleting file.";
}
?>
<a href="files.php">Back to Files</a>