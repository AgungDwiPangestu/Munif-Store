# 🔐 Solusi Login Admin - ApGuns Store

## ⚠️ Masalah: Password Admin Selalu Salah Saat Install di Tempat Lain

**Gejala:** Setelah clone repository dan install di komputer/server lain, login admin dengan password `admin123` selalu gagal.

**Penyebab:** Hash password bcrypt yang di-generate berbeda antar server karena:

- Perbedaan versi PHP
- Perbedaan konfigurasi bcrypt
- Hash di `database.sql` adalah hash statis yang mungkin tidak kompatibel

**Solusi:** Installer sekarang otomatis membuat hash password yang fresh dan compatible dengan server Anda!

---

## ✅ Solusi 1: Reset Password Admin (TERCEPAT) ⭐

Tool otomatis untuk reset password tanpa ribet!

### Langkah-langkah:

1. **Buka browser** dan akses:

   ```
   http://localhost/ApGuns-Store/reset_admin_password.php
   ```

2. **Password akan otomatis direset** dengan hash yang fresh dan compatible!

   ```
   Username: admin
   Password: admin123
   ```

3. **Verifikasi otomatis** akan dilakukan untuk memastikan password bekerja

4. **Login** di: `http://localhost/ApGuns-Store/pages/login.php`

5. **PENTING:** Hapus file `reset_admin_password.php` setelah selesai untuk keamanan!

**Mengapa cara ini berhasil?**  
Tool ini membuat hash password yang **fresh** menggunakan PHP di server Anda saat ini, sehingga dijamin compatible.

---

## ✅ Solusi 2: Install Ulang (RECOMMENDED untuk Fresh Install)

Installer sudah diperbaiki untuk mengatasi masalah ini!

### Langkah-langkah:

1. **Drop database lama** (di phpMyAdmin):

   ```sql
   DROP DATABASE IF EXISTS apguns_store;
   ```

2. **Jalankan installer** yang sudah diperbaiki:

   ```
   http://localhost/ApGuns-Store/install.php
   ```

3. **Installer baru otomatis:**

   - ✅ Membuat database
   - ✅ Import struktur tabel
   - ✅ **Generate hash password yang fresh** (PERBAIKAN BARU!)
   - ✅ Verifikasi password berfungsi

4. **Login** dengan:
   ```
   Username: admin
   Password: admin123
   ```

**Perbedaan dengan installer lama:**  
Installer baru tidak menggunakan hash statis dari `database.sql`, tapi membuat hash baru setiap install!

---

## ✅ Solusi 3: Update Manual via SQL (Advanced)

Untuk yang familiar dengan database:

1. **Generate hash baru** menggunakan PHP:

   ```php
   <?php
   // Buat file test.php di folder ApGuns-Store
   echo password_hash('admin123', PASSWORD_DEFAULT);
   ?>
   ```

2. **Akses** `http://localhost/ApGuns-Store/test.php` dan copy hash yang muncul

3. **Buka phpMyAdmin**, pilih database `apguns_store`

4. **Jalankan query:**

   ```sql
   UPDATE users
   SET password = 'PASTE_HASH_DARI_STEP_2_DISINI'
   WHERE username = 'admin';
   ```

5. **Hapus file `test.php`** untuk keamanan

---

## 🔍 Troubleshooting

### Password tetap salah setelah reset?

**Solusi:**

1. **Clear browser cache & cookies**
2. **Gunakan mode Incognito/Private**
3. **Coba browser lain**
4. **Restart Laragon/XAMPP**
5. **Pastikan tidak ada typo:**
   - Username: `admin` (huruf kecil semua)
   - Password: `admin123` (tanpa spasi)

### Error "Database tidak ditemukan"?

**Solusi:**

1. Pastikan **MySQL running** di Laragon/XAMPP
2. Cek di phpMyAdmin apakah database `apguns_store` ada
3. Jika tidak ada, jalankan `install.php`

### Hash password tidak berubah?

**Solusi:**

1. Pastikan query SQL di-execute dengan benar
2. Refresh tabel di phpMyAdmin (F5)
3. Cek field `password` apakah sudah berubah
4. Jika belum, coba Solusi 1 (reset tool)

---

## 📋 Kredensial Admin Default

Setelah instalasi fresh atau reset:

```
Username: admin
Password: admin123
Email:    admin@apgunsstore.com
Role:     admin
```

**CATATAN PENTING:** Password ini hanya untuk testing! Ubah segera setelah login pertama kali.

---

## 🚀 Quick Fix (Solusi Tercepat)

**3 langkah cepat:**

1. **Reset password:**

   ```
   http://localhost/ApGuns-Store/reset_admin_password.php
   ```

2. **Login:**

   ```
   http://localhost/ApGuns-Store/pages/login.php
   ```

   Username: `admin` | Password: `admin123`

3. **Cleanup (PENTING):**
   - Hapus `reset_admin_password.php`
   - Ubah password di Profile setelah login

---

## 🔐 Penjelasan Teknis (Untuk Developer)

### Mengapa masalah ini terjadi?

1. **Hash Bcrypt Dinamis:**

   - Setiap `password_hash()` menghasilkan hash berbeda (karena salt acak)
   - Hash di `database.sql` di-generate di komputer developer
   - Saat di-install di komputer lain, PHP versi berbeda mungkin punya algoritma sedikit berbeda

