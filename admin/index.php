<?php
require __DIR__ . "/../includes/header.php";
require __DIR__ . "/../includes/auth.php";
require_admin();
?>

<h1>Admin panel</h1>

<ul style="list-style:none; padding:0; display:flex; gap:14px; justify-content:center;">
  <li><a href="<?= $BASE_URL ?>/admin/news_list.php">Manage News</a></li>
  <li><a href="<?= $BASE_URL ?>/admin/messages_list.php">Contact Messages</a></li>
</ul>

<?php require __DIR__ . "/../includes/footer.php"; ?>
