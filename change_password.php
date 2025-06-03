<?php
session_start();

// Optional: Redirect to login if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: LogIn.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Change Password - StudySpare</title>
  <link rel="stylesheet" href="style/login.css" />
</head>
<body>
  <div class="login-container">
    <img src="image/logo.png" alt="StudySpare Logo" class="logo" />
    <h2>Change Password</h2>

    <!-- Optional: display messages -->
    <?php if (isset($_GET['error'])): ?>
      <p style="color:red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php elseif (isset($_GET['success'])): ?>
      <p style="color:green;"><?php echo htmlspecialchars($_GET['success']); ?></p>
    <?php endif; ?>

    <form action="change_password_process.php" method="POST">
      <input type="password" name="old_password" placeholder="Old Password" required>
      <input type="password" name="new_password" placeholder="New Password" required>
      <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
      <button type="submit">Update Password</button>
    </form>
  </div>
</body>
</html>
