<?php
session_start();
require __DIR__ . "/../includes/config.php";
require __DIR__ . "/../includes/auth.php";
require __DIR__ . "/../includes/db.php";
require_admin();

$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
if ($id <= 0) {
  header("Location: " . $BASE_URL . "/admin/users_list.php");
  exit;
}


if (!empty($_SESSION["user_id"]) && (int)$_SESSION["user_id"] === $id) {
  header("Location: " . $BASE_URL . "/admin/users_list.php");
  exit;
}


$stmt = $pdo->prepare("SELECT role FROM users WHERE id = ? LIMIT 1");
$stmt->execute([$id]);
$target = $stmt->fetch();

if (!$target) {
  header("Location: " . $BASE_URL . "/admin/users_list.php");
  exit;
}


if ($target["role"] === "admin") {
  $stmt = $pdo->query("SELECT COUNT(*) AS cnt FROM users WHERE role='admin'");
  $cnt = (int)($stmt->fetch()["cnt"] ?? 0);
  if ($cnt <= 1) {
    header("Location: " . $BASE_URL . "/admin/users_list.php");
    exit;
  }
}

$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$id]);

header("Location: " . $BASE_URL . "/admin/users_list.php");
exit;
