<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require __DIR__ . "/config.php";
?>
<!doctype html>
<html lang="hr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Silent Hill Fan Page</title>
  <link rel="icon" href="<?= $BASE_URL ?>/favicon.png">
  <link rel="stylesheet" href="<?= $BASE_URL ?>/assets/css/style.css">
</head>
<body>

<header>
  <div class="hero-image"></div>

  <nav>
    <ul>
      <li><a href="<?= $BASE_URL ?>/index.php">Home</a></li>
      <li><a href="<?= $BASE_URL ?>/news.php">News</a></li>
      <li><a href="<?= $BASE_URL ?>/gallery.php">Gallery</a></li>
      <li><a href="<?= $BASE_URL ?>/about.php">About Us</a></li>
      <li><a href="<?= $BASE_URL ?>/contact.php">Contact</a></li>

      <?php if (!empty($_SESSION['user_id'])): ?>
        <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
          <li><a href="<?= $BASE_URL ?>/admin/index.php">Admin</a></li>
        <?php endif; ?>
        <li><a href="<?= $BASE_URL ?>/auth/logout.php">Logout</a></li>
      <?php else: ?>
        <li><a href="<?= $BASE_URL ?>/auth/login.php">Sign in</a></li>
        <li><a href="<?= $BASE_URL ?>/auth/register.php">Register</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>

<main>
