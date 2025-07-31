<?php
require_once 'includes/db.php';
require_once 'layouts/header.php';
require_once 'layouts/navbar.php';

if (isset($_GET['id'])) {
    $kategori_id = $_GET['id'];

    // Seçilen kategoriye ait postları çek
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE category_id = ? ORDER BY created_at DESC");
    $stmt->execute([$kategori_id]);
    $posts = $stmt->fetchAll();

    // Alt kategorileri çek
    $stmtSub = $pdo->prepare("SELECT * FROM subcategories WHERE category_id = ?");
    $stmtSub->execute([$kategori_id]);
    $subcategories = $stmtSub->fetchAll();
} else {
    $posts = [];
    $subcategories = [];
}

echo '<div class="container mt-5">';
echo '<div class="row">';

// SOL SÜTUN: Alt Kategoriler
echo '<div class="col-md-3">';
echo '<h5>Alt Kategoriler</h5>';
if ($subcategories) {
    echo '<ul class="list-group">';
    foreach ($subcategories as $sub) {
        echo '<li class="list-group-item">';
        echo '<a href="altkategori.php?id=' . $sub['id'] . '">' . htmlspecialchars($sub['name']) . '</a>';
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo '<p>Alt kategori bulunamadı.</p>';
}
echo '</div>';

// SAĞ SÜTUN: Gönderiler
echo '<div class="col-md-9">';
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
        echo '<p>Bu kategoriye ait gönderi bulunamadı.</p>';
    }
}
echo '</div>'; // col-md-9

echo '</div>'; // row
echo '</div>'; // container

require_once 'layouts/footer.php';
?>
