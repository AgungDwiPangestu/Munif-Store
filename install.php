<?php
// Database Installation Script
// Jalankan file ini sekali untuk membuat database dan tabel

$host = 'localhost';
$user = 'root';
$pass = '';

// Connect tanpa database
$conn = mysqli_connect($host, $user, $pass);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

echo "<h2>🚀 Instalasi Database Munif Store</h2>";
echo "<hr>";

// Baca file SQL
$sql_file = __DIR__ . '/database.sql';
if (!file_exists($sql_file)) {
    die("<p style='color: red;'>❌ File database.sql tidak ditemukan!</p>");
}

$sql_content = file_get_contents($sql_file);

// Remove comments and split by semicolon
$sql_content = preg_replace('/^--.*$/m', '', $sql_content); // Remove single line comments
$sql_content = preg_replace('/\/\*.*?\*\//s', '', $sql_content); // Remove multi-line comments

// Split SQL statements
$statements = array_filter(
    array_map('trim', explode(';', $sql_content)),
    function ($stmt) {
        $stmt = trim($stmt);
        return !empty($stmt) && strlen($stmt) > 5;
    }
);

$success_count = 0;
$error_count = 0;
$database_created = false;

echo "<div style='font-family: monospace; background: #f5f5f5; padding: 20px; border-radius: 5px;'>";

foreach ($statements as $statement) {
    $statement = trim($statement);
    if (empty($statement)) continue;

    // Execute the statement
    $result = @mysqli_query($conn, $statement);

    if ($result) {
        $success_count++;

        // Show important operations
        if (stripos($statement, 'CREATE DATABASE') !== false) {
            echo "<p style='color: green;'>✅ Database 'munif_store' berhasil dibuat</p>";
            $database_created = true;
            // Select the database after creating it
            mysqli_select_db($conn, 'munif_store');
        } elseif (stripos($statement, 'USE ') !== false) {
            // Automatically select database
            if (!$database_created) {
                mysqli_select_db($conn, 'munif_store');
            }
            echo "<p style='color: green;'>✅ Database munif_store dipilih</p>";
        } elseif (stripos($statement, 'CREATE TABLE') !== false) {
            preg_match('/CREATE TABLE (?:IF NOT EXISTS )?`?(\w+)`?/i', $statement, $matches);
            $table_name = $matches[1] ?? 'unknown';
            echo "<p style='color: green;'>✅ Tabel '$table_name' berhasil dibuat</p>";
        } elseif (stripos($statement, 'INSERT INTO categories') !== false) {
            echo "<p style='color: green;'>✅ Data kategori berhasil ditambahkan</p>";
        } elseif (stripos($statement, 'INSERT INTO users') !== false) {
            echo "<p style='color: green;'>✅ User admin berhasil ditambahkan</p>";
        } elseif (stripos($statement, 'INSERT INTO books') !== false) {
            echo "<p style='color: green;'>✅ Data buku sample berhasil ditambahkan</p>";
        }
    } else {
        $error = mysqli_error($conn);
        // Skip common ignorable errors
        if (
            stripos($error, 'database exists') === false &&
            stripos($error, 'table') === false ||
            stripos($error, "doesn't exist") !== false
        ) {
            $error_count++;
            echo "<p style='color: orange;'>⚠️ Error pada query: " . htmlspecialchars(substr($statement, 0, 100)) . "...</p>";
            echo "<p style='color: orange; margin-left: 20px;'>" . htmlspecialchars($error) . "</p>";
        }
    }
}

echo "</div>";

echo "</div>";
echo "<hr>";

// Update admin password with fresh hash
if (!$database_created) {
    mysqli_select_db($conn, 'munif_store');
}

$fresh_password_hash = password_hash('admin123', PASSWORD_DEFAULT);
$update_admin = "UPDATE users SET password = '$fresh_password_hash' WHERE username = 'admin'";
if (mysqli_query($conn, $update_admin)) {
    echo "<p style='color: green;'>✅ Password admin berhasil di-generate ulang</p>";
} else {
    echo "<p style='color: orange;'>⚠️ Gagal update password admin: " . mysqli_error($conn) . "</p>";
}

echo "<hr>";
echo "<h3>📊 Ringkasan Instalasi:</h3>";
echo "<ul>";
echo "<li>✅ Query berhasil: <strong>$success_count</strong></li>";
echo "<li>❌ Query gagal: <strong>$error_count</strong></li>";
echo "</ul>";

mysqli_close($conn);

echo "<hr>";
echo "<h3>🎉 Instalasi Selesai!</h3>";
echo "<p><strong>Kredensial Admin:</strong></p>";
echo "<ul>";
echo "<li>Username: <code>admin</code></li>";
echo "<li>Password: <code>admin123</code></li>";
echo "</ul>";
echo "<p><a href='index.php' style='display: inline-block; padding: 10px 20px; background: #2c3e50; color: white; text-decoration: none; border-radius: 5px;'>🏠 Ke Homepage</a></p>";
echo "<p style='color: #666; font-size: 0.9em;'>Catatan: Anda bisa menghapus file install.php setelah instalasi selesai untuk keamanan.</p>";
