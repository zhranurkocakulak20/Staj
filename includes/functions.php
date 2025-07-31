<?php
function showBreadcrumb($pdo, $subcategory_id) {
    // Alt kategoriyi getir
    $stmtSub = $pdo->prepare("SELECT * FROM subcategories WHERE id = ?");
    $stmtSub->execute([$subcategory_id]);
    $sub = $stmtSub->fetch();

    if (!$sub) return;

    // Üst kategoriyi getir
    $stmtCat = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmtCat->execute([$sub['category_id']]);
    $category = $stmtCat->fetch();

    // Breadcrumb HTML'si
    echo '<nav aria-label="breadcrumb">';
    echo '<ol class="breadcrumb">';
    echo '<li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>';

    if ($category) {
        echo '<li class="breadcrumb-item"><a href="kategori.php?id=' . $category['id'] . '">' . htmlspecialchars($category['name']) . '</a></li>';
    }

    echo '<li class="breadcrumb-item active" aria-current="page">' . htmlspecialchars($sub['name']) . '</li>';
    echo '</ol>';
    echo '</nav>';
}

function getCategories($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM categories ORDER BY name ASC");
    $stmt->execute();
    return $stmt->fetchAll();
}

function getSubcategories($pdo, $category_id) {
    $stmt = $pdo->prepare("SELECT * FROM subcategories WHERE category_id = ? ORDER BY name ASC");
    $stmt->execute([$category_id]);
    return $stmt->fetchAll();
}
?>
