<?php require __DIR__ . "/includes/header.php"; ?>

<h1>Gallery</h1>
<h2>Silent Hill Wallpapers</h2>

<?php
$images = [
  [
    "file" => "sh1.jpg",
    "caption" => "Maria"
  ],
  [
    "file" => "sh2.jpg",
    "caption" => "SH portrets"
  ],
  [
    "file" => "sh3.jpg",
    "caption" => "Robby the Rabbit and Heather"
  ],
  [
    "file" => "sh4.jpg",
    "caption" => "Dark corridors and hidden fears"
  ],
  [
    "file" => "sh5.jpg",
    "caption" => "Silent Hill map "
  ],
  [
    "file" => "sh6.jpg",
    "caption" => "Halo of the Sun"
  ],
  [
    "file" => "sh7.jpg",
    "caption" => "Heather with weapon at dusk"
  ],
  [
    "file" => "sh8.jpg",
    "caption" => "Eileen Galvin"
  ],
  [
    "file" => "sh9.jpg",
    "caption" => "James Sunderland mirror scene"
  ],
  [
    "file" => "sh10.jpg",
    "caption" => "Alchemilla hospital map"
  ],
];
?>

<div class="gallery">
  <?php foreach ($images as $img):
    $src = $BASE_URL . "/assets/gallery/" . $img["file"];
  ?>
    <figure class="gallery-item">
      <a href="<?= $src ?>" target="_blank" rel="noopener">
        <img src="<?= $src ?>" alt="<?= htmlspecialchars($img["caption"]) ?>">
      </a>
      <figcaption><?= htmlspecialchars($img["caption"]) ?></figcaption>
    </figure>
  <?php endforeach; ?>
</div>

<?php require __DIR__ . "/includes/footer.php"; ?>
