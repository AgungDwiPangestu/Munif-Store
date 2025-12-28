<?php
require_once '../config/db.php';
require_once '../config/functions.php';

$page_title = 'Kelola Pesanan';

if (!is_logged_in() || !is_admin()) {
    set_flash('Akses ditolak!', 'error');
    redirect('/ApGuns-Store/pages/login.php');
}

// Handle status update
if (isset($_POST['update_status'])) {
    $order_id = (int)$_POST['order_id'];
    $status = clean_input($_POST['status']);

    $update_query = "UPDATE orders SET status = '$status' WHERE id = $order_id";
    if (mysqli_query($conn, $update_query)) {
        set_flash('Status pesanan berhasil diperbarui!', 'success');
    } else {
        set_flash('Gagal memperbarui status!', 'error');
    }
    redirect('/ApGuns-Store/admin/manage_orders.php');
}

$query = "SELECT o.*, u.full_name, u.email 
          FROM orders o 
          JOIN users u ON o.user_id = u.id 
          ORDER BY o.created_at DESC";
$orders = mysqli_query($conn, $query);

include '../includes/header.php';
include '../includes/navbar.php';

$status_colors = [
    'pending' => '#f39c12',
    'processing' => '#3498db',
    'shipped' => '#9b59b6',
    'delivered' => '#27ae60',
    'cancelled' => '#e74c3c'
];
?>

<div class="container mt-2">
    <h1 class="mb-2">Kelola Pesanan</h1>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = mysqli_fetch_assoc($orders)): ?>
                    <tr>
                        <td><strong>#<?php echo $order['id']; ?></strong></td>
                        <td>
                            <?php echo $order['full_name']; ?><br>
                            <small><?php echo $order['email']; ?></small>
                        </td>
                        <td><?php echo format_rupiah($order['total_amount']); ?></td>
                        <td>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                <select name="status" onchange="this.form.submit()"
                                    style="background: <?php echo $status_colors[$order['status']]; ?>; color: white; padding: 0.5rem; border: none; border-radius: 5px;">
                                    <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>Menunggu</option>
                                    <option value="processing" <?php echo $order['status'] == 'processing' ? 'selected' : ''; ?>>Diproses</option>
                                    <option value="shipped" <?php echo $order['status'] == 'shipped' ? 'selected' : ''; ?>>Dikirim</option>
                                    <option value="delivered" <?php echo $order['status'] == 'delivered' ? 'selected' : ''; ?>>Selesai</option>
                                    <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>>Dibatalkan</option>
                                </select>
                                <input type="hidden" name="update_status" value="1">
                            </form>
                        </td>
                        <td><?php echo date('d M Y H:i', strtotime($order['created_at'])); ?></td>
                        <td>
                            <a href="order_details.php?id=<?php echo $order['id']; ?>" class="btn">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>