<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<style>
  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    background: #f5f5f5;
  }

  .filters {
    flex-grow: 1;
  }

  .profile-dropdown {
    position: relative;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-left: auto;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    top: 35px;
    right: 0;
    background: white;
    border: 1px solid #ccc;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    z-index: 1000;
    min-width: 150px;
  }

  .dropdown-content.show {
    display: block;
  }

  .dropdown-content a {
    display: block;
    padding: 10px;
    color: #333;
    text-decoration: none;
  }

  .dropdown-content a:hover {
    background-color: #f0f0f0;
  }

  .profile-pic {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    vertical-align: middle;
  }

  .filters input,
  .filters select,
  .filters button {
    padding: 6px;
    margin-right: 5px;
  }
</style>

<div class="header">
  <!-- Filters -->
  <?php if (!in_array($currentPage, ['index.php', 'uploadresources.php', 'upresources.php'])): ?>
  <div class="filters">
    <input type="text" id="search-text" placeholder="Search..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">

    <?php if ($currentPage === 'resources.php'): ?>
      <select id="type-filter">
        <option value="">All Types</option>
        <option value="ebook" <?= isset($_GET['type']) && $_GET['type'] === 'ebook' ? 'selected' : '' ?>>Ebooks</option>
        <option value="pdf" <?= isset($_GET['type']) && $_GET['type'] === 'pdf' ? 'selected' : '' ?>>PDFs</option>
        <option value="video" <?= isset($_GET['type']) && $_GET['type'] === 'video' ? 'selected' : '' ?>>Videos</option>
      </select>

      <select id="category-filter">
    <option value="">All Categories</option>
    <option value="programming" <?= isset($_GET['category']) && $_GET['category'] === 'programming' ? 'selected' : '' ?>>Programming</option>
    <option value="networking" <?= isset($_GET['category']) && $_GET['category'] === 'networking' ? 'selected' : '' ?>>Networking</option>
    <option value="database" <?= isset($_GET['category']) && $_GET['category'] === 'database' ? 'selected' : '' ?>>Database</option>
    <option value="others" <?= isset($_GET['category']) && $_GET['category'] === 'others' ? 'selected' : '' ?>>Others</option>
  </select>

    <?php elseif ($currentPage === 'user.php'): ?>
      <select id="type-filter">
        <option value="">All Status</option>
        <option value="active" <?= isset($_GET['role']) && $_GET['role'] === 'active' ? 'selected' : '' ?>>Active</option>
        <option value="banned" <?= isset($_GET['role']) && $_GET['role'] === 'banned' ? 'selected' : '' ?>>Banned</option>
        <option value="pending" <?= isset($_GET['role']) && $_GET['role'] === 'pending' ? 'selected' : '' ?>>Pending</option>
      </select>

    <?php elseif ($currentPage === 'uploads.php'): ?>
      <select id="type-filter">
        <option value="">All Types</option>
        <option value="image" <?= isset($_GET['type']) && $_GET['type'] === 'image' ? 'selected' : '' ?>>Images</option>
        <option value="document" <?= isset($_GET['type']) && $_GET['type'] === 'document' ? 'selected' : '' ?>>Documents</option>
      </select>
      <select id="status-filter">
        <option value="">All Status</option>
        <option value="approved" <?= isset($_GET['status']) && $_GET['status'] === 'approved' ? 'selected' : '' ?>>Approved</option>
        <option value="pending" <?= isset($_GET['status']) && $_GET['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
        <option value="rejected" <?= isset($_GET['status']) && $_GET['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
      </select>
    <?php endif; ?>

    <button onclick="applyFilters()">Search</button>
  </div>
  <?php endif; ?>

  <!-- Profile Dropdown (always on right) -->
  <div class="profile-dropdown" onclick="toggleDropdown()">
    <img src="image/profile.png" alt="Profile" class="profile-pic">
    <span class="admin-name">Admin</span>
    <i class="fa fa-caret-down"></i>

    <div class="dropdown-content" id="dropdown">
      <a href="#" onclick="window.open('change_password.php', 'Change Password', 'width=500,height=600'); return false;">
        <i class="fas fa-key"></i> Change Password
      </a>
      <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
  </div>
</div>

<script>
  function toggleDropdown() {
    document.getElementById("dropdown").classList.toggle("show");
  }

  window.onclick = function(event) {
    if (!event.target.closest('.profile-dropdown')) {
      document.getElementById("dropdown").classList.remove("show");
    }
  }

  function applyFilters() {
    const search = document.getElementById("search-text")?.value.trim() || '';
    const type = document.getElementById("type-filter")?.value || '';
    const date = document.getElementById("date-filter")?.value || '';
    const status = document.getElementById("status-filter")?.value || '';
    const params = new URLSearchParams();
    const currentPage = "<?= $currentPage ?>";

    if (search) params.append("search", search);
    if (currentPage === "resources.php") {
      if (type) params.append("type", type);
      if (date) params.append("date", date);
    } else if (currentPage === "user.php") {
      if (type) params.append("role", type);
    } else if (currentPage === "uploads.php") {
      if (type) params.append("type", type);
      if (status) params.append("status", status);
    }

    window.location.href = currentPage + "?" + params.toString();
  }
</script>
