<?php
require_once 'config/db.php';
require_once 'config/functions.php';

$page_title = 'Beranda';

// Get featured books
$query = "SELECT b.*, c.name as category_name 
          FROM books b 
          LEFT JOIN categories c ON b.category_id = c.id 
          WHERE b.stock > 0 
          ORDER BY b.created_at DESC 
          LIMIT 8";
$featured_books = mysqli_query($conn, $query);

// Get categories
$categories_query = "SELECT * FROM categories ORDER BY name";
$categories = mysqli_query($conn, $categories_query);

include 'includes/header.php';
include 'includes/navbar.php';
?>

<section class="hero">
    <div class="container">
        <h1>Selamat Datang di Munif Store</h1>
        <p>Temukan buku favorit Anda dengan koleksi terlengkap dan harga terbaik</p>
        <div style="display: inline-flex; align-items: center; gap: 10px; background: rgba(255,255,255,0.2); padding: 10px 20px; border-radius: 25px; margin: 15px 0;">
            <i class="fas fa-robot" style="font-size: 24px;"></i>
            <span style="font-size: 14px;">Katalog diperbarui otomatis via Google Books API</span>
        </div>
        <br>
        <a href="pages/books.php" class="btn">Lihat Katalog</a>
    </div>
</section>

<section class="container mt-2">
    <h2 class="text-center mb-2">Kategori Buku</h2>
    <div class="book-grid">
        <?php
        // Icon mapping berdasarkan nama kategori
        $category_icons = [
            'Fiksi' => 'fas fa-book-open',
            'Non-Fiksi' => 'fas fa-book',
            'Teknologi' => 'fas fa-laptop-code',
            'Bisnis' => 'fas fa-briefcase',
            'Pendidikan' => 'fas fa-graduation-cap',
            'Religi' => 'fas fa-mosque',
            'Komik' => 'fas fa-book-reader'
        ];

        while ($category = mysqli_fetch_assoc($categories)):
            $icon = isset($category_icons[$category['name']]) ? $category_icons[$category['name']] : 'fas fa-book';
        ?>
            <div class="category-card">
                <div class="category-card-content">
                    <i class="<?php echo $icon; ?> category-card-icon"></i>
                    <h3><?php echo $category['name']; ?></h3>
                    <p><?php echo $category['description']; ?></p>
                    <a href="pages/books.php?category=<?php echo $category['id']; ?>" class="btn">
                        <i class="fas fa-arrow-right"></i> Lihat Buku
                    </a>
                </div>
            </div>
        <?php
        endwhile;
        ?>
    </div>
</section>

<section class="container mt-2">
    <h2 class="text-center mb-2">Buku Terbaru</h2>
    <div class="book-grid">
        <?php while ($book = mysqli_fetch_assoc($featured_books)): ?>
            <div class="book-card">
                <img src="assets/images/books/<?php echo $book['image'] ?: 'default.jpg'; ?>"
                    alt="<?php echo $book['title']; ?>"
                    onerror="this.src='assets/images/books/default.jpg'">
                <div class="book-card-content">
                    <h3><?php echo $book['title']; ?></h3>
                    <p class="book-author">oleh <?php echo $book['author']; ?></p>
                    <p class="book-price"><?php echo format_rupiah($book['price']); ?></p>
                    <p class="book-stock">Stok: <?php echo $book['stock']; ?></p>
                    <div class="book-actions">
                        <a href="pages/book_detail.php?id=<?php echo $book['id']; ?>" class="btn btn-detail">
                            <i class="fas fa-info-circle"></i> Detail
                        </a>
                        <?php if (is_logged_in()): ?>
                            <button onclick="addToCart(<?php echo $book['id']; ?>)" class="btn btn-cart">
                                <i class="fas fa-cart-plus"></i> Keranjang
                            </button>
                        <?php else: ?>
                            <a href="pages/login.php" class="btn btn-cart">
                                <i class="fas fa-cart-plus"></i> Keranjang
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>