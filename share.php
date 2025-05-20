<?php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file_id = $_POST['file_id'];
    $share_with = $_POST['share_with']; // email or username

    // Fetch file info
    $result = $conn->query("SELECT * FROM files WHERE id=$file_id");
    if ($result->num_rows == 0) {
        die("File not found");
    }
    $file = $result->fetch_assoc();

    // For simplicity, sharing via link (could be email)
    $share_link = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/downloads.php?id=$file_id";

    // Send email or display link
    // Here, just display the link
    echo "Share link: <a href='$share_link'>$share_link</a>";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Share Files</title>
<link rel="stylesheet" href="../styles.css">
</head>
<body>
<h2>Share Files</h2>
<form method="POST" action="">
    Select file:
    <select name="file_id">
        <?php
        $res = $conn->query("SELECT * FROM files");
        while ($row = $res->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['filename']}</option>";
        }
        ?>
    </select><br>
    Share with (Email): <input type="email" name="share_with" required><br>
    <button type="submit">Share</button>
</form>
</body>
</html>