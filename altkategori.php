<style>
/* Breadcrumb tasarımı */
.breadcrumb {
    background-color: transparent !important;
    padding: 0;
    margin-bottom: 1rem;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: ">";
    padding: 0 8px;
    color: #666;
}

.breadcrumb-item a {
    text-decoration: none;
    color: #000;
}

.breadcrumb-item.active {
    color: #888;
}
</style>

<?php
require_once 'includes/db.php';
require_once 'layouts/header.php';
require_once 'layouts/navbar.php';
require_once 'includes/functions.php';

if (isset($_GET['id'])) {
    $sub_id = $_GET['id'];

    // Alt kategori bilgisi çekiliyor
    $stmtSub = $pdo->prepare("SELECT * FROM subcategories WHERE id = ?");
    $stmtSub->execute([$sub_id]);
    $sub = $stmtSub->fetch();

    if ($sub) {
        // Üst kategori bilgisi alınıyor
        $stmtCat = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
        $stmtCat->execute([$sub['category_id']]);
        $category = $stmtCat->fetch();

        echo '<div class="container mt-4">';

        // Galeri verilerini ayrıştır
        $gallery_images = isset($sub['gallery_images']) ? $sub['gallery_images'] : '';
        $gallery_descriptions = isset($sub['gallery_descriptions']) ? $sub['gallery_descriptions'] : '';

        $imageArray = !empty($gallery_images) ? explode(',', $gallery_images) : [];
        $descArray = !empty($gallery_descriptions) ? explode(',', $gallery_descriptions) : [];

        // Breadcrumb (navigasyon izi)
        echo '<nav aria-label="breadcrumb">';
        echo '<ol class="breadcrumb custom-breadcrumb">';
        echo '<li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>';

        if ($category) {
            echo '<li class="breadcrumb-item"><a href="kategori.php?id=' . $category['id'] . '">' . htmlspecialchars($category['name']) . '</a></li>';
        }

        echo '<li class="breadcrumb-item active" aria-current="page">' . htmlspecialchars($sub['name']) . '</li>';
        echo '</ol>';
        echo '</nav>';

        // Başlık
        echo '<h2>' . htmlspecialchars($sub['name']) . '</h2>';
        echo '<hr>';

        // Galeri görselleri
        if (!empty($imageArray)) {
            echo '<div class="row">';

            foreach ($imageArray as $index => $img) {
                $desc = isset($descArray[$index]) ? htmlspecialchars($descArray[$index]) : '';
                echo '<div class="col-md-4 mb-4">';  // 3 resim yan yana
                echo '<div class="card h-100 shadow-sm">';
                echo '<img src="img/altkategori/' . htmlspecialchars(trim($img)) . '" class="card-img-top img-fluid" style="max-height: 250px; max-width: 100%; object-fit: contain; margin: auto; display: block;" alt="Galeri Görseli">';
                echo '<div class="card-body">';
                echo '<p class="card-text">' . $desc . '</p>';
                echo '</div></div></div>';
            }

            echo '</div>'; // row sonu
        }

        // Alt kategoriye ait gönderiler
        $stmt = $pdo->prepare("SELECT * FROM posts WHERE subcategory_id = ? ORDER BY created_at DESC");
        $stmt->execute([$sub_id]);
        $posts = $stmt->fetchAll();

        if ($posts) {
            foreach ($posts as $post) {
                echo '<div class="card mb-3">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . htmlspecialchars($post['title']) . '</h5>';
                echo '<p class="card-text">' . htmlspecialchars($post['content']) . '</p>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            // Sadece admin için mesaj göster
            if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
                echo '<p>Bu alt kategoriye ait gönderi bulunamadı.</p>';
            }
        }

        echo '</div>'; // container kapatma
    } else {
        echo '<div class="container mt-5"><p>Alt kategori bulunamadı.</p></div>';
    }
} else {
    echo '<div class="container mt-5"><p>Alt kategori ID’si belirtilmemiş.</p></div>';
}

require_once 'layouts/footer.php';
?>
