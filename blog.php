<?php
session_start();
require_once 'includes/db.php';
require_once 'layouts/header.php';
require_once 'layouts/navbar.php';

$stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $stmt->fetchAll();
?>

<style>
.blog-post-list {
    max-width: 1500px;
    margin: 0 auto;
}
.post {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    padding: 24px 20px;
    margin-bottom: 32px;
}
.post h2 {
    margin-top: 0;
    font-size: 1.5rem;
}
</style>

<div class="container mt-5 blog-post-list">
  <h1 class="mb-4 text-center">Blog Gönderileri</h1>

  <!-- <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
    <div class="alert alert-info text-center" role="alert">
      <strong>Yeni Gönderi Eklendi!</strong> Bu gönderi admin panelinden eklenmiştir.
    </div>
  <?php endif; ?> -->

  <?php if ($posts): ?>
    <div class="row g-4">
      <?php foreach ($posts as $post): ?>
        <?php
        $imagePath = !empty($post['image']) && file_exists('uploads/' . $post['image'])
            ? 'uploads/' . htmlspecialchars($post['image'])
            : 'uploads/default.jpg';
        ?>
        <div class="col-12">
          <div class="card flex-row shadow-sm h-100">
            <img src="<?= $imagePath ?>" class="card-img-left" alt="<?= htmlspecialchars($post['title']) ?>" style="width: 200px; object-fit: cover;">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
              <p class="card-text flex-grow-1"><?= htmlspecialchars(mb_strimwidth(strip_tags($post['content']), 0, 200, '...')) ?></p>
              <a href="post_detail.php?id=<?= $post['id'] ?>" class="btn btn-primary align-self-start">Devamını Oku</a>
              <small class="text-muted mt-3">Yayınlanma Tarihi: <?= date('d.m.Y', strtotime($post['created_at'])) ?></small>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
      <div class="text-center">
        <p class="text-muted">Henüz gönderi bulunamadı.</p>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</div>

<?php require_once 'layouts/footer.php'; ?>
