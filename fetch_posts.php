<?php
require_once 'includes/db.php';

if (isset($_GET['subcategory_id'])) {
    $sub_id = (int)$_GET['subcategory_id'];

    $stmt = $pdo->prepare("SELECT * FROM posts WHERE subcategory_id = ? ORDER BY created_at DESC");
    $stmt->execute([$sub_id]);
    $posts = $stmt->fetchAll();

    if ($posts) {
        foreach ($posts as $post) {
            echo '<div class="card mb-3">';
            echo '<div class="card-body">';
            echo '<h5>' . htmlspecialchars($post['title']) . '</h5>';
            echo '<p>' . nl2br(htmlspecialchars($post['content'])) . '</p>';
            echo '</div></div>';
        }
    } else {
        echo '<p>Bu alt kategoriye ait gönderi bulunamadı.</p>';
    }
} else {
    echo '<p>Alt kategori seçilmedi.</p>';
}
?>
