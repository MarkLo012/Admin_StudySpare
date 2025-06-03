<?php // user.php ?>
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
          <tr><td>Name</td><td>Email</td><td>Status</td><td>Action</td></tr>
        </thead>
        <tbody>
          <?php include 'php/db.php';
$result = $conn->query("SELECT * FROM users");
while ($row = $result->fetch_assoc()):
?>
<tr>
  <td><?= $row['name'] ?></td>
  <td><?= $row['email'] ?></td>
  <td><?= ucfirst($row['status']) ?></td>
  <td>
    <button class="icon-button"><i class="fas fa-trash delete-icon"></i></button>
    <button class="icon-button"><i class="fas fa-ban warn-icon"></i></button>
    <button class="icon-button"><i class="fas fa-comment comment-icon"></i></button>
  </td>
</tr>
<?php endwhile; ?>

        </tbody>
      </table>
    </div>
  </div>
</body>
</html>