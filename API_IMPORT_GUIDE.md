# 📚 API Import Buku - ApGuns Store

Dokumentasi lengkap untuk fitur import buku otomatis dari Google Books API.

## 🌟 Fitur Utama

- ✅ Import buku dari **Google Books API**
- ✅ Import buku dari **Open Library API**
- ✅ Download gambar cover otomatis
- ✅ Pencarian berdasarkan kata kunci
- ✅ Preview sebelum import
- ✅ Pilih buku yang ingin diimport
- ✅ Deteksi duplikat otomatis
- ✅ Harga otomatis berdasarkan jumlah halaman

## 📁 File yang Ditambahkan

```
ApGuns-Store/
├── admin/
│   ├── import_books.php           # Halaman import buku (UI)
│   └── process_import_books.php   # Proses import ke database
└── api/
    └── search_books_api.php        # API endpoint untuk pencarian
```

## 🚀 Cara Menggunakan

### Melalui Admin Panel (Recommended)

1. **Login sebagai Admin**

   - Username: `admin`
   - Password: `admin123`

2. **Akses Halaman Import**

   - Dari dashboard admin, klik tombol **"Import Buku dari API"**
   - Atau akses langsung: `http://localhost/ApGuns-Store/admin/import_books.php`

3. **Cari Buku**

   - Masukkan kata kunci (contoh: "programming", "novel indonesia", "business")
   - Pilih kategori default untuk buku yang akan diimport
   - Pilih jumlah buku (10, 20, 30, atau 40)
   - Klik **"Cari Buku"**

4. **Preview & Pilih Buku**

   - Sistem akan menampilkan hasil pencarian dari Google Books
   - Setiap buku menampilkan:
     - Cover image (jika tersedia)
     - Judul & Penulis
     - Penerbit & Tahun terbit
     - Jumlah halaman
     - Harga otomatis (dihitung dari jumlah halaman)
     - Stok awal (default: 10)
   - Centang buku yang ingin diimport
   - Klik **"Import Buku Terpilih"**

5. **Import ke Database**
   - Sistem akan:
     - Download cover image dari Google Books
     - Menyimpan gambar ke `assets/images/books/`
     - Insert data buku ke database
     - Mengecek duplikat (ISBN & judul)
   - Menampilkan hasil import (berapa buku berhasil/gagal)

### Melalui API Langsung

#### Endpoint: Search Books

**URL:** `http://localhost/ApGuns-Store/api/search_books_api.php`

**Method:** GET

**Parameters:**

| Parameter  | Type    | Required | Default | Description                       |
| ---------- | ------- | -------- | ------- | --------------------------------- |
| query      | string  | Yes      | -       | Kata kunci pencarian              |
| source     | string  | No       | google  | Sumber API (google / openlibrary) |
| maxResults | integer | No       | 20      | Jumlah maksimal hasil             |

**Contoh Request:**

```bash
# Cari buku tentang programming
http://localhost/ApGuns-Store/api/search_books_api.php?query=programming&maxResults=20

# Cari dari Open Library
http://localhost/ApGuns-Store/api/search_books_api.php?query=novel&source=openlibrary&maxResults=10

# Cari buku bisnis
http://localhost/ApGuns-Store/api/search_books_api.php?query=business&maxResults=30
```

**Response Format:**

```json
{
  "success": true,
  "source": "Google Books",
  "count": 20,
  "books": [
    {
      "title": "Clean Code",
      "authors": ["Robert C. Martin"],
      "publisher": "Prentice Hall",
      "publishedDate": "2008",
      "description": "Even bad code can function...",
      "isbn": "9780132350884",
      "pageCount": 464,
      "categories": ["Computers"],
      "thumbnail": "http://books.google.com/books/content?id=...",
      "previewLink": "http://books.google.com/books?id=...",
      "language": "en"
    }
  ]
}
```

## 💡 Tips Pencarian

### Kata Kunci yang Bagus:

✅ **Bahasa Inggris** - Lebih banyak hasil

- "programming"
- "python tutorial"
- "business strategy"
- "machine learning"
- "web development"

✅ **Spesifik** - Hasil lebih relevan

- "javascript for beginners"
- "data science python"
- "investment banking"

✅ **Genre**

- "science fiction"
- "romance novel"
- "history books"

### Mapping Kategori:

Sesuaikan dengan kategori di database Anda:

