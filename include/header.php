<?php // header.php ?>
<div class="header">
  <input type="text" placeholder="Search...">
  <div class="profile-dropdown" onclick="toggleDropdown()">
    <img src="image/profile.webp" alt="Profile" class="profile-pic">
    <span class="admin-name">Admin</span>
    <i class="fa fa-caret-down"></i>
    <div class="dropdown-content" id="dropdown">
      <a href="#" onclick="window.open('change_password.php', 'Change Password', 'width=500,height=600'); return false;">
  <i class="fas fa-key"></i> Change Password</a>
      <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
  </div>
</div>

<script>
  function toggleDropdown() {
    document.getElementById("dropdown").classList.toggle("show");
  }

  window.onclick = function(e) {
    if (!e.target.closest('.profile-dropdown')) {
      document.getElementById("dropdown").classList.remove("show");
    }
  }
</script>
