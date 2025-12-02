<?php
require_once '../config/db.php';
require_once '../config/functions.php';

$page_title = 'Kelola Buku';

// Check if user is admin
if (!is_logged_in() || !is_admin()) {
    set_flash('Akses ditolak!', 'error');
    redirect('/Munif/pages/login.php');
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $delete_query = "DELETE FROM books WHERE id = $id";
    if (mysqli_query($conn, $delete_query)) {
        set_flash('Buku berhasil dihapus!', 'success');
    } else {
        set_flash('Gagal menghapus buku!', 'error');
    }
    redirect('/Munif/admin/manage_books.php');
}

// Get all books
$query = "SELECT b.*, c.name as category_name 
          FROM books b 
          LEFT JOIN categories c ON b.category_id = c.id 
          ORDER BY b.id DESC";
$books = mysqli_query($conn, $query);

// Get categories for import
$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY name");

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-2">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <h1>Kelola Buku</h1>
        <div style="display: flex; gap: 0.5rem;">
            <button onclick="toggleImportModal()" class="btn btn-success">
                <i class="fas fa-download"></i> Import dari API
            </button>
            <a href="add_book.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Manual
            </a>
        </div>
    </div>

    <!-- Import Modal -->
    <div id="importModal" class="modal" style="display: none;">
        <div class="modal-content" style="max-width: 1000px;">
            <div class="modal-header">
                <h2><i class="fas fa-download"></i> Import Buku dari Google Books API</h2>
                <span class="modal-close" onclick="toggleImportModal()">&times;</span>
            </div>
            <div class="modal-body">
                <div class="info-alert">
                    <strong>💡 Cara Menggunakan:</strong>
                    <ol style="margin: 10px 0 0 20px; line-height: 1.8;">
                        <li>Masukkan kata kunci pencarian (contoh: "programming", "business", "novel")</li>
                        <li>Pilih kategori untuk buku yang akan diimport</li>
                        <li>Klik "Cari Buku" untuk melihat hasil</li>
                        <li>Centang buku yang ingin diimport</li>
                        <li>Klik "Import Buku Terpilih"</li>
                    </ol>
                </div>

                <div class="card mb-2">
                    <form id="searchForm">
                        <div class="form-group">
                            <label>Kata Kunci Pencarian *</label>
                            <input type="text" id="search_query" class="form-control"
                                placeholder="Contoh: programming, python, business, science fiction" required>
                            <small style="color: #666;">💡 Tips: Gunakan bahasa Inggris untuk hasil lebih banyak</small>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label>Kategori Default *</label>
                                <select id="default_category" class="form-control" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                                        <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Jumlah Hasil</label>
                                <select id="max_results" class="form-control">
                                    <option value="10">10 buku</option>
                                    <option value="20" selected>20 buku</option>
                                    <option value="30">30 buku</option>
                                    <option value="40">40 buku</option>
                                </select>
                            </div>
                        </div>

                        <button type="button" onclick="searchBooks()" class="btn btn-primary">
                            <i class="fas fa-search"></i> Cari Buku
                        </button>
                    </form>
                </div>

                <div id="searchResults" style="display: none;">
                    <div id="loadingMessage" style="text-align: center; padding: 20px; display: none;">
                        <div class="spinner"></div>
                        <p>Mencari buku dari Google Books API...</p>
                    </div>

                    <div id="resultsContainer" style="display: none;">
                        <h3 style="margin-bottom: 15px;">
                            <i class="fas fa-check-circle" style="color: #28a745;"></i>
                            Ditemukan <span id="resultCount">0</span> buku
                        </h3>

                        <form id="importForm" method="POST" action="process_import_books.php">
                            <input type="hidden" name="category_id" id="import_category">
                            <div id="booksList" style="max-height: 500px; overflow-y: auto;"></div>

                            <div style="text-align: center; margin-top: 20px; padding: 20px; background: #f8f9fa; border-radius: 5px;">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-download"></i> Import Buku Terpilih
                                </button>
                                <button type="button" onclick="toggleImportModal()" class="btn" style="margin-left: 10px;">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($book = mysqli_fetch_assoc($books)): ?>
                    <tr>
                        <td><?php echo $book['id']; ?></td>
                        <td><?php echo $book['title']; ?></td>
                        <td><?php echo $book['author']; ?></td>
                        <td><?php echo $book['category_name']; ?></td>
                        <td><?php echo format_rupiah($book['price']); ?></td>
                        <td><?php echo $book['stock']; ?></td>
                        <td>
                            <a href="edit_book.php?id=<?php echo $book['id']; ?>" class="btn btn-primary" style="padding: 0.5rem 1rem; margin-right: 0.5rem;">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="?delete=<?php echo $book['id']; ?>"
                                onclick="return confirmDelete('Hapus buku ini?')"
                                class="btn" style="padding: 0.5rem 1rem; background: var(--secondary-color);">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
    /* Modal Styles */
    .modal {
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
        animation: fadeIn 0.3s;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .modal-content {
        background-color: #fefefe;
        margin: 2% auto;
        padding: 0;
        border-radius: 10px;
        width: 95%;
        max-width: 1000px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        animation: slideDown 0.3s;
    }

    @keyframes slideDown {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        padding: 20px 30px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 10px 10px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h2 {
        margin: 0;
        font-size: 1.5rem;
    }

    .modal-close {
        color: white;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .modal-close:hover {
        transform: scale(1.2);
    }

    .modal-body {
        padding: 30px;
    }

    .info-alert {
        background: #e3f2fd;
        border-left: 4px solid #2196F3;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }

    .book-item {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 5px;
        display: flex;
        gap: 15px;
        background: white;
        transition: all 0.3s;
    }

    .book-item:hover {
        background: #f8f9fa;
        border-color: #667eea;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
    }

    .book-item img {
        width: 80px;
        height: 120px;
        object-fit: cover;
        border-radius: 3px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .book-item-content {
        flex: 1;
    }

    .book-item-title {
        font-size: 16px;
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .book-item-author {
        color: #666;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .book-item-info {
        font-size: 13px;
        color: #888;
        margin-bottom: 8px;
    }

    .book-item-description {
        font-size: 13px;
        color: #555;
        line-height: 1.5;
        max-height: 60px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .book-item-checkbox {
        display: flex;
        align-items: center;
        padding: 10px;
    }

    .book-item-checkbox input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }

    .no-image {
        width: 80px;
        height: 120px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 11px;
        text-align: center;
        border-radius: 3px;
        padding: 5px;
    }

    .spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #667eea;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
        margin: 0 auto 10px;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<script>
    function toggleImportModal() {
        const modal = document.getElementById('importModal');
        if (modal.style.display === 'none' || modal.style.display === '') {
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        } else {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
            // Reset form
            document.getElementById('searchForm').reset();
            document.getElementById('searchResults').style.display = 'none';
        }
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('importModal');
        if (event.target === modal) {
            toggleImportModal();
        }
    }

    function searchBooks() {
        const query = document.getElementById('search_query').value;
        const category = document.getElementById('default_category').value;
        const maxResults = document.getElementById('max_results').value;

        if (!query || !category) {
            alert('Harap isi kata kunci dan pilih kategori!');
            return;
        }

        // Show loading
        document.getElementById('searchResults').style.display = 'block';
        document.getElementById('loadingMessage').style.display = 'block';
        document.getElementById('resultsContainer').style.display = 'none';
        document.getElementById('import_category').value = category;

        // Call Google Books API
        const apiUrl = `https://www.googleapis.com/books/v1/volumes?q=${encodeURIComponent(query)}&maxResults=${maxResults}&langRestrict=en&printType=books`;

        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                document.getElementById('loadingMessage').style.display = 'none';

                if (data.items && data.items.length > 0) {
                    displayBooks(data.items);
                    document.getElementById('resultCount').textContent = data.items.length;
                    document.getElementById('resultsContainer').style.display = 'block';
                } else {
                    document.getElementById('resultsContainer').style.display = 'block';
                    document.getElementById('booksList').innerHTML = '<p style="text-align: center; padding: 40px; color: #666;"><i class="fas fa-search" style="font-size: 48px; display: block; margin-bottom: 15px; opacity: 0.3;"></i>Tidak ada buku ditemukan. Coba kata kunci lain.</p>';
                    document.getElementById('resultCount').textContent = '0';
                }
            })
            .catch(error => {
                document.getElementById('loadingMessage').style.display = 'none';
                document.getElementById('resultsContainer').style.display = 'block';
                document.getElementById('booksList').innerHTML = '<p style="text-align: center; padding: 40px; color: red;"><i class="fas fa-exclamation-triangle" style="font-size: 48px; display: block; margin-bottom: 15px;"></i>Error: ' + error.message + '</p>';
            });
    }

    function displayBooks(books) {
        const booksList = document.getElementById('booksList');
        let html = '';

        books.forEach((item, index) => {
            const book = item.volumeInfo;
            const title = book.title || 'No Title';
            const authors = book.authors ? book.authors.join(', ') : 'Unknown Author';
            const publisher = book.publisher || 'Unknown';
            const publishedDate = book.publishedDate || 'N/A';
            const description = book.description || 'No description available';
            const isbn = book.industryIdentifiers ? book.industryIdentifiers.find(id => id.type === 'ISBN_13')?.identifier || book.industryIdentifiers[0]?.identifier || '' : '';
            const thumbnail = book.imageLinks?.thumbnail || book.imageLinks?.smallThumbnail || '';
            const pageCount = book.pageCount || 0;

            // Generate a reasonable price
            const basePrice = 50000 + (pageCount * 100);
            const price = Math.round(basePrice / 1000) * 1000;

            // Validasi tahun publikasi - harus antara 1901-2155 untuk MySQL YEAR
            let publicationYear = parseInt(publishedDate.substring(0, 4));
            if (isNaN(publicationYear) || publicationYear < 1901 || publicationYear > 2155) {
                publicationYear = new Date().getFullYear(); // Default ke tahun sekarang
            }

            html += `
            <div class="book-item">
                <div class="book-item-checkbox">
                    <input type="checkbox" name="books[]" value='${JSON.stringify({
                        title: title,
                        author: authors,
                        isbn: isbn,
                        publisher: publisher,
                        publication_year: publicationYear,
                        description: description.substring(0, 500),
                        price: price,
                        stock: 10,
                        image_url: thumbnail
                    }).replace(/'/g, "&#39;")}' checked>
                </div>
                ${thumbnail ? 
                    `<img src="${thumbnail}" alt="${title}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                     <div class="no-image" style="display: none;">No Cover</div>` : 
                    `<div class="no-image">No Cover</div>`
                }
                <div class="book-item-content">
                    <div class="book-item-title">${title}</div>
                    <div class="book-item-author">oleh ${authors}</div>
                    <div class="book-item-info">
                        📚 ${publisher} | 📅 ${publishedDate || publicationYear} | 📖 ${pageCount} hal | 
                        💰 ${formatRupiah(price)} | 📦 Stok: 10
                    </div>
                    <div class="book-item-description">${description.substring(0, 150)}...</div>
                </div>
            </div>
        `;
        });

        booksList.innerHTML = html;
    }

    function formatRupiah(amount) {
        return 'Rp ' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Handle form submission
    document.addEventListener('DOMContentLoaded', function() {
        const importForm = document.getElementById('importForm');
        if (importForm) {
            importForm.addEventListener('submit', function(e) {
                const checkedBoxes = document.querySelectorAll('input[name="books[]"]:checked');
                if (checkedBoxes.length === 0) {
                    e.preventDefault();
                    alert('Pilih minimal satu buku untuk diimport!');
                } else {
                    if (!confirm(`Import ${checkedBoxes.length} buku ke database?\n\nCover image akan otomatis didownload.`)) {
                        e.preventDefault();
                    }
                }
            });
        }
    });
</script>

<?php include '../includes/footer.php'; ?>