2. **Solusi di Installer Baru:**
   ```php
   // Old: Static hash from SQL file
   // INSERT INTO users ... VALUES (..., '$2y$10$...', ...)
   // New: Dynamic hash generated during install
   $fresh_hash = password_hash('admin123', PASSWORD_DEFAULT);
   UPDATE users SET password = '$fresh_hash' WHERE username = 'admin';
   ```

### File yang diperbaiki:

- ✅ `install.php` - Generate hash fresh saat install
- ✅ `database.sql` - Placeholder password untuk kompatibilitas
- ✅ `reset_admin_password.php` - Tool reset dengan verifikasi
- ✅ `README.md` - Dokumentasi troubleshooting

---

## ✨ Tips Keamanan

Setelah berhasil login:

1. **Ubah password default** melalui halaman Profile
2. **Hapus file development:**
   - `reset_admin_password.php`
   - `install.php` (setelah instalasi selesai)
   - File test/debug apapun
3. **Backup database** secara berkala
4. **Gunakan password kuat** (min. 12 karakter, kombinasi huruf/angka/simbol)

---

## 📞 Masih Bermasalah?

Jika masih tidak bisa login setelah semua solusi di atas:

1. **Cek versi PHP:**
   ```php
   <?php phpinfo(); ?>
   ```
   Pastikan PHP >= 7.4
2. **Cek ekstensi bcrypt** enabled di php.ini
3. **Cek error log** di Laragon: `C:\laragon\bin\apache\logs\error.log`
4. **Screenshot** halaman error dan console browser (F12)

---

**Problem solved! 🎉**

### Langkah-langkah:

1. **Buka browser** dan akses:

   ```
   http://localhost/ApGuns-Store/reset_admin_password.php
   ```

2. **Password akan otomatis direset** ke:

   ```
   Username: admin
   Password: admin123
   ```

3. **Login** dengan kredensial di atas

4. **PENTING:** Hapus file `reset_admin_password.php` setelah selesai untuk keamanan

---

## ✅ Solusi 2: Cek Database

Kemungkinan database belum diinstall dengan benar.

### Cek apakah database sudah ada:

1. Buka **phpMyAdmin**: `http://localhost/phpmyadmin`
2. Cek apakah database **`apguns_store`** ada
3. Jika tidak ada, jalankan installer:
   ```
   http://localhost/ApGuns-Store/install.php
   ```

### Jika database sudah ada, cek tabel users:

1. Buka database **`apguns_store`**
2. Klik tabel **`users`**
3. Pastikan ada user dengan:
   - **username:** `admin`
   - **role:** `admin`

---

## ✅ Solusi 3: Install Ulang Database

Jika masih error, install ulang database:

1. **Backup data** (jika ada data penting)
2. **Drop database** `apguns_store` di phpMyAdmin
3. **Jalankan installer:**
   ```
   http://localhost/ApGuns-Store/install.php
   ```
4. **Login** dengan:
   ```
   Username: admin
   Password: admin123
   ```

---

## ✅ Solusi 4: Manual Reset via phpMyAdmin

Jika cara di atas tidak berhasil:

1. Buka **phpMyAdmin**
2. Pilih database **`apguns_store`**
3. Klik tabel **`users`**
4. **Edit** baris user admin (klik icon pensil)
5. **Ubah field `password`** dengan value ini:
   ```
   $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
   ```
   (Ini adalah hash dari password `admin123`)
6. Klik **Go** untuk save
7. **Login** dengan `admin` / `admin123`

---

## 📋 Kredensial Admin Default

Setelah instalasi fresh atau reset:

```
Username: admin
Password: admin123
Email:    admin@apgunsstore.com
Role:     admin
```

---

## 🔍 Troubleshooting

### Password tetap salah setelah reset?

**Kemungkinan penyebab:**

- Browser menyimpan password lama (autocomplete)
- Session masih tersimpan

**Solusi:**

1. **Clear browser cache & cookies**
2. **Gunakan mode Incognito/Private**
3. **Coba browser lain**
4. **Restart Laragon**

### Error "Database tidak ditemukan"?

**Solusi:**

1. Pastikan **MySQL running** di Laragon
2. Cek di phpMyAdmin apakah database `apguns_store` ada
3. Jika tidak ada, jalankan `install.php`

### Error saat login?

**Cek:**

1. Apakah **username** ditulis benar: `admin` (huruf kecil semua)
2. Apakah **password** ditulis benar: `admin123` (tanpa spasi)
3. Apakah **session** sudah dimulai? (sudah otomatis di `config/db.php`)

---

## 🚀 Quick Fix (Paling Cepat)

**Jalankan perintah ini:**

1. **Reset password:**

   ```
   http://localhost/ApGuns-Store/reset_admin_password.php
   ```

2. **Login:**

   ```
   http://localhost/ApGuns-Store/pages/login.php
   ```

   - Username: `admin`
   - Password: `admin123`

3. **Hapus file reset:**
   ```
   Hapus file: c:\laragon\www\ApGuns-Store\reset_admin_password.php
   ```

---

## ✨ Tips Keamanan

Setelah berhasil login:

1. **Ubah password default** melalui halaman Profile
2. **Hapus file `reset_admin_password.php`**
3. **Hapus file `install.php`** (setelah instalasi selesai)

---

## 📞 Masih Bermasalah?

Jika masih tidak bisa login setelah mengikuti semua langkah di atas:

1. **Screenshot** halaman error
2. **Cek** browser console (F12) untuk error JavaScript
3. **Cek** PHP error log di Laragon

---

**Selamat mencoba! 🔐**
