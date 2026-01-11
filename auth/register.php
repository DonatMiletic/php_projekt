<?php
require __DIR__ . "/../includes/header.php";
require __DIR__ . "/../includes/db.php";

$error = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $firstname = trim($_POST["firstname"] ?? "");
  $lastname  = trim($_POST["lastname"] ?? "");
  $username  = trim($_POST["username"] ?? "");
  $email     = trim($_POST["email"] ?? "");
  $password  = $_POST["password"] ?? "";

  if ($firstname === "" || $lastname === "" || $username === "" || $email === "" || $password === "") {
    $error = "All fields are required.";
  } else {

    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1");
    $stmt->execute([$username, $email]);

    if ($stmt->fetch()) {
      $error = "Username or email already exists.";
    } else {
      $hash = password_hash($password, PASSWORD_DEFAULT);

      $stmt = $pdo->prepare("
        INSERT INTO users (firstname, lastname, username, email, password_hash)
        VALUES (?, ?, ?, ?, ?)
      ");
      $stmt->execute([$firstname, $lastname, $username, $email, $hash]);

      $success = true;
    }
  }
}
?>

<h1>Register</h1>

<?php if ($error): ?>
  <p style="text-align:center; color:#8b3727; font-weight:bold;">
    <?= htmlspecialchars($error) ?>
  </p>
<?php endif; ?>

<?php if ($success): ?>
  <p style="text-align:center; color:#8b3727; font-weight:bold;">
    Registration successful. You can now <a href="<?= $BASE_URL ?>/auth/login.php">sign in</a>.
  </p>
<?php endif; ?>

<section id="contact">
  <form method="post" action="">

    <label for="firstname">First name</label>
    <input id="firstname" name="firstname" type="text" required>

    <label for="lastname">Last name</label>
    <input id="lastname" name="lastname" type="text" required>

    <label for="username">Username</label>
    <input id="username" name="username" type="text" required>

    <label for="email">Email</label>
    <input id="email" name="email" type="email" required>

    <label for="password">Password</label>
    <input id="password" name="password" type="password" required>

    <button type="submit">Create account</button>
  </form>
</section>

<?php require __DIR__ . "/../includes/footer.php"; ?>
