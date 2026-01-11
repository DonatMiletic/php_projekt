<?php
require __DIR__ . "/../includes/header.php";
require __DIR__ . "/../includes/auth.php";
require __DIR__ . "/../includes/db.php";
require_admin();

$stmt = $pdo->query("SELECT id, title, is_archived, created_at FROM news ORDER BY created_at DESC");
$rows = $stmt->fetchAll();
?>

<h1>Manage News</h1>

<p style="text-align:center;">
  <a href="<?= $BASE_URL ?>/admin/news_create.php">+ Create News</a>
</p>

<div style="max-width: 1000px; margin: 0 auto;">
  <table style="width:100%; border-collapse:collapse;">
    <thead>
      <tr>
        <th style="text-align:left; padding:10px; border-bottom:1px solid rgba(255,255,255,0.2);">Title</th>
        <th style="text-align:left; padding:10px; border-bottom:1px solid rgba(255,255,255,0.2);">Archived</th>
        <th style="text-align:left; padding:10px; border-bottom:1px solid rgba(255,255,255,0.2);">Created</th>
        <th style="text-align:left; padding:10px; border-bottom:1px solid rgba(255,255,255,0.2);">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td style="padding:10px; border-bottom:1px solid rgba(255,255,255,0.1);">
            <?= htmlspecialchars($r["title"]) ?>
          </td>
          <td style="padding:10px; border-bottom:1px solid rgba(255,255,255,0.1);">
            <?= $r["is_archived"] ? "Yes" : "No" ?>
          </td>
          <td style="padding:10px; border-bottom:1px solid rgba(255,255,255,0.1);">
            <?= htmlspecialchars($r["created_at"]) ?>
          </td>
          <td style="padding:10px; border-bottom:1px solid rgba(255,255,255,0.1);">
            <a href="<?= $BASE_URL ?>/admin/news_edit.php?id=<?= (int)$r["id"] ?>">Edit</a>
            |
            <a href="<?= $BASE_URL ?>/admin/news_delete.php?id=<?= (int)$r["id"] ?>" onclick="return confirm('Delete this news?');">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require __DIR__ . "/../includes/footer.php"; ?>
