<?php
require_once 'includes/db.php';
require_once 'layouts/header.php';
require_once 'layouts/navbar.php';

// Kategorileri ve alt kategorileri çekiyoruz
$stmt = $pdo->query("SELECT sc.id AS subcategory_id, sc.name AS subcategory_name, c.name AS category_name 
                     FROM subcategories sc
                     JOIN categories c ON sc.category_id = c.id
                     ORDER BY c.name, sc.name");
$rows = $stmt->fetchAll();
?>

<div class="container mt-4">
    <h2>Alt Kategoriler Listesi</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Alt Kategori</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody id="kategori-listesi">
            <?php foreach ($rows as $row): ?>
                <tr data-subcategory-id="<?php echo $row['subcategory_id']; ?>" style="cursor:pointer;">
                    <td><?php echo htmlspecialchars($row['subcategory_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div id="icerik-alani" class="mt-4">
        <p>Alt kategoriye tıkladığınızda içerik burada gösterilecek.</p>
    </div>
</div>

<script>
document.querySelectorAll('#kategori-listesi tr').forEach(row => {
    row.addEventListener('click', () => {
        const subId = row.getAttribute('data-subcategory-id');
        fetch('fetch_posts.php?subcategory_id=' + subId)
            .then(response => response.text())
            .then(html => {
                document.getElementById('icerik-alani').innerHTML = html;
            })
            .catch(err => {
                document.getElementById('icerik-alani').innerHTML = '<p>İçerik yüklenirken hata oluştu.</p>';
                console.error(err);
            });
    });
});
</script>

<?php require_once 'layouts/footer.php'; ?>
