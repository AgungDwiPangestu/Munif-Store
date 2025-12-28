<?php
// Database Configuration Template
// COPY file ini ke db.php dan sesuaikan dengan konfigurasi database Anda

define('DB_HOST', 'localhost');    // Host database
define('DB_USER', 'root');         // Username MySQL
define('DB_PASS', '');             // Password MySQL
define('DB_NAME', 'apguns_store'); // Nama database

// Create connection
$conn = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    $error = mysqli_connect_error();

    // Check if database doesn't exist
    if (strpos($error, 'Unknown database') !== false) {
        die("
        <div style='font-family: Arial; max-width: 600px; margin: 50px auto; padding: 30px; background: #fff3cd; border: 2px solid #ffc107; border-radius: 10px;'>
            <h2 style='color: #856404; margin-top: 0;'>⚠️ Database Belum Dibuat</h2>
            <p style='color: #856404; line-height: 1.6;'>
                Database '<strong>apguns_store</strong>' belum ada. Silakan jalankan installer terlebih dahulu.
            </p>
            <p style='margin-top: 20px;'>
                <a href='/ApGuns-Store/install.php' style='display: inline-block; padding: 12px 24px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;'>
                    🚀 Jalankan Installer
                </a>
            </p>
            <hr style='margin: 20px 0; border: none; border-top: 1px solid #ffc107;'>
            <p style='color: #666; font-size: 0.9em;'>
                <strong>Atau install manual:</strong><br>
                1. Buka phpMyAdmin: <code>http://localhost/phpmyadmin</code><br>
                2. Buat database: <code>apguns_store</code><br>
                3. Import file: <code>database.sql</code>
            </p>
        </div>
        ");
    }

    die("Koneksi database gagal: " . $error);
}

// Set charset
mysqli_set_charset($conn, "utf8mb4");

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
