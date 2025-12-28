<?php
require_once '../config/db.php';
require_once '../config/functions.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    redirect('/ApGuns-Store/pages/books.php');
}

$book_id = (int)$_GET['id'];

// Get book details
$query = "SELECT b.*, c.name as category_name 
          FROM books b 
          LEFT JOIN categories c ON b.category_id = c.id 
          WHERE b.id = $book_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    redirect('/ApGuns-Store/pages/books.php');
}

$book = mysqli_fetch_assoc($result);
$page_title = $book['title'];

// Get related books
$related_query = "SELECT * FROM books 
                  WHERE category_id = {$book['category_id']} 
                  AND id != $book_id 
                  AND stock > 0 
                  LIMIT 4";
$related_books = mysqli_query($conn, $related_query);

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-2">
    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 3rem; background: white; padding: 2rem; border-radius: 10px;">
        <!-- Book Image -->
        <div>
            <img src="../assets/images/books/<?php echo $book['image'] ?: 'default.jpg'; ?>"
                alt="<?php echo $book['title']; ?>"
                onerror="this.src='../assets/images/books/default.jpg'"
                style="width: 100%; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
        </div>

        <!-- Book Details -->
        <div>
            <h1 style="color: var(--primary-color); margin-bottom: 1rem;"><?php echo $book['title']; ?></h1>

            <div style="margin-bottom: 2rem;">
                <p style="font-size: 1.1rem; color: #666; margin-bottom: 0.5rem;">
                    <strong>Penulis:</strong> <?php echo $book['author']; ?>
                </p>
                <p style="font-size: 1rem; color: #666; margin-bottom: 0.5rem;">
                    <strong>Penerbit:</strong> <?php echo $book['publisher']; ?>
                </p>
                <p style="font-size: 1rem; color: #666; margin-bottom: 0.5rem;">
                    <strong>Tahun Terbit:</strong> <?php echo $book['publication_year']; ?>
                </p>
                <p style="font-size: 1rem; color: #666; margin-bottom: 0.5rem;">
                    <strong>ISBN:</strong> <?php echo $book['isbn']; ?>
                </p>
                <p style="font-size: 1rem; color: #666; margin-bottom: 0.5rem;">
                    <strong>Kategori:</strong>
                    <span style="background: var(--accent-color); color: white; padding: 0.25rem 0.75rem; border-radius: 15px;">
                        <?php echo $book['category_name']; ?>
                    </span>
                </p>
            </div>

            <div style="margin-bottom: 2rem; padding: 1.5rem; background: var(--bg-color); border-radius: 10px;">
                <p style="font-size: 2rem; color: var(--secondary-color); font-weight: bold; margin-bottom: 0.5rem;">
                    <?php echo format_rupiah($book['price']); ?>
                </p>
                <p style="font-size: 1.1rem; color: <?php echo $book['stock'] > 0 ? 'var(--success-color)' : 'var(--secondary-color)'; ?>">
                    <strong>Stok:</strong> <?php echo $book['stock']; ?>
                    <?php echo $book['stock'] > 0 ? 'tersedia' : 'habis'; ?>
                </p>
            </div>

            <?php if (is_logged_in() && $book['stock'] > 0): ?>
                <div style="display: flex; gap: 1rem;">
                    <button onclick="addToCart(<?php echo $book['id']; ?>)" class="btn btn-success" style="flex: 1; font-size: 1.1rem; padding: 1rem;">
                        <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                    </button>
                </div>
            <?php elseif (!is_logged_in()): ?>
                <div style="padding: 1rem; background: #fff3cd; border-radius: 5px; color: #856404;">
                    <i class="fas fa-info-circle"></i> Silakan <a href="login.php">login</a> untuk membeli buku ini
                </div>
            <?php endif; ?>

            <div style="margin-top: 2rem;">
                <h3 style="margin-bottom: 1rem;">Deskripsi</h3>
                <p style="line-height: 1.8; text-align: justify;">
                    <?php echo nl2br($book['description']); ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Related Books -->
    <?php if (mysqli_num_rows($related_books) > 0): ?>
        <div class="mt-2">
            <h2 class="text-center mb-2">Buku Terkait</h2>
            <div class="book-grid">
                <?php while ($related = mysqli_fetch_assoc($related_books)): ?>
                    <div class="book-card">
                        <img src="../assets/images/books/<?php echo $related['image'] ?: 'default.jpg'; ?>"
                            alt="<?php echo $related['title']; ?>"
                            onerror="this.src='../assets/images/books/default.jpg'">
                        <div class="book-card-content">
                            <h3><?php echo $related['title']; ?></h3>
                            <p class="book-author">oleh <?php echo $related['author']; ?></p>
                            <p class="book-price"><?php echo format_rupiah($related['price']); ?></p>
                            <a href="book_detail.php?id=<?php echo $related['id']; ?>" class="btn">Detail</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>