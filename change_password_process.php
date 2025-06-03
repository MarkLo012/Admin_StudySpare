<?php
session_start();
include 'php/db.php'; // Adjust path to your db.php file

// Ensure user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: LogIn.php");
    exit();
}

$adminId = $_SESSION['admin_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old = $_POST['old_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if ($new !== $confirm) {
        header("Location: change_password.php?error=Passwords do not match");
        exit();
    }

    // Fetch the current hashed password from the DB
    $stmt = $conn->prepare("SELECT password FROM admin WHERE id = ?");
    $stmt->bind_param("i", $adminId);
    $stmt->execute();
    $stmt->bind_result($currentPassword);
    $stmt->fetch();
    $stmt->close();

    // Compare hashed passwords using SHA-256
    if (hash('sha256', $old) !== $currentPassword) {
        header("Location: change_password.php?error=Old password is incorrect");
        exit();
    }

    // Hash the new password and update it
    $newHash = hash('sha256', $new);
    $update = $conn->prepare("UPDATE admin SET password = ? WHERE id = ?");
    $update->bind_param("si", $newHash, $adminId);
    
    if ($update->execute()) {
        header("Location: change_password.php?success=Password updated successfully");
    } else {
        header("Location: change_password.php?error=Failed to update password");
    }

    $update->close();
    $conn->close();
}
?>
