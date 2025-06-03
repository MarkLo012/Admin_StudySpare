<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: LogIn.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid request.");
}

include 'php/db.php';

$id = intval($_GET['id']);

// Fetch file path
$stmt = $conn->prepare("SELECT file_path FROM uploads WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($filePath);
$stmt->fetch();
$stmt->close();

// Delete file if exists
if ($filePath && file_exists($filePath)) {
    unlink($filePath);
}

// Delete DB entry
$stmt = $conn->prepare("DELETE FROM uploads WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

$conn->close();
header("Location: upresources.php?delete=success");
exit();
?>
