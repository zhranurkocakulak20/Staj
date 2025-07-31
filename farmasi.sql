-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 24 Mar 2025, 09:36:01
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `farmasi`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `category`, `created_at`) VALUES
(4, 'sdfghjkı', 'qwedrfty', 'asdfgh', '2025-03-19 10:31:29'),
(5, 'sdfghjkı', 'dfghjk', 'vbnmöç', '2025-03-19 20:14:20');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `email`, `created_at`) VALUES
(1, 'nur_20', '$2y$10$UmVzkSyxfws23KGqk3QkTOxFrv6XgGHelytPrCpn65yix5PGTwHAe', 'admin', 'z@g.com', '2025-03-19 10:14:45'),
(3, 'onur', '$2y$10$AIdJN92v.lJxw1oPkxHEb.cpL5m1BlZwTmyaMdfd2VlPD243Tojvu', 'user', 'o@h.com', '2025-03-19 10:14:45'),
(5, 'eyüp', '$2y$10$iNsbfe4SArvWOCFccHf2eeeFvkGdcBmmPDRf/FQEfH7KPXxnmz1p.', 'user', 'e@y.com', '2025-03-24 06:29:52');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- Anasayfadaki yorumlar için 
CREATE TABLE general_comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    comment TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
 
--  kategori klasörünü oluşturmak için
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- kategoriye alt başlık eklemek için
INSERT INTO categories (name) VALUES
('Makyaj'),
('Cilt Bakımı'),
('Kişisel Bakım'),
('Saç Bakımı'),
('Parfüm'),
('Erkek'),
('Nutriplus'),
('Mr. Wipes');


CREATE TABLE general_comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    comment TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
  
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);



ALTER TABLE posts ADD category_id INT NOT NULL AFTER id;



-- kategori altına alt başlık için 
CREATE TABLE subcategories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- başlıkların isimleri
-- katgori IDleri : 1 makyaj 2 cilt bakımı 3 kişisel bakım 4 saç bakımı
-- 5 parfüm 6 erkek 7 nutriplus 8 Mr.wipes

INSERT INTO subcategories (category_id, name) VALUES
(1, 'Yüz'), 
(1, 'Göz'),
(1, 'Dudak'),
(1, 'Tırnak'),
(1, 'Makyaj Temizleme'),

INSERT INTO subcategories (category_id, name) VALUES
(2, 'Akne ve Gözenek Karşıtı Bakım'), 
(2, 'Kuru ve Hassas Cilt Bakımı'),
(2, 'Nemlendirici ve Yatıştırıcı Bakım'),
(2, 'Renk Eşitsizliği Ve Leke Karşıtı Bakım'),
(2, 'Yaşlanma ve Kırışık Karşıtı Bakım'),
(2, 'Güneş Koruyucu Bakım');

INSERT INTO subcategories (category_id, name) VALUES
(3, 'Ağız Bakım'), 
(3, 'Vücut Bakım'),
(3, 'Deodorant & Roll On'),
(3, 'Masaj & Rahatlama');

INSERT INTO subcategories (category_id, name) VALUES
(4, 'Reviving Serisi'),  
(4, 'Hydrating Serisi'),
(4, 'Volumizing Serisi'),
(4, 'Vitalizing Sarımsak Serisi'),
(4, 'Intensive Repair Serisi'),
(4, 'Styling Serisi'),
(4, 'Profesyonel Keratin Serisi'),
(4, 'Botanics Serisi'),
(4, 'Lavanta Serisi'), 
(4, 'Saç Spreyi'),
(4, 'Saç Köpüğü'),
(4, 'Kuru Şampuan'),
(4, 'Spreyler'),
(4, 'Serumlar & Bakım Yağları'), 
(4, 'Kremler & Maskeler'),
(4, 'Şampuanlar'),
(4, 'Saç Boyaları'),


INSERT INTO subcategories (category_id, name) VALUES
(5, 'Erkek'),  
(5, 'Kadın');


INSERT INTO subcategories (category_id, name) VALUES
(6, 'Kişisel Bakım'),  
(6, 'Saç Bakım'),
(6, 'Parfüm'),  
(6, 'Masculine Serisi');


INSERT INTO subcategories (category_id, name) VALUES
(7, 'Kilo Kontrol'),
(7, 'Shake'),  
(7, 'Çay&Kahveler'),
(7, 'Vitaminler'),  
(7, 'Kollajenler'),
(7, 'Güzellik'), 
(7, 'Genel Sağlık'),  
(7, 'Özel Takviyeler'),  
(7, 'Gummy');


INSERT INTO subcategories (category_id, name) VALUES
(8, 'Çamaşır Yıkama'),  
(8, 'Bulaşık Yıkama'), 
(8, 'Genel Temizlik');


ALTER TABLE posts ADD subcategory_id INT DEFAULT NULL;
