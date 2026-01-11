<?php
require __DIR__ . "/../includes/header.php";
require __DIR__ . "/../includes/auth.php";
require __DIR__ . "/../includes/db.php";
require_admin();

$stmt = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
$rows = $stmt->fetchAll();
?>

<h1>Contact Messages</h1>

<div style="max-width:1000px; margin:0 auto;">
  <?php foreach ($rows as $m): ?>
    <div style="border:1px solid rgba(255,255,255,0.18); padding:12px; border-radius:10px; background:rgba(255,255,255,0.03); margin: 0 0 14px 0;">
      <p style="margin:0;"><strong><?= htmlspecialchars($m["name"] . " " . $m["surname"]) ?></strong> (<?= htmlspecialchars($m["email"]) ?>)</p>
      <p style="margin:0.3em 0; color:rgba(255,255,255,0.75);">Country: <?= htmlspecialchars($m["country"] ?? "") ?></p>
      <p style="margin:0.6em 0;"><?= nl2br(htmlspecialchars($m["message"] ?? "")) ?></p>
      <time datetime="<?= htmlspecialchars($m["created_at"]) ?>"><?= htmlspecialchars($m["created_at"]) ?></time>
    </div>
  <?php endforeach; ?>
</div>

<?php require __DIR__ . "/../includes/footer.php"; ?>
