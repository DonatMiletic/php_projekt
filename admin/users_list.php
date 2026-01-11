<?php
require __DIR__ . "/../includes/header.php";
require __DIR__ . "/../includes/auth.php";
require __DIR__ . "/../includes/db.php";
require_admin();

$stmt = $pdo->query("SELECT id, firstname, lastname, username, email, role, created_at FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll();
?>

<h1>Manage Users</h1>

<div style="max-width: 1100px; margin: 0 auto;">
  <table style="width:100%; border-collapse:collapse;">
    <thead>
      <tr>
        <th style="text-align:left; padding:10px; border-bottom:1px solid rgba(255,255,255,0.2);">Name</th>
        <th style="text-align:left; padding:10px; border-bottom:1px solid rgba(255,255,255,0.2);">Username</th>
        <th style="text-align:left; padding:10px; border-bottom:1px solid rgba(255,255,255,0.2);">Email</th>
        <th style="text-align:left; padding:10px; border-bottom:1px solid rgba(255,255,255,0.2);">Role</th>
        <th style="text-align:left; padding:10px; border-bottom:1px solid rgba(255,255,255,0.2);">Created</th>
        <th style="text-align:left; padding:10px; border-bottom:1px solid rgba(255,255,255,0.2);">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $u): ?>
        <tr>
          <td style="padding:10px; border-bottom:1px solid rgba(255,255,255,0.1);">
            <?= htmlspecialchars($u["firstname"] . " " . $u["lastname"]) ?>
            <?php if (!empty($_SESSION["user_id"]) && (int)$_SESSION["user_id"] === (int)$u["id"]): ?>
              <span style="color: rgba(255,255,255,0.65);">(you)</span>
            <?php endif; ?>
          </td>
          <td style="padding:10px; border-bottom:1px solid rgba(255,255,255,0.1);"><?= htmlspecialchars($u["username"]) ?></td>
          <td style="padding:10px; border-bottom:1px solid rgba(255,255,255,0.1);"><?= htmlspecialchars($u["email"]) ?></td>
          <td style="padding:10px; border-bottom:1px solid rgba(255,255,255,0.1);"><?= htmlspecialchars($u["role"]) ?></td>
          <td style="padding:10px; border-bottom:1px solid rgba(255,255,255,0.1);"><?= htmlspecialchars($u["created_at"]) ?></td>
          <td style="padding:10px; border-bottom:1px solid rgba(255,255,255,0.1);">
            <a href="<?= $BASE_URL ?>/admin/user_edit.php?id=<?= (int)$u["id"] ?>">Edit</a>
            |
            <a
              href="<?= $BASE_URL ?>/admin/user_delete.php?id=<?= (int)$u["id"] ?>"
              onclick="return confirm('Delete this user?');"
            >Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<p style="text-align:center; margin-top: 1.2em;">
  <a href="<?= $BASE_URL ?>/admin/index.php">Back to Admin</a>
</p>

<?php require __DIR__ . "/../includes/footer.php"; ?>
