<?php // header.php ?>
<style>
  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    background: #f5f5f5;
  }

  .profile-dropdown {
    position: relative;
    cursor: pointer;
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

  .filters input, .filters select, .filters button {
    padding: 6px;
    margin-right: 5px;
  }
</style>

<div class="header">
  <!-- Search and Filters -->
  <div class="filters">
    <input type="text" id="search-text" placeholder="Search...">
    <select id="type-filter">
      <option value="">All Types</option>
      <option value="ebooks">Ebooks</option>
      <option value="pdfs">PDFs</option>
      <option value="videos">Videos</option>
    </select>
    <input type="date" id="date-filter">
    <button onclick="applyFilters()">Search</button>
  </div>

  <!-- Profile Dropdown -->
  <div class="profile-dropdown" onclick="toggleDropdown()">
    <img src="image/profile.webp" alt="Profile" class="profile-pic">
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
    const search = document.getElementById("search-text").value.trim();
    const type = document.getElementById("type-filter").value;
    const date = document.getElementById("date-filter").value;

    const params = new URLSearchParams();
    if (search) params.append("search", search);
    if (type) params.append("type", type);
    if (date) params.append("date", date);

    window.location.href = "resources.php?" + params.toString();
  }
</script>
