<?php
require_once '../config/db.php';
require_once '../config/functions.php';

$page_title = 'Daftar';

// Redirect if already logged in
if (is_logged_in()) {
    redirect('/ApGuns-Store/index.php');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = clean_input($_POST['username']);
    $email = clean_input($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $full_name = clean_input($_POST['full_name']);
    $phone = clean_input($_POST['phone']);
    $address = clean_input($_POST['address']);

    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($full_name)) {
        $error = 'Semua field wajib diisi kecuali telepon dan alamat!';
    } elseif ($password !== $confirm_password) {
        $error = 'Password dan konfirmasi password tidak cocok!';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid!';
    } else {
        // Check if username or email already exists
        $check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $error = 'Username atau email sudah terdaftar!';
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user
            $insert_query = "INSERT INTO users (username, email, password, full_name, phone, address, role) 
                           VALUES ('$username', '$email', '$hashed_password', '$full_name', '$phone', '$address', 'customer')";

            if (mysqli_query($conn, $insert_query)) {
                set_flash('Registrasi berhasil! Silakan login.', 'success');
                redirect('/ApGuns-Store/pages/login.php');
            } else {
                $error = 'Registrasi gagal: ' . mysqli_error($conn);
            }
        }
    }
}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="form-container">
    <h2 class="text-center">Daftar Akun Baru</h2>

    <?php if (!empty($error)): ?>
        <div class="flash-message error">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>Username *</label>
            <input type="text" name="username" required
                value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
        </div>

        <div class="form-group">
            <label>Email *</label>
            <input type="email" name="email" required
                value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
        </div>

        <div class="form-group">
            <label>Nama Lengkap *</label>
            <input type="text" name="full_name" required
                value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>">
        </div>

        <div class="form-group">
            <label>Telepon</label>
            <input type="tel" name="phone"
                value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="address" rows="3"><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>
        </div>

        <div class="form-group">
            <label>Password *</label>
            <input type="password" name="password" required minlength="6">
        </div>

        <div class="form-group">
            <label>Konfirmasi Password *</label>
            <input type="password" name="confirm_password" required minlength="6">
        </div>

        <button type="submit" class="btn" style="width: 100%;">Daftar</button>
    </form>

    <p class="text-center mt-1">
        Sudah punya akun? <a href="login.php">Login di sini</a>
    </p>
</div>

<?php include '../includes/footer.php'; ?>