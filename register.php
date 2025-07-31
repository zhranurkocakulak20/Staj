<?php
// Form gönderildiyse, verileri işleyelim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'includes/db.php'; // Veritabanı bağlantısını dahil et

    $username = $_POST['username'];  // Kullanıcı Adı
    $email = $_POST['email'];        // E-posta
    $password = $_POST['password'];  // Şifre
    $sponsor_code = $_POST['sponsor_code'] ?? null; // Sponsor kodu (isteğe bağlı)
    $website = $_POST['website'] ?? null; // Kişiselleştirilmiş web sitesi
    $promo_optin = $_POST['promo_optin'] ?? null; // Promosyon tercihi

    // Basit doğrulama: boş alan kontrolü
    if (empty($username) || empty($email) || empty($password)) {
        echo "Lütfen tüm alanları doldurun!";
    } else {
        // Veritabanı bağlantısı zaten yapıldı (db.php'den)
        try {
            // Şifreyi güvenlik amacıyla hash'leyelim
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Kullanıcıyı veritabanına ekleyelim (yeni alanlar için de ekleme yapılabilir)
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, sponsor_code, website, promo_optin) VALUES (:username, :email, :password, :sponsor_code, :website, :promo_optin)");
            $stmt->execute([
                'username' => $username,
                'email' => $email,
                'password' => $hashedPassword,
                'sponsor_code' => $sponsor_code,
                'website' => $website,
                'promo_optin' => $promo_optin
            ]);

            echo "Kayıt başarılı! Şimdi giriş yapabilirsiniz.";
        } catch (PDOException $e) {
            die("Veritabanı hatası: " . $e->getMessage());
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
        /* Stil kodları */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 15px;
            width: 100%;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .form-footer {
            text-align: center;
            margin-top: 15px;
            color: #777;
        }

        .form-footer a {
            color: #4CAF50;
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Kayıt Ol</h2>
        <!-- Kayıt formu -->
        <form method="POST">
            <input type="text" name="username" placeholder="Kullanıcı Adı" required>
            <input type="email" name="email" placeholder="E-posta" required>
            <input type="password" name="password" placeholder="Şifre" required>
            <input type="text" name="sponsor_code" placeholder="Lütfen sponsor kodunuzu girin (isteğe bağlı)">
            <input type="text" name="website" placeholder="Kişiselleştirilmiş Web Sitenizi Oluşturun">
            <div style="margin: 10px 0;">
                <label>Promosyonlar ve indirimlerle ilgili SMS / E-posta bildirimleri almak ister misiniz?</label><br>
                <input type="radio" id="promo_evet" name="promo_optin" value="Evet">
                <label for="promo_evet">Evet</label>
                <input type="radio" id="promo_hayir" name="promo_optin" value="Hayır" checked>
                <label for="promo_hayir">Hayır</label>
                <div style="font-size: 12px; color: #555; margin-top: 5px;">
                    Yukarıda “EVET” seçeneğini belirlediğinizde, mesaj ve veri ücretleri uygulanabilir. Mesaj sıklığı, sipariş etkinliğinize bağlı olarak değişir. Mesajlarda verilen bağlantıya tıklayarak kısa mesaj ve e-posta aboneliğinizi iptal edebilirsiniz. Daha fazla bilgi için lütfen Gizlilik Politikamızı inceleyin.
                </div>
            </div>
            <button type="submit">Kayıt Ol</button>
        </form>
        
        <!-- Kayıt olma bağlantısı -->
        <div class="form-footer">
            <p>Zaten hesabınız var mı? <a href="login.php">Giriş Yapın</a></p>
        </div>
    </div>

</body>
</html>
