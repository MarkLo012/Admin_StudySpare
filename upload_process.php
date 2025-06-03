<?php
session_start();
include 'php/db.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect form data
    $title = $_POST['title'];
    $type = $_POST['type'];
    $file = $_FILES['file'];

    $fileName = basename($file['name']);
    $uploadDir = 'uploads/';
    $filePath = $uploadDir . $fileName;

    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $filePath)) {

        // Determine uploader type and assign IDs
        $isAdmin = isset($_SESSION['admin_id']);
        $adminId = $isAdmin ? $_SESSION['admin_id'] : null;
        $userId = !$isAdmin && isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $status = $isAdmin ? 'approved' : 'pending';

        // Prepare SQL
        $sql = "INSERT INTO uploads (title, type, file_path, status, admin_id, user_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        // Use NULL where needed
        $stmt->bind_param(
            "ssssii",
            $title,
            $type,
            $filePath,
            $status,
            $adminId,
            $userId
        );

        // Execute and redirect
        if ($stmt->execute()) {
            header("Location: upload.php?success=1");
            exit();
        } else {
            echo "Database error: " . $stmt->error;
        }

    } else {
        echo "File upload failed.";
    }

} else {
    header("Location: upload.php");
    exit();
}
?>
