<?php
require __DIR__ . "/../includes/header.php";
require __DIR__ . "/../includes/auth.php";
require __DIR__ . "/../includes/db.php";
require_admin();

$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
if ($id <= 0) { echo "Invalid ID"; exit; }

$stmt = $pdo->prepare("SELECT id, firstname, lastname, username, email, role FROM users WHERE id = ? LIMIT 1");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) { echo "User not found."; exit; }

$error = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $firstname = trim($_POST["firstname"] ?? "");
  $lastname  = trim($_POST["lastname"] ?? "");
  $username  = trim($_POST["username"] ?? "");
  $email     = trim($_POST["email"] ?? "");
  $role      = ($_POST["role"] ?? "user") === "admin" ? "admin" : "user";
  $newPass   = $_POST["new_password"] ?? "";

  if ($firstname === "" || $lastname === "" || $username === "" || $email === "") {
    $error = "All fields (except new password) are required.";
  } else {
    
    $stmt = $pdo->prepare("SELECT id FROM users WHERE (username = ? OR email = ?) AND id <> ? LIMIT 1");
    $stmt->execute([$username, $email, $id]);
    if ($stmt->fetch()) {
      $error = "Username or email already exists.";
    }
  }

  
  if ($error === "" && !empty($_SESSION["user_id"]) && (int)$_SESSION["user_id"] === $id && $role !== "admin") {
    $error = "You cannot remove your own admin role.";
  }

  if ($error === "") {
    if ($newPass !== "") {
      $hash = password_hash($newPass, PASSWORD_DEFAULT);
      $stmt = $pdo->prepare("
        UPDATE users
        SET firstname = ?, lastname = ?, username = ?, email = ?, role = ?, password_hash = ?
        WHERE id = ?
      ");
      $stmt->execute([$firstname, $lastname, $username, $email, $role, $hash, $id]);
    } else {
      $stmt = $pdo->prepare("
        UPDATE users
        SET firstname = ?, lastname = ?, username = ?, email = ?, role = ?
        WHERE id = ?
      ");
      $stmt->execute([$firstname, $lastname, $username, $email, $role, $id]);
    }

    $success = true;

    $stmt = $pdo->prepare("SELECT id, firstname, lastname, username, email, role FROM users WHERE id = ? LIMIT 1");
    $stmt->execute([$id]);
    $user = $stmt->fetch();
  }
}
?>

<h1>Edit User</h1>

<?php if ($error): ?>
  <p style="text-align:center; color:#8b3727; font-weight:bold;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<?php if ($success): ?>
  <p style="text-align:center; color:#8b3727; font-weight:bold;">Saved.</p>
<?php endif; ?>

<section id="contact">
  <form method="post" action="">
    <label for="firstname">First name</label>
    <input id="firstname" name="firstname" type="text" value="<?= htmlspecialchars($user["firstname"]) ?>" required>

    <label for="lastname">Last name</label>
    <input id="lastname" name="lastname" type="text" value="<?= htmlspecialchars($user["lastname"]) ?>" required>

    <label for="username">Username</label>
    <input id="username" name="username" type="text" value="<?= htmlspecialchars($user["username"]) ?>" required>

    <label for="email">Email</label>
    <input id="email" name="email" type="email" value="<?= htmlspecialchars($user["email"]) ?>" required>

    <label for="role">Role</label>
    <select id="role" name="role">
      <option value="user" <?= $user["role"] === "user" ? "selected" : "" ?>>User</option>
      <option value="admin" <?= $user["role"] === "admin" ? "selected" : "" ?>>Admin</option>
    </select>

    <label for="new_password">New password (leave empty to keep current)</label>
    <input id="new_password" name="new_password" type="password">

    <button type="submit">Save</button>
  </form>
</section>

<p style="text-align:center; margin-top: 1.2em;">
  <a href="<?= $BASE_URL ?>/admin/users_list.php">Back to Users</a>
</p>

<?php require __DIR__ . "/../includes/footer.php"; ?>
