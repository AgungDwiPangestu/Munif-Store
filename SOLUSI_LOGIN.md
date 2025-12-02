# 🔐 Solusi Login Admin - Munif Store

## Masalah: Password Admin Salah

Ada beberapa kemungkinan dan solusinya:

---

## ✅ Solusi 1: Reset Password Admin (RECOMMENDED)

Saya sudah membuat tool untuk reset password admin.

### Langkah-langkah:

1. **Buka browser** dan akses:

   ```
   http://localhost/Munif/reset_admin_password.php
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
2. Cek apakah database **`munif_store`** ada
3. Jika tidak ada, jalankan installer:
   ```
   http://localhost/Munif/install.php
   ```

### Jika database sudah ada, cek tabel users:

1. Buka database **`munif_store`**
2. Klik tabel **`users`**
3. Pastikan ada user dengan:
   - **username:** `admin`
   - **role:** `admin`

---

## ✅ Solusi 3: Install Ulang Database

Jika masih error, install ulang database:

1. **Backup data** (jika ada data penting)
2. **Drop database** `munif_store` di phpMyAdmin
3. **Jalankan installer:**
   ```
   http://localhost/Munif/install.php
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
2. Pilih database **`munif_store`**
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
Email:    admin@munifstore.com
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
2. Cek di phpMyAdmin apakah database `munif_store` ada
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
   http://localhost/Munif/reset_admin_password.php
   ```

2. **Login:**

   ```
   http://localhost/Munif/pages/login.php
   ```

   - Username: `admin`
   - Password: `admin123`

3. **Hapus file reset:**
   ```
   Hapus file: c:\laragon\www\Munif\reset_admin_password.php
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
