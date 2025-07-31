<?php
session_start();
require_once 'includes/db.php';
require_once 'layouts/header.php';
require_once 'layouts/navbar.php';

// Admin kontrolü
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo '<div class="alert alert-danger mt-5 text-center">Bu sayfayı görüntülemek için yetkiniz yok.</div>';
    exit;
}

// Yeni Gönderi Ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_post'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $subcategory_id = $_POST['subcategory_id'] ?? null;

    $stmt = $pdo->prepare("INSERT INTO posts (title, content, category, subcategory_id, created_at) VALUES (:title, :content, :category, :subcategory_id, NOW())");
    $stmt->execute([
        'title' => $title,
        'content' => $content,
        'category' => $category,
        'subcategory_id' => $subcategory_id
    ]);

    header('Location: admin.php');
    exit;
}

// Kategorileri ve alt kategorileri çek
$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();
$subcategories = $pdo->query("SELECT * FROM subcategories ORDER BY name ASC")->fetchAll();

$posts = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC")->fetchAll();
$users = $pdo->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll();
?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Yönetim Paneli</h2>
        <a href="register.php" class="btn btn-success">+ Yeni Kullanıcı Ekle</a>
    </div>

    <!-- Yeni Gönderi Ekleme Formu -->
    <div class="card mb-5">
        <div class="card-header bg-primary text-white">
            Yeni Gönderi Ekle
        </div>
        <div class="card-body">
            <form method="POST" action="admin.php">
                <div class="mb-3">
                    <label for="title" class="form-label">Başlık</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">İçerik</label>
                    <textarea name="content" class="form-control" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Kategori</label>
                    <input type="text" name="category" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="subcategory_id" class="form-label">Alt Kategori (İsteğe Bağlı)</label>
                    <select name="subcategory_id" class="form-control">
                        <option value="">Alt Kategori Seçin</option>
                        <?php foreach ($subcategories as $subcategory): ?>
                            <option value="<?= $subcategory['id'] ?>"><?= htmlspecialchars($subcategory['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" name="new_post" class="btn btn-primary">Gönderiyi Ekle</button>
            </form>
        </div>
    </div>

    <!-- Gönderiler -->
    <h3>Gönderiler</h3>
    <?php if ($posts) { ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Başlık</th>
                        <th>İçerik</th>
                        <th>Kategori</th>
                        <th>Alt Kategori</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post) { 
                        // Alt kategori bilgisini al
                        $subcategory_name = '';
                        if (!empty($post['subcategory_id'])) {
                            $stmt = $pdo->prepare("SELECT name FROM subcategories WHERE id = ?");
                            $stmt->execute([$post['subcategory_id']]);
                            $subcategory = $stmt->fetch();
                            $subcategory_name = $subcategory ? $subcategory['name'] : '';
                        }
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($post['title']) ?></td>
                            <td><?= htmlspecialchars(substr($post['content'], 0, 100)) ?>...</td>
                            <td><?= htmlspecialchars($post['category']) ?></td>
                            <td><?= htmlspecialchars($subcategory_name) ?></td>
                            <td>
                                <a href="edit_post.php?id=<?= $post['id'] ?>" class="btn btn-sm btn-warning">Düzenle</a>
                                <a href="delete_post.php?id=<?= $post['id'] ?>" class="btn btn-sm btn-danger">Sil</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else {
        echo '<p class="text-muted">Henüz gönderi yok.</p>';
    } ?>

    <!-- Kullanıcılar -->
    <h3 class="mt-5">Kullanıcılar</h3>
    <?php if ($users) { ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Kullanıcı Adı</th>
                        <th>E-posta</th>
                        <th>Rol</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['role']) ?></td>
                            <td>
                                <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">Düzenle</a>
                                <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger">Sil</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else {
        echo '<p class="text-muted">Henüz kayıtlı kullanıcı yok.</p>';
    } ?>
</div>

<?php require_once 'layouts/footer.php'; ?>
