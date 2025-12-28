<?php
require_once '../config/db.php';
require_once '../config/functions.php';

$page_title = 'Profil Saya';

if (!is_logged_in()) {
    set_flash('Silakan login terlebih dahulu!', 'error');
    redirect('/ApGuns-Store/pages/login.php');
}

$user_id = $_SESSION['user_id'];
$user_query = "SELECT * FROM users WHERE id = $user_id";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = clean_input($_POST['full_name']);
    $phone = clean_input($_POST['phone']);
    $address = clean_input($_POST['address']);

    $update_query = "UPDATE users SET full_name = '$full_name', phone = '$phone', address = '$address' WHERE id = $user_id";

    if (mysqli_query($conn, $update_query)) {
        set_flash('Profil berhasil diperbarui!', 'success');
        redirect('/ApGuns-Store/pages/profile.php');
    } else {
        $error = 'Gagal memperbarui profil!';
    }
}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="form-container">
    <h2 class="text-center">Profil Saya</h2>

    <?php if (!empty($error)): ?>
        <div class="flash-message error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" value="<?php echo $user['username']; ?>" readonly style="background: #f5f5f5;">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" value="<?php echo $user['email']; ?>" readonly style="background: #f5f5f5;">
        </div>

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="full_name" value="<?php echo $user['full_name']; ?>" required>
        </div>

        <div class="form-group">
            <label>Telepon</label>
            <input type="tel" name="phone" value="<?php echo $user['phone']; ?>">
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="address" rows="4"><?php echo $user['address']; ?></textarea>
        </div>

        <button type="submit" class="btn btn-success" style="width: 100%;">Update Profil</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>