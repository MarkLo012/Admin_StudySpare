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
$category = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : '';
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
if (!empty($category)) {
    $sql .= " AND u.category = '$category'";
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
  <style>
    .filters {
      margin: 15px 0;
    }
    .filters input,
    .filters select,
    .filters button {
      padding: 6px;
      margin-right: 5px;
    }
  </style>
</head>
<body>
  <?php include 'include/sidebar.php'; ?>
  <div class="main">
    <?php include 'include/header.php'; ?>

    <div class="table-container">
      <div class="heading">
        <h2>All Uploaded Resources</h2>
      </div>

      <!-- ✅ Filters -->
      <div class="filters">
        <input type="text" id="search-text" placeholder="Search..." value="<?= htmlspecialchars($search) ?>">

        <select id="type-filter">
          <option value="">All Types</option>
          <option value="ebook" <?= $type === 'ebook' ? 'selected' : '' ?>>Ebooks</option>
          <option value="pdf" <?= $type === 'pdf' ? 'selected' : '' ?>>PDFs</option>
          <option value="video" <?= $type === 'video' ? 'selected' : '' ?>>Videos</option>
        </select>

        <select id="category-filter">
          <option value="">All Categories</option>
          <option value="programming" <?= $category === 'programming' ? 'selected' : '' ?>>Programming</option>
          <option value="networking" <?= $category === 'networking' ? 'selected' : '' ?>>Networking</option>
          <option value="database" <?= $category === 'database' ? 'selected' : '' ?>>Database</option>
          <option value="others" <?= $category === 'others' ? 'selected' : '' ?>>Others</option>
        </select>

        <input type="date" id="date-filter" value="<?= htmlspecialchars($date) ?>">

        <button onclick="applyFilters()">Search</button>
      </div>

      <!-- ✅ Table -->
      <table class="luser">
        <thead>
          <tr>
            <th>Title</th>
            <th>Type</th>
            <th>Category</th>
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
              <td><?= ucfirst(htmlspecialchars($row['category'] ?? 'N/A')) ?></td>
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
          <tr><td colspan="6">No resources found.</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

<script>
  function applyFilters() {
    const search = document.getElementById("search-text")?.value.trim() || '';
    const type = document.getElementById("type-filter")?.value || '';
    const category = document.getElementById("category-filter")?.value || '';
    const date = document.getElementById("date-filter")?.value || '';
    const params = new URLSearchParams();

    if (search) params.append("search", search);
    if (type) params.append("type", type);
    if (category) params.append("category", category);
    if (date) params.append("date", date);

    window.location.href = "resources.php?" + params.toString();
  }
</script>
</body>
</html>
