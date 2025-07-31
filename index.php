<?php
session_start();
require_once 'includes/db.php';
require_once 'layouts/header.php';
require_once 'layouts/navbar.php';

// Yorum gönderme işlemi
if (isset($_POST['submit_general_comment'])) {
    $name = htmlspecialchars(trim($_POST['name']));
    $comment = htmlspecialchars(trim($_POST['comment']));

    if (!empty($name) && !empty($comment)) {
        $stmt = $pdo->prepare("INSERT INTO general_comments (name, comment) VALUES (?, ?)");
        $stmt->execute([$name, $comment]);

        // Sayfanın tekrar yorum POST etmesini engellemek için yönlendirme yapılıyor
        header("Location: index.php?yorum=ok");
        exit;
    }
}



// Başarılı yorum mesajı
if (isset($_GET['yorum']) && $_GET['yorum'] === 'ok') {
    echo '<div class="alert alert-success text-center mt-3">Yorumunuz başarıyla gönderildi.</div>';
}

// Gönderileri çek
$stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $stmt->fetchAll();
?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Farmasi hakkında detaylı bilgiler" />
    <meta name="author" content="" />
    <title>Farmasi Blog - Doğal Güzellik ve Sağlık</title>
    

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="assets/styles.css" rel="stylesheet" />
</head>
<body>
    <!-- Responsive navbar
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Farmasi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Anasayfa</a></li>
                    <li class="nav-item"><a class="nav-link" href="blog.php">Blog</a></li>
                    <li class="nav-item"><a class="nav-link" href="uye_ol.php">Üye Ol</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">İletişim</a></li>
                </ul>
            </div>
        </div>
    </nav> -->

    <!-- Page content-->
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8">
                <!-- Post content-->
                <article>
                    <!-- Post header-->
                    <header class="mb-4">
                        <h1 class="fw-bolder mb-1">Farmasi Dünyasına Hoş Geldiniz!</h1>
                        <a class="badge bg-secondary text-decoration-none link-light" href="#">Güzellik</a>
                        <a class="badge bg-secondary text-decoration-none link-light" href="#">Sağlık</a>
                    </header>
                    <!-- Preview image figure-->
                    <figure class="mb-4"><img class="img-fluid rounded" src="farmasi.png" alt="Farmasi Ürünleri" /></figure>
                    <!-- Post content-->
                    <section class="mb-5">
                        <p class="fs-5 mb-4">Farmasi, doğal içeriklerle üretilmiş kozmetik ve kişisel bakım ürünleriyle güzellik dünyasına farklı bir bakış açısı kazandırıyor.</p>
                        <p class="fs-5 mb-4">Markamızın misyonu, hem sağlıklı hem de etkili güzellik ürünleri sunarak doğadan ilham alan çözümler geliştirmektir.</p>
                        <p class="fs-5 mb-4">Cilt bakımından makyaj ürünlerine kadar geniş bir yelpazeye sahip olan Farmasi, dünya genelinde milyonlarca kullanıcıya ulaşmaktadır.</p>
                        <h2 class="fw-bolder mb-4 mt-5">Farmasi Ürünleri ve Faydaları</h2>
                        <p class="fs-5 mb-4">Farmasi’nin ürün gamında yer alan bitkisel içerikli kozmetik ürünleri, cildinizi korurken aynı zamanda doğal bir güzellik sunar.</p>
                        <p class="fs-5 mb-4">Özellikle parabensiz ve zararlı kimyasallardan arındırılmış formülleriyle Farmasi, güvenli ve etkili güzellik ürünleri sunmaktadır.</p>
                    </section>
                </article>

                <!-- Genel Yorumlar Bölümü -->
                <section class="mb-5">
                    <div class="card bg-light">
                        <div class="card-body">
                            <!-- Yorum Formu -->
                            <form method="POST" class="mb-4">
                                <textarea class="form-control" name="comment" rows="3" placeholder= "Adınız" required></textarea>
                                <input type="text" name="name" class="form-control mt-2" placeholder= "Düşüncelerinizi paylaşın!" required>
                                <button type="submit" name="submit_general_comment" class="btn btn-primary mt-2">Gönder</button>
                            </form>

                            <!-- Yorumları Listele -->
                            <?php
                            $stmt = $pdo->query("SELECT * FROM general_comments ORDER BY created_at DESC LIMIT 10");
                            $comments = $stmt->fetchAll();

                            if ($comments):
                                foreach ($comments as $c):
                            ?>
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center" 
                                         style="width:40px; height:40px; font-weight:bold; font-size:1.25rem;">
                                        <?php echo strtoupper(mb_substr($c['name'], 0, 1)); ?>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <div class="fw-bold"><?php echo htmlspecialchars($c['name']); ?></div>
                                    <small class="text-muted"><?php echo $c['created_at']; ?></small>
                                    <p class="mb-0"><?php echo nl2br(htmlspecialchars($c['comment'])); ?></p>
                                </div>
                            </div>
                            <?php endforeach; 
                            else: ?>
                                <p>Henüz yorum yapılmamış.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Side widgets -->
            <div class="col-lg-4">
                <!-- Search widget -->
                <div class="card mb-4">
                    <div class="card-header">Arama</div>
                    <div class="card-body">
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Arama yapın..." />
                            <button class="btn btn-primary" type="button">Git!</button>
                        </div>
                    </div>
                </div>
                <!-- Categories widget -->
                <div class="card mb-4">
                    <div class="card-body">
                    <?php
$stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $stmt->fetchAll();
?>

<div class="mb-4">
    <h5 class="fw-bold">Kategoriler</h5>
    <ul class="list-group">
        <?php foreach ($categories as $kategori): ?>
            <li class="list-group-item">
            <a href="kategori.php?id=<?= $kategori['id'] ?>" class="kategori-link">
            <?= htmlspecialchars($kategori['name']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
require_once 'layouts/footer.php';
?>
