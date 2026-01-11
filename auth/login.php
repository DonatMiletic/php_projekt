<?php
require __DIR__ . "/../includes/header.php";
require __DIR__ . "/../includes/db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $login = trim($_POST["login"] ?? "");
  $password = $_POST["password"] ?? "";

  $stmt = $pdo->prepare("
  SELECT id, firstname, lastname, username, email, password_hash, role
  FROM users
  WHERE username = ? OR email = ?
  LIMIT 1
");
  $stmt->execute([$login, $login]);
  $user = $stmt->fetch();

  if (!$user || !password_verify($password, $user["password_hash"])) {
    $error = "Invalid login or password.";
  } else {
    $_SESSION["user_id"] = $user["id"];
    $_SESSION["username"] = $user["username"];
    $_SESSION["role"] = $user["role"];
    $_SESSION["firstname"] = $user["firstname"];
    $_SESSION["lastname"]  = $user["lastname"];


    header("Location: " . $BASE_URL . "/index.php");
    exit;
  }
}
?>

<h1>Sign in</h1>

<?php if ($error): ?>
  <p style="text-align:center; color:#8b3727; font-weight:bold;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<section id="contact">
  <form method="post" action="">
    <label for="login">Username or Email</label>
    <input id="login" name="login" type="text" required>

    <label for="password">Password</label>
    <input id="password" name="password" type="password" required>

    <button type="submit">Sign in</button>
  </form>
</section>

<?php require __DIR__ . "/../includes/footer.php"; ?>
