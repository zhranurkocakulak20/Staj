<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo 'Bu sayfayı görüntülemek için yetkiniz yok.';
    exit;
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Kullanıcıyı sil
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute(['id' => $user_id]);

    header('Location: admin.php'); // Admin paneline yönlendir
    exit;
} else {
    echo 'Kullanıcı ID\'si belirtilmemiş.';
    exit;
}
?>
