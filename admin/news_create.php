<?php
require __DIR__ . "/../includes/header.php";
require __DIR__ . "/../includes/auth.php";
require __DIR__ . "/../includes/db.php";
require_admin();

$error = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $title = trim($_POST["title"] ?? "");
  $description = trim($_POST["description"] ?? "");
  $is_archived = isset($_POST["is_archived"]) ? 1 : 0;

  $pictureName = null;

  // upload slike (opcijski)
  if (!empty($_FILES["picture"]["name"])) {
    $allowed = ["image/jpeg" => "jpg", "image/png" => "png", "image/webp" => "webp"];
    $type = $_FILES["picture"]["type"] ?? "";
    $tmp = $_FILES["picture"]["tmp_name"] ?? "";

    if (!isset($allowed[$type])) {
      $error = "Only JPG, PNG, WEBP allowed.";
    } else {
      $ext = $allowed[$type];
      $pictureName = "news_" . time() . "_" . bin2hex(random_bytes(4)) . "." . $ext;

      $destDir = __DIR__ . "/../assets/news/";
      $destPath = $destDir . $pictureName;

      if (!is_dir($destDir)) {
        mkdir($destDir, 0777, true);
      }

      if (!move_uploaded_file($tmp, $destPath)) {
        $error = "Upload failed.";
      }
    }
  }

  if ($error === "") {
    if ($title === "" || $description === "") {
      $error = "Title and description are required.";
    } else {
      $stmt = $pdo->prepare("INSERT INTO news (title, description, picture, is_archived) VALUES (?, ?, ?, ?)");
      $stmt->execute([$title, $description, $pictureName, $is_archived]);
      $success = true;
    }
  }
}
?>

<h1>Create News</h1>

<?php if ($error): ?>
  <p style="text-align:center; color:#8b3727; font-weight:bold;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<?php if ($success): ?>
  <p style="text-align:center; color:#8b3727; font-weight:bold;">
    News created. <a href="<?= $BASE_URL ?>/admin/news_list.php">Back to list</a>
  </p>
<?php endif; ?>

<section id="contact">
  <form method="post" action="" enctype="multipart/form-data">
    <label for="title">Title</label>
    <input id="title" name="title" type="text" required>

    <label for="description">Description</label>
    <textarea id="description" name="description" required></textarea>

    <label for="picture">Picture (optional)</label>
    <input id="picture" name="picture" type="file" accept=".jpg,.jpeg,.png,.webp">

    <label style="display:flex; gap:10px; align-items:center;">
      <input type="checkbox" name="is_archived" value="1">
      Archive this news
    </label>

    <button type="submit">Create</button>
  </form>
</section>

<p style="text-align:center;"><a href="<?= $BASE_URL ?>/admin/news_list.php">Back</a></p>

<?php require __DIR__ . "/../includes/footer.php"; ?>
