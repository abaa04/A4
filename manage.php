<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Role-based access control could be added here.

$files = [];
$result = $conn->query("SELECT * FROM files");
while ($row = $result->fetch_assoc()) {
    $files[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Files</title>
<link rel="stylesheet" href="../styles.css">
</head>
<body>
<h2>Files List</h2>
<table border="1">
<tr>
<th>Filename</th>
<th>Category</th>
<th>Type</th>
<th>Year</th>
<th>Upload Date</th>
<th>Actions</th>
</tr>
<?php foreach ($files as $file): ?>
<tr>
<td><?= htmlspecialchars($file['filename']) ?></td>
<td><?= htmlspecialchars($file['category']) ?></td>
<td><?= htmlspecialchars($file['type']) ?></td>
<td><?= htmlspecialchars($file['year']) ?></td>
<td><?= $file['upload_date'] ?></td>
<td>
<a href="<?= $file['filepath'] ?>">Download</a> |
<a href="delete.php?id=<?= $file['id'] ?>">Delete</a>
</td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>