<?php
session_start();  // Oturumu başlat
session_unset();  // Tüm oturum verilerini temizle
session_destroy();  // Oturumu sonlandır

// Çıkış yaptıktan sonra anasayfaya yönlendirme yap
header('Location: index.php');
exit();
?>
