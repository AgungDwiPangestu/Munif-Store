<?php

/**
 * Reset Admin Password Tool
 * Jalankan file ini untuk reset password admin ke "admin123"
 * 
 * PENTING: Hapus file ini setelah selesai untuk keamanan!
 */

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'munif_store';

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("<h2 style='color: red;'>❌ Koneksi database gagal: " . mysqli_connect_error() . "</h2>");
}

echo "<!DOCTYPE html>
<html>
<head>
    <title>Reset Password Admin</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .box { background: #f5f5f5; padding: 20px; border-radius: 10px; margin: 20px 0; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        code { background: #e9ecef; padding: 2px 6px; border-radius: 3px; }
    </style>
</head>
<body>";

echo "<h1>🔐 Reset Password Admin</h1>";
echo "<hr>";

// Generate new password hash
$new_password = 'admin123';
$password_hash = password_hash($new_password, PASSWORD_DEFAULT);

echo "<div class='box info'>";
echo "<h3>ℹ️ Informasi</h3>";
echo "<p>Tool ini akan mereset password admin ke: <code>admin123</code></p>";
echo "<p>Hash yang akan digunakan: <code>" . htmlspecialchars(substr($password_hash, 0, 50)) . "...</code></p>";
echo "</div>";

// Check if admin user exists
$check_query = "SELECT id, username, email, role FROM users WHERE username = 'admin' OR role = 'admin'";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) == 0) {
    echo "<div class='box error'>";
    echo "<h3>❌ Error</h3>";
    echo "<p>User admin tidak ditemukan di database!</p>";
    echo "<p>Silakan jalankan <code>install.php</code> terlebih dahulu.</p>";
    echo "</div>";
} else {
    $admin_user = mysqli_fetch_assoc($check_result);

    echo "<div class='box info'>";
    echo "<h3>👤 Admin User Ditemukan</h3>";
    echo "<ul>";
    echo "<li>ID: " . $admin_user['id'] . "</li>";
    echo "<li>Username: " . $admin_user['username'] . "</li>";
    echo "<li>Email: " . $admin_user['email'] . "</li>";
    echo "<li>Role: " . $admin_user['role'] . "</li>";
    echo "</ul>";
    echo "</div>";

    // Update password
    $update_query = "UPDATE users SET password = ? WHERE username = 'admin'";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, 's', $password_hash);

    if (mysqli_stmt_execute($stmt)) {
        echo "<div class='box success'>";
        echo "<h3>✅ Password Berhasil Direset!</h3>";
        echo "<p><strong>Kredensial Login:</strong></p>";
        echo "<ul>";
        echo "<li>Username: <code>admin</code></li>";
        echo "<li>Password: <code>admin123</code></li>";
        echo "</ul>";
        echo "<p><a href='pages/login.php' style='display: inline-block; padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 5px;'>🔐 Login Sekarang</a></p>";
        echo "</div>";

        // Verify the password works
        echo "<div class='box info'>";
        echo "<h3>🧪 Verifikasi Password</h3>";
        if (password_verify('admin123', $password_hash)) {
            echo "<p style='color: green;'>✅ Verifikasi berhasil! Password 'admin123' cocok dengan hash.</p>";
        } else {
            echo "<p style='color: red;'>❌ Verifikasi gagal! Ada masalah dengan hash password.</p>";
        }
        echo "</div>";
    } else {
        echo "<div class='box error'>";
        echo "<h3>❌ Gagal Update Password</h3>";
        echo "<p>Error: " . mysqli_error($conn) . "</p>";
        echo "</div>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);

echo "<hr>";
echo "<div class='box error'>";
echo "<h3>⚠️ PENTING - Keamanan</h3>";
echo "<p>Hapus file <code>reset_admin_password.php</code> setelah selesai untuk keamanan!</p>";
echo "<p>File ini bisa digunakan siapa saja untuk mereset password admin.</p>";
echo "</div>";

echo "<p style='text-align: center; margin-top: 30px;'>";
echo "<a href='index.php' style='display: inline-block; padding: 10px 20px; background: #2c3e50; color: white; text-decoration: none; border-radius: 5px;'>🏠 Ke Homepage</a>";
echo "</p>";

echo "</body></html>";
