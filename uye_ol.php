<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

$basari = false;
$hata = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ad = $_POST['name'] ?? '';
    $soyad = $_POST['surname'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $tc = $_POST['tc'] ?? '';
    $birthdate = $_POST['birthdate'] ?? '';
    $city = $_POST['city'] ?? '';
    $district = $_POST['district'] ?? '';
    $address = $_POST['address'] ?? '';
    $sponsor = $_POST['sponsor'] ?? '';
    $website = $_POST['website'] ?? '';
    $promo_optin = $_POST['promo_optin'] ?? '';

    // Zorunlu alanlar kontrolü
    if (empty($ad) || empty($soyad) || empty($email) || empty($phone) || empty($tc) || empty($birthdate) || empty($city) || empty($district) || empty($address)) {
        $hata = 'Lütfen tüm alanları doldurunuz.';
    } else {
        $to = "zuhranurr866@gmail.com";
        $subject = "Yeni Farmasi Kayıt Formu";
        $message = "
            <h2>Yeni Kayıt</h2>
            <b>Ad:</b> $ad <br>
            <b>Soyad:</b> $soyad <br>
            <b>E-posta:</b> $email <br>
            <b>Telefon:</b> $phone <br>
            <b>TC Kimlik No:</b> $tc <br>
            <b>Doğum Tarihi:</b> $birthdate <br>
            <b>Şehir:</b> $city <br>
            <b>İlçe:</b> $district <br>
            <b>Adres:</b> $address <br>
            <b>Sponsor Kodu:</b> $sponsor <br>
            <b>Kişisel Web Sitesi:</b> $website <br>
            <b>Promosyon Tercihi:</b> $promo_optin <br>
        ";

        $mail = new PHPMailer(true);
        try {
            // SMTP ayarları
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'zuhranurr866@gmail.com';
            $mail->Password = 'wukz csji tsyh modw';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('zuhranurr866@gmail.com', 'Farmasi Kayıt');
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();
            $basari = true;
        } catch (Exception $e) {
            $hata = "E-posta gönderilemedi. Hata: {$mail->ErrorInfo}";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>
    <style>
        body { background: #f4f4f4; font-family: Arial, sans-serif; }
        .farmasi-form-container {
            max-width: 500px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 32px 28px;
        }
        .farmasi-form-container h2 {
            text-align: center;
            color: #d8006c;
            margin-bottom: 24px;
        }
        .farmasi-form-group {
            margin-bottom: 18px;
        }
        .farmasi-form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
        }
        .farmasi-form-group input,
        .farmasi-form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 15px;
        }
        .farmasi-form-group input[type="checkbox"] {
            width: auto;
        }
        .farmasi-form-actions {
            text-align: center;
            margin-top: 24px;
        }
        .farmasi-form-actions button {
            background: #d8006c;
            color: #fff;
            border: none;
            padding: 14px 0;
            width: 100%;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }
        .farmasi-form-actions button:hover {
            background: #b8005a;
        }
        .farmasi-form-info {
            font-size: 12px;
            color: #555;
            margin-top: 8px;
        }
        .basari-mesaj {
            background: #eaf7f0;
            border: 2px solid #198754;
            color: #198754;
            font-size: 1.2rem;
            text-align: center;
            margin: 40px auto;
            max-width: 500px;
            border-radius: 10px;
            padding: 32px 28px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .hata-mesaj {
            background: #fff0f0;
            border: 2px solid #dc3545;
            color: #dc3545;
            font-size: 1.1rem;
            text-align: center;
            margin: 40px auto;
            max-width: 500px;
            border-radius: 10px;
            padding: 24px 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
    </style>
</head>
<body>
<?php if ($basari): ?>
    <div class="basari-mesaj">Başarıyla gönderildi.</div>
<?php elseif ($hata): ?>
    <div class="hata-mesaj"><?php echo $hata; ?></div>
<?php else: ?>
    <div class="farmasi-form-container">
        <h2>Farmasi Beauty Influencer Kayıt Formu</h2>
        <form method="POST">
            <div class="farmasi-form-group">
                <label for="name">Adınız</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="farmasi-form-group">
                <label for="surname">Soyadınız</label>
                <input type="text" id="surname" name="surname" required>
            </div>
            <div class="farmasi-form-group">
                <label for="email">E-posta</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="farmasi-form-group">
                <label for="phone">Telefon Numarası</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <div class="farmasi-form-group">
                <label for="tc">T.C. Kimlik Numarası</label>
                <input type="text" id="tc" name="tc" maxlength="11" required>
            </div>
            <div class="farmasi-form-group">
                <label for="birthdate">Doğum Tarihi</label>
                <input type="date" id="birthdate" name="birthdate" required>
            </div>
            <div class="farmasi-form-group">
                <label for="city">Şehir</label>
                <input type="text" id="city" name="city" required>
            </div>
            <div class="farmasi-form-group">
                <label for="district">İlçe</label>
                <input type="text" id="district" name="district" required>
            </div>
            <div class="farmasi-form-group">
                <label for="address">Adres</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="farmasi-form-group">
                <label>Promosyonlar ve indirimlerle ilgili SMS / E-posta bildirimleri almak ister misiniz?</label>
                <input type="radio" id="promo_evet" name="promo_optin" value="Evet">
                <label for="promo_evet" style="display:inline;font-weight:400;">Evet</label>
                <input type="radio" id="promo_hayir" name="promo_optin" value="Hayır" checked>
                <label for="promo_hayir" style="display:inline;font-weight:400;">Hayır</label>
                <div class="farmasi-form-info">
                    Yukarıda “EVET” seçeneğini belirlediğinizde, mesaj ve veri ücretleri uygulanabilir. Mesaj sıklığı, sipariş etkinliğinize bağlı olarak değişir. Mesajlarda verilen bağlantıya tıklayarak kısa mesaj ve e-posta aboneliğinizi iptal edebilirsiniz. Daha fazla bilgi için lütfen Gizlilik Politikamızı inceleyin.
                </div>
            </div>
            <div class="farmasi-form-actions">
                <button type="submit">Kayıt Ol</button>
            </div>
        </form>
    </div>
<?php endif; ?>
</body>
</html>