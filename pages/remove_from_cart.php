<?php
require_once '../config/db.php';
require_once '../config/functions.php';

header('Content-Type: application/json');

if (!is_logged_in()) {
    echo json_encode(['success' => false, 'message' => 'Silakan login terlebih dahulu']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cart_id'])) {
    $user_id = $_SESSION['user_id'];
    $cart_id = (int)$_POST['cart_id'];

    $delete_query = "DELETE FROM cart WHERE id = $cart_id AND user_id = $user_id";
    if (mysqli_query($conn, $delete_query)) {
        echo json_encode(['success' => true, 'message' => 'Item dihapus dari keranjang']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menghapus item']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
