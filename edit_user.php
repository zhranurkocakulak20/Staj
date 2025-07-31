<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo 'Bu sayfayı görüntülemek için yetkiniz yok.';
    exit;
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Kullanıcıyı al
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch();

    if ($user) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $role = $_POST['role'];

            // Güncelleme işlemi
            $update_stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email, role = :role WHERE id = :id");
            $update_stmt->execute([
                'username' => $username,
                'email' => $email,
                'role' => $role,
                'id' => $user_id
            ]);

            header('Location: admin.php'); // Admin paneline yönlendir
            exit;
        }
    } else {
        echo 'Kullanıcı bulunamadı.';
        exit;
    }
} else {
    echo 'Kullanıcı ID\'si belirtilmemiş.';
    exit;
}
?>

<form action="edit_user.php?id=<?php echo $user['id']; ?>" method="POST">
    <label for="username">Kullanıcı Adı:</label><br>
    <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br><br>

    <label for="email">E-posta:</label><br>
    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>

    <label for="role">Rol:</label><br>
    <select name="role" required>
        <option value="user" <?php echo ($user['role'] == 'user') ? 'selected' : ''; ?>>Kullanıcı</option>
        <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
    </select><br><br>

    <button type="submit">Kullanıcıyı Güncelle</button>
</form>
