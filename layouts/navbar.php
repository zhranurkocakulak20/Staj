<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
} 
require_once 'includes/db.php';
require_once 'includes/functions.php';
?>

<nav>
    <ul>
        <li><a href="index.php">Ana Sayfa</a></li>

        <?php if (!isset($_SESSION['user'])): ?>
            <li><a href="login.php">Giriş Yap</a></li>
        <?php else: ?>
            <li><a href="admin.php">Kontrol Paneli</a></li>
            <li><a href="logout.php">Çıkış Yap</a></li>
        <?php endif; ?>
    </ul>
</nav>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Farmasi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Anasayfa</a></li>
                    <li class="nav-item"><a class="nav-link" href="blog.php">Blog</a></li>
                    
                    <!-- Kategoriler Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Kategoriler
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php 
                            $categories = getCategories($pdo);
                            foreach ($categories as $category): 
                            ?>
                                <li><a class="dropdown-item" href="kategori.php?id=<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    
                    <li class="nav-item"><a class="nav-link" href="uye_ol.php">Üye Ol</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">İletişim</a></li>
                </ul>
            </div>
        </div>
    </nav>