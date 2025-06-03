<?php // sidebar.php ?>
<div class="sidebar">
  <img src="image/logo.png" alt="StudySpare Logo" class="logo">
  <h2>StudySpare</h2>
  <a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>"><i class="fa-solid fa-gauge"></i>Dashboard</a>
  <a href="user.php" class="<?= basename($_SERVER['PHP_SELF']) == 'user.php' ? 'active' : '' ?>"><i class="fa-solid fa-users"></i> Users</a>
  <a href="resources.php" class="<?= basename($_SERVER['PHP_SELF']) == 'resources.php' ? 'active' : '' ?>"><i class="fa-solid fa-book"></i> Resources</a>
  <a href="upresources.php" class="<?= basename($_SERVER['PHP_SELF']) == 'upresources.php' ? 'active' : '' ?>"><i class="fa-solid fa-clock"></i> Upload</a>
</div>