<?php
require_once '../config/db.php';
require_once '../config/functions.php';

header('Content-Type: application/json');

if (!is_logged_in()) {
    echo json_encode(['success' => false, 'message' => 'Silakan login terlebih dahulu']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_id'])) {
    $user_id = $_SESSION['user_id'];
    $book_id = (int)$_POST['book_id'];

    // Check if book exists and has stock
    $book_query = "SELECT * FROM books WHERE id = $book_id AND stock > 0";
    $book_result = mysqli_query($conn, $book_query);

    if (mysqli_num_rows($book_result) == 0) {
        echo json_encode(['success' => false, 'message' => 'Buku tidak tersedia']);
        exit;
    }

    // Check if already in cart
    $cart_query = "SELECT * FROM cart WHERE user_id = $user_id AND book_id = $book_id";
    $cart_result = mysqli_query($conn, $cart_query);

    if (mysqli_num_rows($cart_result) > 0) {
        // Update quantity
        $update_query = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = $user_id AND book_id = $book_id";
        if (mysqli_query($conn, $update_query)) {
            echo json_encode(['success' => true, 'message' => 'Jumlah buku diperbarui']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal update keranjang']);
        }
    } else {
        // Add to cart
        $insert_query = "INSERT INTO cart (user_id, book_id, quantity) VALUES ($user_id, $book_id, 1)";
        if (mysqli_query($conn, $insert_query)) {
            echo json_encode(['success' => true, 'message' => 'Buku ditambahkan ke keranjang']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menambahkan ke keranjang']);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
