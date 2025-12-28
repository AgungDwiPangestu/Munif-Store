<?php
require_once '../config/db.php';
require_once '../config/functions.php';

// Check if user is logged in
if (!is_logged_in()) {
    set_flash('Silakan login terlebih dahulu!', 'error');
    redirect('/ApGuns-Store/pages/login.php');
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    redirect('/ApGuns-Store/pages/orders.php');
}

$order_id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];

// Get order details
$query = "SELECT * FROM orders WHERE id = $order_id AND user_id = $user_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    set_flash('Pesanan tidak ditemukan!', 'error');
    redirect('/ApGuns-Store/pages/orders.php');
}

$order = mysqli_fetch_assoc($result);
$page_title = 'Detail Pesanan #' . $order_id;

// Get order items
$items_query = "SELECT oi.*, b.title, b.author, b.image 
                FROM order_items oi 
                JOIN books b ON oi.book_id = b.id 
                WHERE oi.order_id = $order_id";
$items = mysqli_query($conn, $items_query);

include '../includes/header.php';
include '../includes/navbar.php';

$status_colors = [
    'pending' => '#f39c12',
    'processing' => '#3498db',
    'shipped' => '#9b59b6',
    'delivered' => '#27ae60',
    'cancelled' => '#e74c3c'
];
$status_labels = [
    'pending' => 'Menunggu Pembayaran',
    'processing' => 'Sedang Diproses',
    'shipped' => 'Dalam Pengiriman',
    'delivered' => 'Pesanan Selesai',
    'cancelled' => 'Pesanan Dibatalkan'
];
?>

<div class="container mt-2">
    <h1 class="text-center mb-2">Detail Pesanan #<?php echo $order_id; ?></h1>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- Order Items -->
        <div>
            <div style="background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <h3 style="margin-bottom: 1rem;">Item Pesanan</h3>

                <?php while ($item = mysqli_fetch_assoc($items)): ?>
                    <div style="display: flex; gap: 1rem; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border-color);">
                        <img src="../assets/images/books/<?php echo $item['image'] ?: 'default.jpg'; ?>"
                            alt="<?php echo $item['title']; ?>"
                            onerror="this.src='../assets/images/books/default.jpg'"
                            style="width: 80px; height: 110px; object-fit: cover; border-radius: 5px;">
                        <div style="flex: 1;">
                            <h4><?php echo $item['title']; ?></h4>
                            <p style="color: #666;">oleh <?php echo $item['author']; ?></p>
                            <p><?php echo $item['quantity']; ?> x <?php echo format_rupiah($item['price']); ?></p>
                            <strong><?php echo format_rupiah($item['quantity'] * $item['price']); ?></strong>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Order Info -->
        <div>
            <div style="background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 1.5rem;">
                <h3 style="margin-bottom: 1rem;">Informasi Pesanan</h3>

                <div style="margin-bottom: 1rem;">
                    <strong>Status:</strong><br>
                    <span style="background: <?php echo $status_colors[$order['status']]; ?>; color: white; padding: 0.5rem 1rem; border-radius: 20px; display: inline-block; margin-top: 0.5rem;">
                        <?php echo $status_labels[$order['status']]; ?>
                    </span>
                </div>

                <div style="margin-bottom: 1rem;">
                    <strong>Tanggal Pesanan:</strong><br>
                    <?php echo date('d F Y, H:i', strtotime($order['created_at'])); ?>
                </div>

                <div style="margin-bottom: 1rem;">
                    <strong>Metode Pembayaran:</strong><br>
                    <?php
                    $payment_methods = [
                        'bank_transfer' => 'Transfer Bank',
                        'cod' => 'Cash on Delivery',
                        'e_wallet' => 'E-Wallet'
                    ];
                    echo $payment_methods[$order['payment_method']] ?? $order['payment_method'];
                    ?>
                </div>

                <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 2px solid var(--border-color);">
                    <strong style="font-size: 1.1rem;">Total Pembayaran:</strong><br>
                    <span style="font-size: 1.5rem; color: var(--secondary-color); font-weight: bold;">
                        <?php echo format_rupiah($order['total_amount']); ?>
                    </span>
                </div>
            </div>

            <div style="background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <h3 style="margin-bottom: 1rem;">Alamat Pengiriman</h3>
                <p style="line-height: 1.6;"><?php echo nl2br($order['shipping_address']); ?></p>
            </div>
        </div>
    </div>

    <div class="text-center mt-2">
        <a href="orders.php" class="btn">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pesanan
        </a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>