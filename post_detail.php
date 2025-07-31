<?php
require_once 'includes/db.php';
require_once 'layouts/header.php';
require_once 'layouts/navbar.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
$stmt->execute(['id' => $id]);
$post = $stmt->fetch();

if (!$post) {
    // Sadece admin için mesaj göster
    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
        echo '<div class="container mt-5">';
        echo '<div class="alert alert-danger text-center">Gönderi bulunamadı.</div>';
        echo '</div>';
    }
    require_once 'layouts/footer.php';
    exit;
}
?>

<div class="post-detail">
    <h1><?php echo $post['title']; ?></h1>
    <p><?php echo $post['content']; ?></p>
</div>

<?php
require_once 'layouts/footer.php';
?>
