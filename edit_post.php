<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo 'Bu sayfayı görüntülemek için yetkiniz yok.';
    exit;
}

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // Gönderiyi al
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
    $stmt->execute(['id' => $post_id]);
    $post = $stmt->fetch();

    if ($post) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $category = $_POST['category'];

            // Güncelleme işlemi
            $update_stmt = $pdo->prepare("UPDATE posts SET title = :title, content = :content, category = :category WHERE id = :id");
            $update_stmt->execute([
                'title' => $title,
                'content' => $content,
                'category' => $category,
                'id' => $post_id
            ]);

            header('Location: admin.php'); // Admin paneline yönlendir
            exit;
        }
    } else {
        echo 'Gönderi bulunamadı.';
        exit;
    }
} else {
    echo 'Gönderi ID\'si belirtilmemiş.';
    exit;
}
?>

<form action="edit_post.php?id=<?php echo $post['id']; ?>" method="POST">
    <label for="title">Başlık:</label><br>
    <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required><br><br>

    <label for="content">İçerik:</label><br>
    <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea><br><br>

    <label for="category">Kategori:</label><br>
    <input type="text" name="category" value="<?php echo htmlspecialchars($post['category']); ?>" required><br><br>

    <button type="submit">Gönderiyi Güncelle</button>
</form>
