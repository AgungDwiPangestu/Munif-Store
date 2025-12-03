<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/functions.php';

$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Use POST']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$message = strtolower(trim($input['message'] ?? ''));

function reply($text, $suggestions = [])
{
    return ['success' => true, 'reply' => $text, 'suggestions' => $suggestions];
}

if ($message === '') {
    echo json_encode(reply('Halo! Ada yang bisa saya bantu hari ini?', ['Cari buku', 'Cek pesanan', 'Hubungi admin']));
    exit;
}

// Simple intent detection
$intent = 'smalltalk';
if (preg_match('/(halo|hai|hello|hi)/', $message)) $intent = 'greeting';
elseif (preg_match('/(bantuan|help|cara|bagaimana)/', $message)) $intent = 'help';
elseif (preg_match('/(jam|buka|tutup|operasional)/', $message)) $intent = 'hours';
elseif (preg_match('/(kontak|hubungi|email|admin)/', $message)) $intent = 'contact';
elseif (preg_match('/(pesanan|order|status)/', $message)) $intent = 'orders';
elseif (preg_match('/(cari|search|judul|penulis|isbn|kategori)/', $message)) $intent = 'search';
elseif (preg_match('/(keranjang|cart|belanja)/', $message)) $intent = 'cart';

switch ($intent) {
    case 'greeting':
        echo json_encode(reply('Halo 👋, selamat datang di Munif Store! Saya bisa bantu cari buku, cek pesanan, atau info kontak.', ['Cari buku', 'Cek pesanan', 'Hubungi admin']));
        break;
    case 'help':
        echo json_encode(reply('Berikut yang bisa saya bantu: \n• Cari buku berdasarkan judul, penulis, atau kategori\n• Melihat detail dan stok buku\n• Cek status pesanan Anda\n• Info kontak admin', ['Cari buku', 'Cek pesanan', 'Kontak admin']));
        break;
    case 'hours':
        echo json_encode(reply('Jam operasional: Senin–Jumat 09.00–17.00 WIB. Order online 24/7, dukungan admin pada jam kerja.', ['Kontak admin', 'Cari buku']));
        break;
    case 'contact':
        echo json_encode(reply('Anda bisa menghubungi kami di email admin@munifstore.com atau melalui halaman kontak. Ada yang bisa saya bantu sekarang?', ['Cari buku', 'Cek pesanan']));
        break;
    case 'orders':
        echo json_encode(reply('Untuk cek pesanan, login lalu buka halaman Pesanan Saya di navbar. Ingin saya arahkan ke halaman itu?', ['Buka Pesanan', 'Login']));
        break;
    case 'search':
        echo json_encode(reply('Silakan ketik: Cari [kata kunci], contoh: Cari Pramoedya atau Cari kategori Teknologi. Anda juga bisa gunakan filter di halaman Katalog.', ['Buka Katalog', 'Lihat kategori']));
        break;
    case 'cart':
        echo json_encode(reply('Untuk menambahkan ke keranjang, buka detail buku lalu klik Tambah ke Keranjang. Anda harus login terlebih dahulu.', ['Login', 'Buka Katalog']));
        break;
    default:
        // Fallback: echo the message and suggest actions
        echo json_encode(reply('Baik, saya belum yakin. Coba jelaskan: ingin cari buku, cek pesanan, atau info kontak?', ['Cari buku', 'Cek pesanan', 'Kontak admin']));
}
