<?php
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Şifreyi güvenli bir şekilde hash'leyelim

    // Veritabanına kullanıcıyı ekle
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
    $stmt->execute([
        'username' => $username,
        'email' => $email,
        'password' => $password
    ]);

    echo 'Kayıt başarılı! Giriş yapabilirsiniz.';
}
?>

<form action="signup.php" method="POST">
    <label for="username">Kullanıcı Adı:</label><br>
    <input type="text" name="username" required><br><br>

    <label for="email">E-posta:</label><br>
    <input type="email" name="email" required><br><br>

    <label for="password">Şifre:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Kaydol</button>
</form>
