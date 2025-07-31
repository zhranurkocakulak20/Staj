<?php
// mail_function.php'yi dahil et
require_once 'mail_function.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = trim($_POST["name"] ?? '');
    $email   = trim($_POST["email"] ?? '');
    $message = trim($_POST["message"] ?? '');

    if ($name && $email && $message) {
        if (sendMail($name, $email, $message)) {
            echo "<h3 style='color: green; text-align: center;'>✅ Mesajınız gönderildi.</h3>";
        } else {
            echo "<h3 style='color: red; text-align: center;'>❌ Mail gönderilemedi. Sunucu mail() fonksiyonunu destekliyor mu?</h3>";
        }
    } else {
        echo "<h3 style='color: orange; text-align: center;'>❗ Lütfen tüm alanları doldurun.</h3>";
    }
} else {
    echo "<h3 style='color: gray; text-align: center;'>Bu sayfa doğrudan görüntülenemez.</h3>";
}
?>
