<?php require __DIR__ . "/includes/header.php";
require __DIR__ . "/includes/db.php";

$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $surname = trim($_POST["surname"]);
    $email = trim($_POST["email"]);
    $country = $_POST["country"] ?? "";
    $message = trim($_POST["message"]);

    if ($name && $surname && $email) {
        $stmt = $pdo->prepare("
            INSERT INTO contact_messages (name, surname, email, country, message)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$name, $surname, $email, $country, $message]);
        $success = true;
    }
}


?>

<h1>Contact us</h1><br>

<?php if ($success): ?>
  <p style="text-align:center; color:#8b3727; font-weight:bold;">
    Your message has been sent. We will respond from the fog.
  </p>

<?php endif; ?>
<div id="contact">

  <div class="map-container">
    <iframe 
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d190287.07870532197!2d-69.95052314609895!3d45.50875701601624!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4cb081b40e1e8bc1%3A0x6b0b5b57dfc5c3b3!2sMoosehead%20Lake%2C%20Maine%2C%20USA!5e0!3m2!1sen!2shr!4v1700000000000"
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade"
      allowfullscreen
      title="Silent Hill location">
    </iframe>
  </div>

  <form method="post" action="#">
    <label for="name">NAME:</label>
    <input type="text" id="name" name="name" required>

    <label for="surname">SURNAME:</label>
    <input type="text" id="surname" name="surname" required>

    <label for="email">E-mail address:</label>
    <input type="email" id="email" name="email" required>

    <label for="country">COUNTRY:</label>
    <select id="country" name="country">
      <option value="hr">CROATIA</option>
      <option value="us">USA</option>
      <option value="it">ITALY</option>
      <option value="de">GERMANY</option>
    </select>

    <label for="message">DESCRIPTION:</label>
    <textarea id="message" name="message"></textarea>

    <button type="submit">SEND</button>
  </form>

</div>

<?php require __DIR__ . "/includes/footer.php"; ?>
