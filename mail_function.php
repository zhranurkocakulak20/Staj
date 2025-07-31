<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendMail($name, $email, $message) {
    $mail = new PHPMailer(true);

    try {
        // SMTP ayarları
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'zuhranurr866@gmail.com'; // kendi gmail adresin
        $mail->Password   = 'wukz csji tsyh modw';      // Gmail için "Uygulama Şifresi" (aşağıda açıklanıyor)
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Gönderen ve alıcı
        $mail->setFrom($email, $name);
        $mail->addAddress('zuhranurr866@gmail.com'); // alıcı (kendin)

        // İçerik
        $mail->isHTML(false);
        $mail->Subject = 'Yeni İletişim Formu Mesajı';
        $mail->Body    = "Ad Soyad: $name\nE-posta: $email\n\nMesaj:\n$message";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
