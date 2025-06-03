<?php
// chat_upload.php
$id = $_GET['id'] ?? 0;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Comment on Upload</title>
</head>
<body>
  <h2>Comment on Upload ID: <?= htmlspecialchars($id) ?></h2>
  <p>Commenting feature coming soon!</p>
  <a href="upload.php">Back to Uploads</a>
</body>
</html>