| Kata Kunci API      | Kategori Database |
| ------------------- | ----------------- |
| programming, coding | Teknologi         |
| business, finance   | Bisnis            |
| novel, fiction      | Fiksi             |
| education, tutorial | Pendidikan        |
| science, research   | Non-Fiksi         |

## 🔧 Konfigurasi Harga

Sistem menghitung harga otomatis berdasarkan jumlah halaman:

```javascript
// Formula harga di import_books.php
const basePrice = 50000 + pageCount * 100;
const price = Math.round(basePrice / 1000) * 1000; // Bulatkan ke ribuan
```

**Contoh:**

- 100 halaman = Rp 60.000
- 300 halaman = Rp 80.000
- 500 halaman = Rp 100.000

**Ubah Formula:**
Edit file `admin/import_books.php` di bagian `displayBooks()` function.

## 🛡️ Fitur Keamanan

1. **Deteksi Duplikat**

   - Cek berdasarkan ISBN
   - Cek berdasarkan judul
   - Tidak akan import buku yang sudah ada

2. **Validasi Admin**

   - Hanya admin yang bisa akses
   - Session check di setiap halaman

3. **Input Sanitization**

   - Semua input di-escape sebelum masuk database
   - Menggunakan `mysqli_real_escape_string()`

4. **Error Handling**
   - Try-catch untuk download gambar
   - Fallback jika API gagal
   - Log error untuk debugging

## 📊 Statistik Import

Setelah import, sistem menampilkan:

```
✅ Berhasil import 15 buku! (5 gagal/duplikat)
```

**Keterangan:**

- **Berhasil**: Buku baru yang masuk database
- **Gagal/Duplikat**: Buku yang sudah ada atau error

## 🔍 Troubleshooting

### Error: "Gagal mengakses Google Books API"

**Solusi:**

- Pastikan koneksi internet aktif
- Cek firewall tidak memblokir akses ke googleapis.com
- Coba ganti ke Open Library: `?source=openlibrary`

### Gambar Tidak Terdownload

**Solusi:**

- Pastikan folder `assets/images/books/` memiliki permission write
- Cek PHP `allow_url_fopen` di php.ini (harus ON)
- Gambar akan menggunakan default.jpg jika gagal download

### Import Gagal Semua

**Solusi:**

- Cek database connection di `config/db.php`
- Pastikan tabel `books` sudah ada
- Cek error di flash message

### Buku Tidak Muncul di Hasil

**Solusi:**

- Gunakan kata kunci bahasa Inggris
- Coba kata kunci yang lebih spesifik
- Tambahkan jumlah maxResults
- Coba API lain (Open Library)

## 🎨 Customisasi

### Ubah Stok Default

Edit `admin/import_books.php`:

```javascript
stock: 10; // Ubah angka ini
```

### Ubah Sumber API Default

Edit `admin/import_books.php`:

```javascript
const apiUrl = `https://www.googleapis.com/books/v1/volumes...`;
// Ganti dengan API lain
```

### Tambah Field Custom

1. Edit `process_import_books.php`
2. Tambah field di INSERT query
3. Update form di `import_books.php`

## 📝 API Alternatif

Sistem mendukung 2 API:

### 1. Google Books API

- **URL**: `https://www.googleapis.com/books/v1/volumes`
- **Kelebihan**:
  - Database besar
  - Cover image berkualitas tinggi
  - Informasi lengkap
- **Limit**: 1000 request/hari (gratis)

### 2. Open Library API

- **URL**: `https://openlibrary.org/search.json`
- **Kelebihan**:
  - Unlimited requests
  - Open source
  - Data lengkap
- **Kekurangan**:
  - Cover image terbatas

## 🚀 Pengembangan Lanjutan

### Ide Fitur Tambahan:

1. **Bulk Import**

   - Import seluruh kategori sekaligus
   - Import dari file CSV

2. **Scheduled Import**

   - Auto-import buku baru setiap minggu
   - Cron job integration

3. **Smart Pricing**

   - Harga berdasarkan kategori
   - Harga berdasarkan popularitas

4. **Review Integration**

   - Import review dari API
   - Rating otomatis

5. **Multi-Language**
   - Filter bahasa buku
   - Support buku Indonesia

## 📞 Support

Jika ada masalah:

- Cek console browser (F12) untuk error JavaScript
- Cek log PHP di Laragon
- Periksa database query di phpMyAdmin

## 📄 License

Fitur ini adalah bagian dari ApGuns Store dan menggunakan license yang sama.

---

**Happy Importing! 📚✨**

_Dibuat untuk ApGuns Store - December 2025_
