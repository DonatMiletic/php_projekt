<?php
require __DIR__ . "/config.php";

function require_login(): void {
  if (empty($_SESSION['user_id'])) {
    header("Location: " . $GLOBALS['BASE_URL'] . "/auth/login.php");
    exit;
  }
}

function require_admin(): void {
  require_login();
  if (($_SESSION['role'] ?? '') !== 'admin') {
    http_response_code(403);
    echo "Forbidden";
    exit;
  }
}
