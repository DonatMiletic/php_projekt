<?php
require __DIR__ . "/includes/header.php";
require __DIR__ . "/includes/db.php";

$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;


$lastReadId = isset($_COOKIE["last_read_news_id"]) ? (int)$_COOKIE["last_read_news_id"] : 0;

echo "<h1>News</h1>";

if ($id > 0) {
  
  $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ? LIMIT 1");
  $stmt->execute([$id]);
  $row = $stmt->fetch();

  if (!$row) {
    echo "<p>Article not found.</p>";
  } else {
   
    setcookie("last_read_news_id", (string)$row["id"], time() + 7*24*60*60, $BASE_URL);

    $img = $row["picture"] ? ($BASE_URL . "/assets/news/" . $row["picture"]) : "";
    ?>
    <div class="news">
      <?php if ($img): ?>
        <img src="<?= $img ?>" alt="<?= htmlspecialchars($row["title"]) ?>" title="<?= htmlspecialchars($row["title"]) ?>">
      <?php endif; ?>

      <h2><?= htmlspecialchars($row["title"]) ?></h2>
      <p><?= nl2br(htmlspecialchars($row["description"])) ?></p>

      <time datetime="<?= htmlspecialchars($row["created_at"]) ?>">
        <?= htmlspecialchars($row["created_at"]) ?>
      </time>
      <hr>

      <p><a href="<?= $BASE_URL ?>/news.php">Back to all news</a></p>
    </div>
    <?php
  }

} else {
 
  if ($lastReadId > 0) {
    $stmt = $pdo->prepare("SELECT id, title FROM news WHERE id = ? LIMIT 1");
    $stmt->execute([$lastReadId]);
    $last = $stmt->fetch();

    if ($last) {
      ?>
      <div style="border:1px solid rgba(255,255,255,0.18); padding:12px; border-radius:10px; background:rgba(255,255,255,0.03); margin: 0.8em 0 1.2em 0;">
        <p style="margin:0; color: rgba(255,255,255,0.75);">Last read news:</p>
        <p style="margin:0.3em 0 0 0;">
          <a href="<?= $BASE_URL ?>/news.php?id=<?= (int)$last["id"] ?>">
            <?= htmlspecialchars($last["title"]) ?>
          </a>
        </p>
      </div>
      <?php
    }
  }

  
  $stmt = $pdo->query("SELECT * FROM news WHERE is_archived = 0 ORDER BY created_at DESC");
  $rows = $stmt->fetchAll();

  foreach ($rows as $row) {
    $img = $row["picture"] ? ($BASE_URL . "/assets/news/" . $row["picture"]) : "";
    $text = strip_tags($row["description"]);
    $short = (mb_strlen($text) > 300) ? mb_substr($text, 0, 300) . "..." : $text;
    ?>
    <div class="news">
      <?php if ($img): ?>
        <img src="<?= $img ?>" alt="<?= htmlspecialchars($row["title"]) ?>" title="<?= htmlspecialchars($row["title"]) ?>">
      <?php endif; ?>

      <h2><?= htmlspecialchars($row["title"]) ?></h2>

      <p>
        <?= htmlspecialchars($short) ?>
        <?php if (mb_strlen($text) > 300): ?>
          <a href="<?= $BASE_URL ?>/news.php?id=<?= (int)$row["id"] ?>">More</a>
        <?php endif; ?>
      </p>

      <time datetime="<?= htmlspecialchars($row["created_at"]) ?>">
        <?= htmlspecialchars($row["created_at"]) ?>
      </time>
      <hr>
    </div>
    <?php
  }
}

require __DIR__ . "/includes/footer.php";
