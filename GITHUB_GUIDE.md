# 🚀 Quick Start Guide - Push ke GitHub

## ✅ Checklist Sebelum Push

### 1. Update Informasi Personal

**README.md:**

- [ ] Ganti `YOUR_USERNAME` dengan username GitHub Anda (ada di beberapa tempat)
- [ ] Ganti `your.email@example.com` dengan email Anda
- [ ] Update section "Author" dengan nama dan info Anda

**LICENSE:**

- [ ] Ganti `[Your Name]` dengan nama lengkap Anda

### 2. Buat Repository di GitHub

1. Login ke GitHub
2. Klik tombol "+" di kanan atas → "New repository"
3. Nama repository: `ApGuns-Store` (atau nama lain yang Anda inginkan)
4. Deskripsi: "Modern online bookstore platform with Google Books API integration"
5. Pilih **Public** atau **Private**
6. **JANGAN** centang "Add a README" (kita sudah punya)
7. **JANGAN** centang "Add .gitignore" (kita sudah punya)
8. Klik "Create repository"

### 3. Push ke GitHub

Buka terminal di folder project dan jalankan:

```bash
# Inisialisasi git (jika belum)
git init

# Tambahkan semua file
git add .

# Commit pertama
git commit -m "Initial commit: ApGuns Store - Online Bookstore"

# Rename branch ke main
git branch -M main

# Tambahkan remote (ganti YOUR_USERNAME dengan username Anda)
git remote add origin https://github.com/YOUR_USERNAME/ApGuns-Store.git

# Push ke GitHub
git push -u origin main
```

### 4. Verifikasi

Setelah push berhasil, cek di GitHub:

- [ ] File `config/db.php` **TIDAK ADA** (✓ bagus!)
- [ ] File `reset_admin_password.php` **TIDAK ADA** (✓ bagus!)
- [ ] File `config/db.example.php` **ADA** (✓ bagus!)
- [ ] README.md tampil dengan baik
- [ ] LICENSE ada
- [ ] Screenshot folder ada (kosong tidak masalah)

## 📸 Tips: Menambahkan Screenshots (Optional)

1. Jalankan aplikasi di localhost
2. Buka di browser dan ambil screenshot:

   - Homepage
   - Admin Dashboard
   - Katalog Buku
   - Keranjang Belanja
   - Checkout

3. Simpan screenshots dengan nama:

   - `screenshots/homepage.png`
   - `screenshots/admin-dashboard.png`
   - `screenshots/catalog.png`
   - `screenshots/cart.png`
   - `screenshots/checkout.png`

4. Push screenshots:

```bash
git add screenshots/
git commit -m "Add project screenshots"
git push
```

## 🎨 Membuat Repository Lebih Menarik

### Tambahkan Topics di GitHub

Di halaman repository, klik "Add topics":

- `php`
- `mysql`
- `ecommerce`
- `bookstore`
- `online-store`
- `google-books-api`
- `shopping-cart`

### Pin Repository

Jika ini project penting, pin di profile Anda:

1. Klik "Customize your pins" di profile
2. Pilih repository ini
3. Klik "Save pins"

## 🔄 Update Repository di Masa Depan

Setelah membuat perubahan:

```bash
# Cek status
git status

# Tambahkan perubahan
git add .

# Commit dengan pesan yang jelas
git commit -m "Deskripsi perubahan"

# Push ke GitHub
git push
```

## ⚠️ PENTING - Keamanan

**File yang TIDAK BOLEH di-push:**

- ❌ `config/db.php` - Berisi password database
- ❌ `reset_admin_password.php` - Tool security
- ❌ File backup (\*.backup.php)
- ❌ File upload user (`assets/images/books/*` kecuali default)

**Semua sudah dikonfigurasi di .gitignore, jadi aman!**

## 🆘 Troubleshooting

### "Permission denied (publickey)"

```bash
# Gunakan HTTPS instead of SSH
git remote set-url origin https://github.com/YOUR_USERNAME/ApGuns-Store.git
```

### "Repository not found"

- Pastikan nama repository benar
- Pastikan Anda punya akses ke repository
- Cek URL: `git remote -v`

### "Already exists" error

```bash
# Hapus remote dan tambah ulang
git remote remove origin
git remote add origin https://github.com/YOUR_USERNAME/ApGuns-Store.git
git push -u origin main
```

## 📚 Resources

- [GitHub Documentation](https://docs.github.com)
- [Git Cheat Sheet](https://education.github.com/git-cheat-sheet-education.pdf)
- [Markdown Guide](https://www.markdownguide.org)

---

**Good luck with your GitHub repository! 🎉**
