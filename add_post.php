<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo 'Bu sayfayı görüntülemek için yetkiniz yok.';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];

    // Gönderiyi veritabanına ekle
    $stmt = $pdo->prepare("INSERT INTO posts (title, content, category) VALUES (:title, :content, :category)");
    $stmt->execute(['title' => $title, 'content' => $content, 'category' => $category]);

    header('Location: admin.php');
}
?>

<form method="POST">
    <input type="text" name="title" placeholder="Başlık" required>
    <textarea name="content" placeholder="İçerik" required></textarea>
    <input type="text" name="category" placeholder="Kategori" required>
    <button type="submit">Gönderiyi Ekle</button>
</form>
