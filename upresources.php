<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: LogIn.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload - StudySpare</title>
  <link rel="stylesheet" href="style/index.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  <?php include 'include/sidebar.php'; ?>
  <div class="main">
    <?php include 'include/header.php'; ?>

    <!-- Upload Form -->
    <div class="upload-container">
      <h2>Upload New Resource</h2>
      <form action="upload_process.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Title" required>
        <select name="type" required>
          <option value="ebook">Ebooks</option>
          <option value="pdf">PDF</option>
          <option value="video">Videos</option>
        </select>
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
      </form>
    </div>

    <!-- Table of All Uploads -->
    <div class="content">
      <h2>Resources Awaiting Approval</h2>
    </div>
    <div class="table">
      <table>
        <thead>
          <tr>
            <th>Title</th>
            <th>Type</th>
            <th>Uploaded By</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
<?php
include 'php/db.php';
$uploads = $conn->query("
  SELECT u.*, 
         COALESCE(a.username, usr.name) AS uploader 
  FROM uploads u
  LEFT JOIN admin a ON u.admin_id = a.id
  LEFT JOIN users usr ON u.user_id = usr.id
  WHERE u.status = 'pending'
  ORDER BY u.submitted_at DESC
");

if ($uploads && $uploads->num_rows > 0):
  while ($upload = $uploads->fetch_assoc()):
?>
  <tr>
    <td><?= htmlspecialchars($upload['title']) ?></td>
    <td><?= htmlspecialchars($upload['type']) ?></td>
    <td><?= htmlspecialchars($upload['uploader'] ?? 'Unknown') ?></td>
    <td><?= ucfirst($upload['status']) ?></td>
    <td>
  <!-- Approve -->
  <a href="approve_upload.php?id=<?= $upload['id'] ?>" class="icon-button" title="Approve" onclick="return confirm('Approve this resource?')">
    <i class="fas fa-check-circle" style="color: green;"></i>
  </a>

  <!-- Deny -->
  <a href="deny_upload.php?id=<?= $upload['id'] ?>" class="icon-button" title="Deny" onclick="return confirm('Deny this resource?')">
    <i class="fas fa-times-circle" style="color: red;"></i>
  </a>

  <!-- Chat / Comment -->
  <a href="chat_upload.php?id=<?= $upload['id'] ?>" class="icon-button" title="Comment">
    <i class="fas fa-comment-alt" style="color: #555;"></i>
  </a>
</td>
  </tr>
<?php endwhile; else: ?>
  <tr><td colspan="5">No uploads found.</td></tr>
<?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Table of Approved Resources -->
    <div class="content" style="margin-top: 40px;">
      <h2>Approved Resources</h2>
    </div>
    <div class="table">
      <table>
        <thead>
          <tr>
            <th>Title</th>
            <th>Type</th>
            <th>Uploaded By</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
<?php
$approvedUploads = $conn->query("
  SELECT u.*, a.username AS uploader
  FROM uploads u
  LEFT JOIN admin a ON u.admin_id = a.id
  WHERE u.status = 'approved'
  ORDER BY u.submitted_at DESC
");

if ($approvedUploads && $approvedUploads->num_rows > 0):
  while ($upload = $approvedUploads->fetch_assoc()):
?>
  <tr>
    <td><?= htmlspecialchars($upload['title']) ?></td>
    <td><?= htmlspecialchars($upload['type']) ?></td>
    <td><?= htmlspecialchars($upload['uploader'] ?? 'Unknown') ?></td>
    <td><?= date('m/d/y', strtotime($upload['submitted_at'])) ?></td>
    <td>
      <a href="<?= htmlspecialchars($upload['file_path']) ?>" target="_blank" class="icon-button" title="View">
        <i class="fas fa-eye view-icon"></i>
      </a>
      <a href="delete_upload.php?id=<?= $upload['id'] ?>" onclick="return confirm('Are you sure you want to delete this upload?');" class="icon-button" title="Delete">
        <i class="fas fa-trash delete-icon"></i>
      </a>
      <button class="icon-button" title="Comment" onclick="alert('Comment feature coming soon!')">
        <i class="fas fa-comment comment-icon"></i>
      </button>
    </td>
  </tr>
<?php endwhile; else: ?>
  <tr><td colspan="5">No approved uploads found.</td></tr>
<?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>
</body>
</html>
