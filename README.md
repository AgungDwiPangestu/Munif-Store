# 📚 ApGuns Store - Online Bookstore E-Commerce

> Modern online bookstore platform with complete e-commerce features and Google Books API integration

[![PHP](https://img.shields.io/badge/PHP-7.4%2B-blue.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange.svg)](https://mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

Sistem toko buku online lengkap yang dibangun dengan PHP native dan MySQL. Dilengkapi dengan panel admin, manajemen produk, sistem keranjang belanja, dan integrasi Google Books API untuk import buku otomatis.

---

## ✨ Fitur Utama

### Untuk Pelanggan:

- **Katalog Buku** - Jelajahi koleksi buku lengkap dengan filter kategori dan pencarian
- **Detail Buku** - Informasi lengkap tentang buku termasuk penulis, penerbit, ISBN, dll
- **Keranjang Belanja** - Tambah, update, dan hapus item dari keranjang
- **Checkout** - Proses pembelian yang mudah dan aman
- **Riwayat Pesanan** - Lacak status pesanan Anda
- **Autentikasi** - Sistem login dan registrasi yang aman

### Untuk Admin:

- **Dashboard** - Statistik dan overview toko
- **Kelola Buku** - Tambah, edit, dan hapus buku
- **Import Buku dari API** - Import buku otomatis dari Google Books API (NEW! 🎉)
- **Kelola Kategori** - Atur kategori buku
- **Kelola Pesanan** - Update status pesanan pelanggan
- **Kelola Pengguna** - Lihat daftar pengguna terdaftar

## 📁 Struktur Project

```
ApGuns-Store/
├── admin/                      # Panel Admin
│   ├── dashboard.php          # Dashboard admin
│   ├── manage_books.php       # Kelola buku
│   ├── add_book.php           # Tambah buku
│   ├── import_books.php       # Import buku dari API (NEW!)
│   ├── process_import_books.php # Proses import
│   ├── manage_categories.php  # Kelola kategori
│   ├── manage_orders.php      # Kelola pesanan
│   └── manage_users.php       # Kelola pengguna
├── api/                        # API Endpoints (NEW!)
│   └── search_books_api.php   # API pencarian buku
├── assets/
│   ├── css/
│   │   └── style.css          # Stylesheet utama
│   ├── js/
│   │   └── main.js            # JavaScript utama
│   └── images/
│       └── books/             # Folder untuk gambar buku
├── config/
│   ├── db.php                 # Konfigurasi database
│   └── functions.php          # Helper functions
├── includes/
│   ├── header.php             # Header HTML
│   ├── navbar.php             # Navigation bar
│   └── footer.php             # Footer
├── pages/                      # Halaman customer
│   ├── books.php              # Katalog buku
│   ├── book_detail.php        # Detail buku
│   ├── cart.php               # Keranjang belanja
│   ├── checkout.php           # Halaman checkout
│   ├── orders.php             # Riwayat pesanan
│   ├── order_detail.php       # Detail pesanan
│   ├── login.php              # Halaman login
│   ├── register.php           # Halaman registrasi
│   ├── logout.php             # Proses logout
│   ├── add_to_cart.php        # API tambah ke keranjang
│   ├── update_cart.php        # API update keranjang
│   ├── remove_from_cart.php   # API hapus dari keranjang
│   └── get_cart_count.php     # API hitung item keranjang
├── database.sql               # SQL schema dan data sample
├── index.php                  # Homepage
├── README.md                  # File ini
└── API_IMPORT_GUIDE.md        # Dokumentasi API Import (NEW!)
```

## 🛠️ Instalasi

### Persyaratan Sistem:

- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Web server (Apache/Nginx)
- Git (untuk clone repository)
- Browser modern

### Langkah Instalasi:

#### **1. Clone Repository**

```bash
git clone https://github.com/YOUR_USERNAME/ApGuns-Store.git
cd ApGuns-Store
```

#### **2. Setup Database Configuration**

Copy file konfigurasi database:

```bash
# Linux/Mac
cp config/db.example.php config/db.php

# Windows (PowerShell)
Copy-Item config/db.example.php config/db.php

# Windows (CMD)
copy config\db.example.php config\db.php
```

Kemudian edit `config/db.php` sesuai konfigurasi database Anda:

```php
define('DB_HOST', 'localhost');    // Host database
define('DB_USER', 'root');         // Username MySQL
define('DB_PASS', '');             // Password MySQL
define('DB_NAME', 'apguns_store'); // Nama database
```

#### **3. Pindahkan ke Web Server Directory**

**Untuk Laragon (Windows):**

```bash
# Pindahkan folder ke:
C:\laragon\www\ApGuns-Store
```

````

**Untuk XAMPP (Windows):**

```bash
# Pindahkan folder ke:
C:\xampp\htdocs\ApGuns-Store
````

**Untuk XAMPP/LAMPP (Linux/Mac):**

```bash
# Pindahkan folder ke:
/opt/lampp/htdocs/ApGuns-Store
```

#### **4. Jalankan Web Server**

**Laragon:**

- Klik tombol "Start All" di Laragon
- Pastikan Apache dan MySQL aktif (hijau)

**XAMPP:**

- Buka XAMPP Control Panel
- Klik "Start" pada Apache
- Klik "Start" pada MySQL

#### **4. Jalankan Installer Otomatis** ⚡

Buka browser dan akses URL berikut:

```
http://localhost/ApGuns-Store/install.php
```

Installer akan **otomatis**:

- ✅ Membuat database `apguns_store`
- ✅ Membuat semua tabel yang diperlukan
- ✅ Mengisi data sample (kategori, buku)
- ✅ Membuat user admin default

**Tunggu sampai proses selesai**, lalu klik tombol **"Ke Homepage"**

#### **5. Selesai!** 🎉

Website sudah siap digunakan. Akses:

```
http://localhost/ApGuns-Store
```

> **💡 Catatan:**
>
> - Tidak perlu import database manual
> - Tidak perlu konfigurasi apapun
> - Semua sudah otomatis dengan `install.php`
> - Jika menggunakan port custom, sesuaikan URL (misal: `http://localhost:8080/ApGuns-Store`)

### Konfigurasi Manual (Opsional)

Jika konfigurasi database Anda berbeda dari default, edit file `config/db.php`:

```php
define('DB_HOST', 'localhost');    // Host database
define('DB_USER', 'root');         // Username MySQL
define('DB_PASS', '');             // Password MySQL (kosong untuk default)
define('DB_NAME', 'apguns_store');  // Nama database
```

## 👤 Login Credentials

### Admin:

- **Username:** admin
- **Password:** admin123

### Customer:

- Daftar melalui halaman register: `http://localhost/ApGuns-Store/pages/register.php`

## 📝 Cara Penggunaan

### Untuk Customer:

1. **Mendaftar/Login**

   - Klik tombol "Daftar" di navbar
   - Isi form registrasi
   - Login dengan akun yang sudah dibuat

2. **Mencari & Membeli Buku**

   - Browse katalog buku di menu "Katalog"
   - Gunakan filter kategori atau search bar
   - Klik "Detail" untuk melihat informasi lengkap
   - Klik "Tambah ke Keranjang" untuk membeli
   - Klik icon keranjang di navbar untuk melihat keranjang
   - Klik "Checkout" untuk menyelesaikan pembelian

3. **Melihat Pesanan**
   - Klik nama user di navbar → "Pesanan Saya"
   - Lihat status dan detail pesanan

### Untuk Admin:

1. **Login sebagai Admin**

   - Login dengan kredensial admin
   - Otomatis redirect ke Admin Panel

2. **Mengelola Buku**

   - Klik "Kelola Buku" di dashboard
   - Tambah buku baru dengan klik tombol "Tambah Buku"
   - **ATAU** klik "Import Buku dari API" untuk import otomatis:
     - Cari buku dari Google Books API
     - Preview hasil pencarian
     - Pilih buku yang ingin diimport
     - Cover image otomatis terdownload
   - Edit atau hapus buku yang sudah ada

3. **Mengelola Pesanan**

   - Klik "Kelola Pesanan"
   - Update status pesanan (Pending → Processing → Shipped → Delivered)
   - Lihat detail pesanan customer

4. **Mengelola Kategori**
   - Tambah kategori baru untuk klasifikasi buku
   - Edit atau hapus kategori yang ada

## 🎨 Fitur Tambahan

- **Responsive Design** - Website dapat diakses dari mobile
- **Flash Messages** - Notifikasi sukses/error untuk setiap aksi
- **Image Upload** - Admin dapat upload gambar cover buku
- **Import Buku dari API** - Import katalog buku otomatis dari Google Books API 🆕
  - Cari buku berdasarkan kata kunci
  - Download cover image otomatis
  - Preview sebelum import
  - Deteksi duplikat
  - [Lihat dokumentasi lengkap](API_IMPORT_GUIDE.md)
- **Stock Management** - Otomatis update stok saat ada pembelian
- **Transaction System** - Menggunakan transaction untuk keamanan data
- **Password Hashing** - Password di-hash dengan bcrypt
- **Input Sanitization** - Proteksi dari SQL injection dan XSS

## 🔧 Troubleshooting

### ⚠️ Password Admin Salah Setelah Install di Tempat Lain

**Masalah:** Setelah clone dan install di server/komputer lain, login admin gagal dengan password `admin123`

**Penyebab:** Hash password yang di-generate berbeda antar server karena perbedaan versi PHP atau konfigurasi bcrypt

**Solusi (Pilih salah satu):**

#### **Cara 1: Jalankan Reset Password Tool** ⭐ (Termudah)

1. Akses URL berikut di browser:
   ```
   http://localhost/ApGuns-Store/reset_admin_password.php
   ```
2. Password admin akan otomatis di-reset ke `admin123`
3. Login kembali dengan username `admin` dan password `admin123`
4. **PENTING:** Hapus file `reset_admin_password.php` setelah selesai untuk keamanan!

#### **Cara 2: Install Ulang Database**

1. Drop database lama (opsional):
   ```sql
   DROP DATABASE IF EXISTS apguns_store;
   ```
2. Jalankan installer lagi:
   ```
   http://localhost/ApGuns-Store/install.php
   ```
3. Installer otomatis membuat hash password yang fresh dan compatible dengan server Anda

#### **Cara 3: Update Manual via SQL**

1. Buka phpMyAdmin atau MySQL console
2. Jalankan query berikut:
   ```sql
   USE apguns_store;
   -- Generate hash baru untuk password 'admin123'
   UPDATE users
   SET password = '$2y$10$YourNewHashHere'
   WHERE username = 'admin';
   ```
3. Untuk mendapatkan hash baru, gunakan tool `reset_admin_password.php` atau generate di PHP:
   ```php
   <?php echo password_hash('admin123', PASSWORD_DEFAULT); ?>
   ```

**Catatan:** Masalah ini terjadi karena bcrypt menggunakan salt yang berbeda setiap kali hash di-generate, dan installer sekarang otomatis membuat hash fresh saat instalasi.

### Database Connection Error:

- Pastikan MySQL sudah running di Laragon/XAMPP
- Cek konfigurasi di `config/db.php`
- Pastikan database `apguns_store` sudah dibuat (jalankan `install.php`)

### Gambar Tidak Muncul:

- Pastikan folder `assets/images/books/` ada
- Untuk testing, gunakan gambar default atau upload gambar baru

### Session Error:

- Pastikan session sudah di-start (sudah otomatis di `config/db.php`)
- Clear browser cache dan cookies

### Permission Denied (Upload):

- Di Windows biasanya tidak masalah
- Di Linux/Mac, set permission: `chmod 755 assets/images/books/`

### Import Buku dari API Gagal:

- Cek koneksi internet
- Pastikan API Google Books tidak terblokir
- Lihat error di console browser (F12)

## 🤝 Contributing

Contributions are welcome! Untuk berkontribusi:

1. Fork repository ini
2. Buat branch fitur baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan Anda (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📄 License

Project ini menggunakan MIT License - lihat file [LICENSE](LICENSE) untuk detail.

## 👨‍💻 Author

**Your Name**

- GitHub: [@YOUR_USERNAME](https://github.com/YOUR_USERNAME)
- Email: your.email@example.com

## 🙏 Acknowledgments

- Google Books API untuk data buku
- Font Awesome untuk icons
- Komunitas PHP & MySQL

## 📸 Screenshots

### Homepage

![Homepage](screenshots/homepage.png)

### Admin Dashboard

![Admin Dashboard](screenshots/admin-dashboard.png)

### Book Catalog

![Book Catalog](screenshots/catalog.png)

---

⭐ Jika project ini bermanfaat, jangan lupa berikan star!

**Made with ❤️ for the book lovers community**
