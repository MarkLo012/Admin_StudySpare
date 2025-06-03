<?php
include 'php/db.php';

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $conn->query("UPDATE uploads SET status = 'approved' WHERE id = $id");
}

header("Location: upload.php");
exit();
