# Munif Store - Website E-Commerce Buku

Website toko buku online lengkap dengan fitur-fitur modern untuk menjual dan mengelola buku secara online.

## 🚀 Fitur Utama

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
Munif/
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

### Persyaratan:

- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Web server (Apache/Nginx) - Laragon sudah include ini
- Browser modern

### Langkah Instalasi:

1. **Clone atau copy project ke folder Laragon**

   ```
   Folder: c:\laragon\www\Munif
   ```

2. **Jalankan Installer Otomatis (RECOMMENDED)**

   - Buka browser dan akses: `http://localhost/Munif/install.php`
   - Installer akan otomatis:
     - Membuat database `munif_store`
     - Membuat semua tabel
     - Mengisi data sample (kategori, buku, admin)
   - Setelah selesai, klik tombol "Ke Homepage"

   **ATAU Install Manual:**

3. **Import Database Manual (Alternatif)**

   - Buka phpMyAdmin (http://localhost/phpmyadmin)
   - Buat database baru bernama `munif_store`
   - Import file `database.sql` yang ada di root project
   - Database akan otomatis terisi dengan:
     - Struktur tabel lengkap
     - Data kategori sample
     - Data buku sample
     - User admin (username: admin, password: admin123)

4. **Konfigurasi Database** (Sudah otomatis)

   - File `config/db.php` sudah dikonfigurasi untuk Laragon default:
     ```php
     DB_HOST: localhost
     DB_USER: root
     DB_PASS: (kosong)
     DB_NAME: munif_store
     ```
   - Jika perlu, sesuaikan dengan konfigurasi MySQL Anda

5. **Set Permissions (Opsional untuk Windows)**

   - Pastikan folder `assets/images/books/` memiliki permission write
   - Untuk upload gambar buku

6. **Akses Website**
   - Buka browser dan akses: `http://localhost/Munif`
   - Homepage akan muncul

## 👤 Login Credentials

### Admin:

- **Username:** admin
- **Password:** admin123

### Customer:

- Daftar melalui halaman register: `http://localhost/Munif/pages/register.php`

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

### Database Connection Error:

- Pastikan MySQL sudah running di Laragon
- Cek konfigurasi di `config/db.php`
- Pastikan database `munif_store` sudah dibuat dan di-import

### Gambar Tidak Muncul:

- Pastikan folder `assets/images/books/` ada
- Untuk testing, gunakan gambar default atau upload gambar baru

### Session Error:

- Pastikan session sudah di-start (sudah otomatis di `config/db.php`)
- Clear browser cache dan cookies

### Permission Denied (Upload):

- Di Windows biasanya tidak masalah
- Di Linux/Mac, set permission: `chmod 755 assets/images/books/`

## 📞 Support

Untuk pertanyaan atau bantuan, silakan hubungi:

- Email: admin@munifstore.com
- Website: http://localhost/Munif

## 📄 License

Project ini dibuat untuk keperluan pembelajaran dan development.

---

**Selamat Menggunakan Munif Store! 📚**
