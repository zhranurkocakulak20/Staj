<?php
// Hata ayıklama modunu aktif et (sadece geliştirme ortamında kullan)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$dbname = 'farmasi';
$username = 'root';
$password = '';
$charset = 'utf8mb4';

try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,           // Hataları göster
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,      // Kolay veri çekme
        PDO::ATTR_EMULATE_PREPARES => false,                   // Gerçek prepared statements
    ]);
} catch (PDOException $e) {
    die('Veritabanı bağlantısı hatası: ' . $e->getMessage());
}
?>
