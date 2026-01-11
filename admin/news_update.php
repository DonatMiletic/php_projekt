<?php
require __DIR__ . "/../includes/header.php";
require __DIR__ . "/../includes/auth.php";
require __DIR__ . "/../includes/db.php";
require_admin();

$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
if ($id <= 0) { echo "Invalid ID"; exit; }

$stmt = $pdo->prepare("SELECT * FROM news WHERE id = ? LIMIT 1");
$stmt->execute([$id]);
$news = $stmt->fetch();
if (!$news) { echo "Not found"; exit; }

$error = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $title = trim($_POST["title"] ?? "");
  $description = trim($_POST["description"] ?? "");
  $is_archived = isset($_POST["is_archived"]) ? 1 : 0;

  $pictureName = $news["picture"]; // default ostaje staro

  // upload nove slike (opcijski)
  if (!empty($_FILES["picture"]["name"])) {
    $allowed = ["image/jpeg" => "jpg", "image/png" => "png", "image/webp" => "webp"];
    $type = $_FILES["picture"]["type"] ?? "";
    $tmp = $_FILES["picture"]["tmp_name"] ?? "";

    if (!isset($allowed[$type])) {
      $error = "Only JPG, PNG, WEBP allowed.";
    } else {
      $ext = $allowed[$type];
      $newName = "news_" . time() . "_" . bin2hex(random_bytes(4)) . "." . $ext;

      $destDir = __DIR__ . "/../assets/news/";
      $destPath = $destDir . $newName;

      if (!is_dir($destDir)) mkdir($destDir, 0777, true);

      if (!move_uploaded_file($tmp, $destPath)) {
        $error = "Upload failed.";
      } else {
        // obriši staru sliku ako postoji i ako je bila uploadana
        if (!empty($news["picture"])) {
          $oldPath = $destDir . $news["picture"];
          if (is_file($oldPath)) @unlink($oldPath);
        }
        $pictureName = $newName;
      }
    }
  }

  if ($error === "") {
    if ($title === "" || $description === "") {
      $error = "Title and description are required.";
    } else {
      $stmt = $pdo->prepare("UPDATE news SET title = ?, description = ?, picture = ?, is_archived = ? WHERE id = ?");
      $stmt->execute([$title, $description, $pictureName, $is_archived, $id]);
      $success = true;

      // refresh data
      $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ? LIMIT 1");
      $stmt->execute([$id]);
      $news = $stmt->fetch();
    }
  }
}
?>

<h1>Edit News</h1>

<?php if ($error): ?>
  <p style="text-align:center; color:#8b3727; font-weight:bold;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<?php if ($success): ?>
  <p style="text-align:center; color:#8b3727; font-weight:bold;">
    Saved. <a href="<?= $BASE_URL ?>/admin/news_list.php">Back to list</a>
  </p>
<?php endif; ?>

<section id="contact">
  <form method="post" action="" enctype="multipart/form-data">
    <label for="title">Title</label>
    <input id="title" name="title" type="text" value="<?= htmlspecialchars($news["title"]) ?>" required>

    <label for="description">Description</label>
    <textarea id="description" name="description" required><?= htmlspecialchars($news["description"]) ?></textarea>

    <?php if (!empty($news["picture"])): ?>
      <p style="margin:0.5em 0;">Current picture:</p>
      <img src="<?= $BASE_URL ?>/assets/news/<?= htmlspecialchars($news["picture"]) ?>" alt="Current" style="max-width:260px; border:1px solid rgba(255,255,255,0.2); border-radius:10px;">
    <?php endif; ?>

    <label for="picture">Replace picture (optional)</label>
    <input id="picture" name="picture" type="file" accept=".jpg,.jpeg,.png,.webp">

    <label style="display:flex; gap:10px; align-items:center;">
      <input type="checkbox" name="is_archived" value="1" <?= $news["is_archived"] ? "checked" : "" ?>>
      Archive this news
    </label>

    <button type="submit">Save</button>
  </form>
</section>

<p style="text-align:center;"><a href="<?= $BASE_URL ?>/admin/news_list.php">Back</a></p>

<?php require __DIR__ . "/../includes/footer.php"; ?>
