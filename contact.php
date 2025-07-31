<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'includes/db.php';
require_once 'layouts/header.php';
require_once 'layouts/navbar.php';

// İletişim formu gönderildiğinde işlemler
$success = false;
$error = false;
$messageText = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = trim($_POST["name"] ?? '');
    $email   = trim($_POST["email"] ?? '');
    $message = trim($_POST["message"] ?? '');

    if ($name && $email && $message) {
        // Burada mail gönderme veya veritabanına kaydetme işlemi yapabilirsin
        // Örnek: $mailSuccess = sendMail($name, $email, $message);
        // Eğer mail gönderme yoksa direkt başarılı kabul edelim
        $success = true;
        $messageText = "Mesajınız başarıyla gönderildi.";
    } else {
        $error = true;
        $messageText = "Lütfen tüm alanları doldurun.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>İletişim</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
  <div class="container mt-5" style="max-width:600px;">
    <h2 class="text-center mb-4">İletişim Formu</h2>

    <?php if ($success): ?>
      <div class="alert alert-success" role="alert">
        <?= htmlspecialchars($messageText) ?>
      </div>
    <?php elseif ($error): ?>
      <div class="alert alert-danger" role="alert">
        <?= htmlspecialchars($messageText) ?>
      </div>
    <?php endif; ?>

    <form action="" method="POST" class="shadow p-4 rounded bg-light">
      <div class="mb-3">
        <label for="name" class="form-label">Ad Soyad</label>
        <input
          type="text"
          class="form-control"
          id="name"
          name="name"
          value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>"
          required
        />
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">E-posta Adresi</label>
        <input
          type="email"
          class="form-control"
          id="email"
          name="email"
          value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
          required
        />
      </div>

      <div class="mb-3">
        <label for="message" class="form-label">Mesajınız</label>
        <textarea
          class="form-control"
          id="message"
          name="message"
          rows="5"
          required
        ><?= isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '' ?></textarea>
      </div>

      <button type="submit" class="btn btn-success w-100">Gönder</button>
    </form>
  </div>

<?php require_once 'layouts/footer.php'; ?>
</body>
</html>
