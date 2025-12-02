<?php
require_once '../config/db.php';
require_once '../config/functions.php';

$page_title = 'Kelola Kategori';

if (!is_logged_in() || !is_admin()) {
    set_flash('Akses ditolak!', 'error');
    redirect('/Munif/pages/login.php');
}

// Handle add/edit/delete
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $name = clean_input($_POST['name']);
        $description = clean_input($_POST['description']);

        $query = "INSERT INTO categories (name, description) VALUES ('$name', '$description')";
        if (mysqli_query($conn, $query)) {
            set_flash('Kategori berhasil ditambahkan!', 'success');
        }
    } elseif (isset($_POST['edit'])) {
        $id = (int)$_POST['id'];
        $name = clean_input($_POST['name']);
        $description = clean_input($_POST['description']);

        $query = "UPDATE categories SET name = '$name', description = '$description' WHERE id = $id";
        if (mysqli_query($conn, $query)) {
            set_flash('Kategori berhasil diperbarui!', 'success');
        }
    }
    redirect('/Munif/admin/manage_categories.php');
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $delete_query = "DELETE FROM categories WHERE id = $id";
    if (mysqli_query($conn, $delete_query)) {
        set_flash('Kategori berhasil dihapus!', 'success');
    }
    redirect('/Munif/admin/manage_categories.php');
}

$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY name");

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-2">
    <h1 class="mb-2">Kelola Kategori</h1>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
        <!-- Add Form -->
        <div class="form-container" style="margin: 0;">
            <h3>Tambah Kategori</h3>
            <form method="POST">
                <div class="form-group">
                    <label>Nama Kategori *</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" rows="3"></textarea>
                </div>
                <button type="submit" name="add" class="btn btn-success" style="width: 100%;">Tambah</button>
            </form>
        </div>

        <!-- Categories List -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                        <tr>
                            <td><?php echo $cat['id']; ?></td>
                            <td><?php echo $cat['name']; ?></td>
                            <td><?php echo $cat['description']; ?></td>
                            <td>
                                <a href="?delete=<?php echo $cat['id']; ?>"
                                    onclick="return confirmDelete('Hapus kategori ini?')"
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
</div>

<?php include '../includes/footer.php'; ?>