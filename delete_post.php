<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo 'Bu sayfayı görüntülemek için yetkiniz yok.';
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM posts WHERE id = :id");
$stmt->execute(['id' => $id]);

header('Location: admin.php');
?>
