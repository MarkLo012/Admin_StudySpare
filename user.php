<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: LogIn.php");
    exit();
}
include 'php/db.php';

// Get filters from URL
$search = $_GET['search'] ?? '';
$status = $_GET['role'] ?? ''; // using 'role' from dropdown (but it's actually status)
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Users - StudySpare</title>
  <link rel="stylesheet" href="style/index.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  <?php include 'include/sidebar.php'; ?>
  <div class="main">
    <?php include 'include/header.php'; ?>

    <div class="table-container">
      <div class="heading">
        <h2>All Users</h2>
      </div>

      <table class="luser">
        <thead>
          <tr>
            <td>Student ID</td>
            <td>Name</td>
            <td>Email</td>
            <td>Status</td>
            <td>Action</td>
          </tr>
        </thead>
        <tbody>
          <?php
            // Build SQL with optional filters
            $sql = "SELECT * FROM users WHERE 1=1";

            if (!empty($search)) {
                $escapedSearch = $conn->real_escape_string($search);
                $sql .= " AND (name LIKE '%$escapedSearch%' OR studentid LIKE '%$escapedSearch%' OR email LIKE '%$escapedSearch%')";
            }

            if (!empty($status)) {
                $escapedStatus = $conn->real_escape_string($status);
                $sql .= " AND status = '$escapedStatus'";
            }

            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
          ?>
          <tr>
            <td><?= htmlspecialchars($row['studentid']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= ucfirst(htmlspecialchars($row['status'])) ?></td>
            <td>
              <button class="icon-button"><i class="fas fa-trash delete-icon"></i></button>
              <button class="icon-button"><i class="fas fa-ban warn-icon"></i></button>
              <button class="icon-button"><i class="fas fa-comment comment-icon"></i></button>
            </td>
          </tr>
          <?php endwhile; else: ?>
            <tr><td colspan="5">No users found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
