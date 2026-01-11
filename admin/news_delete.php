<?php
session_start();
require __DIR__ . "/../includes/config.php";
require __DIR__ . "/../includes/auth.php";
require __DIR__ . "/../includes/db.php";
require_admin();

$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
if ($id <= 0) { header("Location: " . $BASE_URL . "/admin/news_list.php"); exit; }

// dohvat slike prije brisanja
$stmt = $pdo->prepare("SELECT picture FROM news WHERE id = ? LIMIT 1");
$stmt->execute([$id]);
$row = $stmt->fetch();

$stmt = $pdo->prepare("DELETE FROM news WHERE id = ?");
$stmt->execute([$id]);

// obriši file ako postoji
if ($row && !empty($row["picture"])) {
  $path = __DIR__ . "/../assets/news/" . $row["picture"];
  if (is_file($path)) @unlink($path);
}

header("Location: " . $BASE_URL . "/admin/news_list.php");
exit;
