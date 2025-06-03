<?php
// logIn.php

session_start();
include 'php/db.php'; // make sure this path is correct

$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the admin by email
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // Compare SHA-256 hashed password
        if (hash('sha256', $password) === $user['password']) {
            // Login success
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            header("Location: index.php");
            exit();
        } else {
            $error = "❌ Incorrect password.";
        }
    } else {
        $error = "❌ Admin not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - StudySpare</title>
  <link rel="stylesheet" href="style/login.css"/>
</head>
<body>
  <div class="login-container">
    <img src="image/logo.png" alt="StudySpare Logo" class="logo">
    <h2>Login to StudySpare</h2>

    <?php if (!empty($error)): ?>
      <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="logIn.php" method="post">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
