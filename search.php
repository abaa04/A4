<?php
session_start();
require_once '../config/db.php';

$results = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search = $_POST['search'];
    $filter_type = $_POST['filter_type'];
    $query = "SELECT * FROM files WHERE 1=1";

    if ($search != '') {
        $query .= " AND filename LIKE '%$search%'";
    }
    if ($filter_type != 'all') {
        $query .= " AND type='$filter_type'";
    }
    $res = $conn->query($query);
    while ($row = $res->fetch_assoc()) {
        $results[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Search Files</title>
<link rel="stylesheet" href="../styles.css">
</head>
<body>
<h2>Search Files</h2>
<form method="POST" action="">
    Search by filename: <input type="text" name="search"><br>
    Filter by type:
    <select name="filter_type">
        <option value="all">All</option>
        <option value="pdf">PDF</option>
        <option value="docx">DOCX</option>
        <option value="jpg">JPG</option>
    </select><br>
    <button type="submit">Search</button>
</form>

<?php if ($results): ?>
<h3>Results:</h3>
<table border="1">
<tr>
<th>Filename</th>
<th>Type</th>
<th>Category</th>
<th>Year</th>
</tr>
<?php foreach ($results as $file): ?>
<tr>
<td><?= htmlspecialchars($file['filename']) ?></td>
<td><?= htmlspecialchars($file['type']) ?></td>
<td><?= htmlspecialchars($file['category']) ?></td>
<td><?= htmlspecialchars($file['year']) ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>
</body>
</html>