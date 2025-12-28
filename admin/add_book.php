<?php
require_once '../config/db.php';
require_once '../config/functions.php';

$page_title = 'Tambah Buku';

if (!is_logged_in() || !is_admin()) {
    set_flash('Akses ditolak!', 'error');
    redirect('/ApGuns-Store/pages/login.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = clean_input($_POST['title']);
    $author = clean_input($_POST['author']);
    $isbn = clean_input($_POST['isbn']);
    $category_id = (int)$_POST['category_id'];
    $publisher = clean_input($_POST['publisher']);
    $publication_year = (int)$_POST['publication_year'];
    $description = clean_input($_POST['description']);
    $price = (float)$_POST['price'];
    $stock = (int)$_POST['stock'];

    $image_name = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_result = upload_image($_FILES['image']);
        if ($upload_result['success']) {
            $image_name = $upload_result['filename'];
        } else {
            $error = $upload_result['message'];
        }
    }

    if (empty($error)) {
        $query = "INSERT INTO books (title, author, isbn, category_id, publisher, publication_year, description, price, stock, image) 
                  VALUES ('$title', '$author', '$isbn', $category_id, '$publisher', $publication_year, '$description', $price, $stock, '$image_name')";

        if (mysqli_query($conn, $query)) {
            set_flash('Buku berhasil ditambahkan!', 'success');
            redirect('/ApGuns-Store/admin/manage_books.php');
        } else {
            $error = 'Gagal menambahkan buku: ' . mysqli_error($conn);
        }
    }
}

$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY name");

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="form-container">
    <h2 class="text-center">Tambah Buku Baru</h2>

    <?php if (!empty($error)): ?>
        <div class="flash-message error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Judul Buku *</label>
            <input type="text" name="title" required>
        </div>

        <div class="form-group">
            <label>Penulis *</label>
            <input type="text" name="author" required>
        </div>

        <div class="form-group">
            <label>ISBN</label>
            <input type="text" name="isbn">
        </div>

        <div class="form-group">
            <label>Kategori *</label>
            <select name="category_id" required>
                <option value="">Pilih Kategori</option>
                <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                    <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Penerbit</label>
            <input type="text" name="publisher">
        </div>

        <div class="form-group">
            <label>Tahun Terbit</label>
            <input type="number" name="publication_year" min="1900" max="<?php echo date('Y'); ?>">
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description" rows="5"></textarea>
        </div>

        <div class="form-group">
            <label>Harga *</label>
            <input type="number" name="price" step="0.01" required>
        </div>

        <div class="form-group">
            <label>Stok *</label>
            <input type="number" name="stock" min="0" required>
        </div>

        <div class="form-group">
            <label>Gambar Cover</label>
            <input type="file" name="image" accept="image/*" onchange="previewImage(this)">
            <img id="image-preview" style="display: none; max-width: 200px; margin-top: 1rem; border-radius: 5px;">
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-success" style="flex: 1;">Simpan</button>
            <a href="manage_books.php" class="btn" style="flex: 1; text-align: center;">Batal</a>
        </div>
    </form>
</div>

<?php include '../includes/footer.php'; ?>