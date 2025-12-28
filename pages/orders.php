<?php
require_once '../config/db.php';
require_once '../config/functions.php';

$page_title = 'Pesanan Saya';

// Check if user is logged in
if (!is_logged_in()) {
    set_flash('Silakan login terlebih dahulu!', 'error');
    redirect('/ApGuns-Store/pages/login.php');
}

$user_id = $_SESSION['user_id'];

// Get user orders
$query = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY created_at DESC";
$orders = mysqli_query($conn, $query);

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-2">
    <h1 class="text-center mb-2">Pesanan Saya</h1>

    <?php if (mysqli_num_rows($orders) > 0): ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = mysqli_fetch_assoc($orders)): ?>
                        <tr>
                            <td><strong>#<?php echo $order['id']; ?></strong></td>
                            <td><?php echo date('d M Y H:i', strtotime($order['created_at'])); ?></td>
                            <td><?php echo format_rupiah($order['total_amount']); ?></td>
                            <td>
                                <?php
                                $status_colors = [
                                    'pending' => '#f39c12',
                                    'processing' => '#3498db',
                                    'shipped' => '#9b59b6',
                                    'delivered' => '#27ae60',
                                    'cancelled' => '#e74c3c'
                                ];
                                $status_labels = [
                                    'pending' => 'Menunggu',
                                    'processing' => 'Diproses',
                                    'shipped' => 'Dikirim',
                                    'delivered' => 'Selesai',
                                    'cancelled' => 'Dibatalkan'
                                ];
                                ?>
                                <span style="background: <?php echo $status_colors[$order['status']]; ?>; color: white; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.85rem;">
                                    <?php echo $status_labels[$order['status']]; ?>
                                </span>
                            </td>
                            <td>
                                <a href="order_detail.php?id=<?php echo $order['id']; ?>" class="btn">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="text-center" style="padding: 3rem; background: white; border-radius: 10px;">
            <i class="fas fa-shopping-bag" style="font-size: 4rem; color: #ccc;"></i>
            <h3 style="margin-top: 1rem;">Belum Ada Pesanan</h3>
            <p>Anda belum memiliki riwayat pesanan</p>
            <a href="books.php" class="btn mt-1">Mulai Belanja</a>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>