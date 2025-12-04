# ⚠️ PENTING: Solusi Password Admin

## Masalah yang Anda Alami

Ketika menginstall Munif Store di tempat/komputer lain, **password admin selalu salah** meskipun sudah menggunakan `admin123`.

## Penyebab

Hash password bcrypt yang di-generate berbeda antar server karena:

- Perbedaan versi PHP
- Bcrypt menggunakan salt acak setiap kali hash dibuat
- Hash statis di `database.sql` tidak compatible dengan semua server

## ✅ SOLUSI TERBAIK (Pilih salah satu):

### 🚀 Cara 1: Gunakan Reset Tool (TERCEPAT)

1. Buka browser, akses:

   ```
   http://localhost/Munif/reset_admin_password.php
   ```

2. Password admin akan otomatis direset ke `admin123` dengan hash yang fresh

3. Login di `http://localhost/Munif/pages/login.php`

   - Username: `admin`
   - Password: `admin123`

4. **HAPUS file `reset_admin_password.php`** setelah selesai!

---

### 🔄 Cara 2: Install Ulang Database

1. Drop database `munif_store` di phpMyAdmin (optional)

2. Jalankan installer:

   ```
   http://localhost/Munif/install.php
   ```

3. **Installer sudah diperbaiki!** Sekarang otomatis:

   - Generate hash password yang fresh
   - Verifikasi password bekerja
   - Compatible dengan server manapun

4. Login dengan `admin` / `admin123`

---

## 📝 Apa yang Sudah Diperbaiki?

✅ **`install.php`** - Sekarang generate hash password fresh saat install, bukan pakai hash statis  
✅ **`reset_admin_password.php`** - Tool baru untuk reset password dengan 1 klik  
✅ **`database.sql`** - Password placeholder yang akan di-update oleh installer  
✅ **`README.md`** - Dokumentasi troubleshooting lengkap  
✅ **`SOLUSI_LOGIN.md`** - Panduan detail untuk masalah login

---

## 🎯 Quick Fix (3 Langkah)

```
1. http://localhost/Munif/reset_admin_password.php  (reset password)
2. http://localhost/Munif/pages/login.php           (login: admin/admin123)
3. Hapus file reset_admin_password.php              (keamanan)
```

---

## 📚 Dokumentasi Lengkap

Baca dokumentasi lengkap di:

- **`SOLUSI_LOGIN.md`** - Troubleshooting detail
- **`README.md`** - Panduan instalasi dan penggunaan

---

**Problem solved! 🎉**

Jika masih ada masalah, baca `SOLUSI_LOGIN.md` untuk troubleshooting advanced.
