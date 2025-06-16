<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: LogIn.php");
    exit();
}
include 'php/db.php';

// Get filters
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$type = isset($_GET['type']) ? $conn->real_escape_string($_GET['type']) : '';
$date = isset($_GET['date']) ? $conn->real_escape_string($_GET['date']) : '';

// Build query
$sql = "
  SELECT u.*, 
         COALESCE(a.username, usr.name) AS uploader 
  FROM uploads u
  LEFT JOIN admin a ON u.admin_id = a.id
  LEFT JOIN users usr ON u.user_id = usr.id
  WHERE 1=1
";

if (!empty($search)) {
    $sql .= " AND u.title LIKE '%$search%'";
}
if (!empty($type)) {
    $sql .= " AND u.type = '$type'";
}
if (!empty($date)) {
    $sql .= " AND DATE(u.submitted_at) = '$date'";
}

$sql .= " ORDER BY u.submitted_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Resources - StudySpare</title>
  <link rel="stylesheet" href="style/index.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  <?php include 'include/sidebar.php'; ?>
  <div class="main">
    <?php include 'include/header.php'; ?>

    <div class="table-container">
      <div class="heading">
        <h2>All Uploaded Resources</h2>
      </div>

      <table class="luser">
        <thead>
          <tr>
            <th>Title</th>
            <th>Type</th>
            <th>Uploader</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['title']) ?></td>
              <td><?= strtoupper(htmlspecialchars($row['type'])) ?></td>
              <td><?= htmlspecialchars($row['uploader'] ?? 'Unknown') ?></td>
              <td><?= ucfirst($row['status']) ?></td>
              <td>
                <a href="<?= htmlspecialchars($row['file_path']) ?>" target="_blank" class="icon-button" title="View">
                  <i class="fas fa-eye"></i>
                </a>
                <a href="delete_upload.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this resource?');" class="icon-button" title="Delete">
                  <i class="fas fa-trash"></i>
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="5">No resources found.</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
