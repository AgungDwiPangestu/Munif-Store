<?php
require_once '../config/db.php';
require_once '../config/functions.php';

$page_title = 'Admin Dashboard';

// Check if user is admin
if (!is_logged_in() || !is_admin()) {
    set_flash('Akses ditolak! Anda harus login sebagai admin.', 'error');
    redirect('/ApGuns-Store/pages/login.php');
}

// Get statistics
$total_books_query = "SELECT COUNT(*) as total FROM books";
$total_books = mysqli_fetch_assoc(mysqli_query($conn, $total_books_query))['total'];

$total_orders_query = "SELECT COUNT(*) as total FROM orders";
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, $total_orders_query))['total'];

$total_users_query = "SELECT COUNT(*) as total FROM users WHERE role = 'customer'";
$total_users = mysqli_fetch_assoc(mysqli_query($conn, $total_users_query))['total'];

$total_revenue_query = "SELECT SUM(total_amount) as total FROM orders WHERE status != 'cancelled'";
$total_revenue = mysqli_fetch_assoc(mysqli_query($conn, $total_revenue_query))['total'] ?? 0;

// Recent orders
$recent_orders_query = "SELECT o.*, u.full_name 
                        FROM orders o 
                        JOIN users u ON o.user_id = u.id 
                        ORDER BY o.created_at DESC 
                        LIMIT 10";
$recent_orders = mysqli_query($conn, $recent_orders_query);

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-2">
    <h1 class="text-center mb-2">Dashboard Admin</h1>

    <!-- Statistics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="margin-bottom: 0.5rem;"><?php echo $total_books; ?></h3>
                    <p>Total Buku</p>
                </div>
                <i class="fas fa-book" style="font-size: 3rem; opacity: 0.5;"></i>
            </div>
        </div>

        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="margin-bottom: 0.5rem;"><?php echo $total_orders; ?></h3>
                    <p>Total Pesanan</p>
                </div>
                <i class="fas fa-shopping-cart" style="font-size: 3rem; opacity: 0.5;"></i>
            </div>
        </div>

        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="margin-bottom: 0.5rem;"><?php echo $total_users; ?></h3>
                    <p>Total Pelanggan</p>
                </div>
                <i class="fas fa-users" style="font-size: 3rem; opacity: 0.5;"></i>
            </div>
        </div>

        <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="margin-bottom: 0.5rem; font-size: 1.5rem;"><?php echo format_rupiah($total_revenue); ?></h3>
                    <p>Total Pendapatan</p>
                </div>
                <i class="fas fa-dollar-sign" style="font-size: 3rem; opacity: 0.5;"></i>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <a href="manage_books.php" class="btn btn-primary" style="text-align: center; padding: 1rem;">
            <i class="fas fa-book"></i> Kelola Buku
        </a>
        <a href="manage_books.php" class="btn" style="text-align: center; padding: 1rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; position: relative; overflow: hidden;">
            <i class="fas fa-cloud-download-alt"></i> Import dari API
            <span style="position: absolute; top: 5px; right: 5px; background: #ff6b6b; color: white; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: bold;">NEW!</span>
        </a>
        <a href="manage_categories.php" class="btn btn-primary" style="text-align: center; padding: 1rem;">
            <i class="fas fa-tags"></i> Kelola Kategori
        </a>
        <a href="manage_orders.php" class="btn btn-primary" style="text-align: center; padding: 1rem;">
            <i class="fas fa-shopping-bag"></i> Kelola Pesanan
        </a>
        <a href="manage_users.php" class="btn btn-primary" style="text-align: center; padding: 1rem;">
            <i class="fas fa-users"></i> Kelola Pengguna
        </a>
    </div>

    <!-- Recent Orders -->
    <div class="table-container">
        <h3 style="padding: 1rem; background: var(--primary-color); color: white; margin: 0;">Pesanan Terbaru</h3>
        <table>
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
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
                while ($order = mysqli_fetch_assoc($recent_orders)):
                ?>
                    <tr>
                        <td><strong>#<?php echo $order['id']; ?></strong></td>
                        <td><?php echo $order['full_name']; ?></td>
                        <td><?php echo format_rupiah($order['total_amount']); ?></td>
                        <td>
                            <span style="background: <?php echo $status_colors[$order['status']]; ?>; color: white; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.85rem;">
                                <?php echo $status_labels[$order['status']]; ?>
                            </span>
                        </td>
                        <td><?php echo date('d M Y', strtotime($order['created_at'])); ?></td>
                        <td>
                            <a href="order_details.php?id=<?php echo $order['id']; ?>" class="btn" style="padding: 0.5rem 1rem;">
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