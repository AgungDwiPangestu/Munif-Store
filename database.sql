-- Database Schema untuk Toko Buku Online
CREATE DATABASE IF NOT EXISTS munif_store;
USE munif_store;

-- Tabel Users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    role ENUM('customer', 'admin') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Categories
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Books
CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(200) NOT NULL,
    isbn VARCHAR(50) UNIQUE,
    category_id INT,
    publisher VARCHAR(200),
    publication_year YEAR,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 0,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Tabel Orders
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    shipping_address TEXT NOT NULL,
    payment_method VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabel Order Items
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    book_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);

-- Tabel Cart
CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    quantity INT DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);

-- Insert sample categories
INSERT INTO categories (name, description) VALUES
('Fiksi', 'Novel dan cerita fiksi'),
('Non-Fiksi', 'Buku berdasarkan fakta dan pengetahuan'),
('Teknologi', 'Buku tentang teknologi dan pemrograman'),
('Bisnis', 'Buku tentang bisnis dan keuangan'),
('Pendidikan', 'Buku pelajaran dan edukatif'),
('Religi', 'Buku keagamaan'),
('Komik', 'Komik dan manga');

-- Insert admin user (password: admin123)
INSERT INTO users (username, email, password, full_name, role) VALUES
('admin', 'admin@munifstore.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin');

-- Insert sample books
INSERT INTO books (title, author, isbn, category_id, publisher, publication_year, description, price, stock, image) VALUES
('Laskar Pelangi', 'Andrea Hirata', '9789793062792', 1, 'Bentang Pustaka', 2005, 'Novel tentang perjuangan anak-anak Belitung dalam menempuh pendidikan', 85000, 50, 'laskar-pelangi.jpg'),
('Bumi Manusia', 'Pramoedya Ananta Toer', '9789799731234', 1, 'Hasta Mitra', 1980, 'Novel sejarah tentang masa kolonial Belanda', 95000, 30, 'bumi-manusia.jpg'),
('Clean Code', 'Robert C. Martin', '9780132350884', 3, 'Prentice Hall', 2008, 'Panduan menulis kode yang bersih dan maintainable', 550000, 25, 'clean-code.jpg'),
('The Lean Startup', 'Eric Ries', '9780307887894', 4, 'Crown Business', 2011, 'Strategi membangun bisnis startup yang sukses', 250000, 40, 'lean-startup.jpg'),
('Sapiens', 'Yuval Noah Harari', '9780062316097', 2, 'Harper', 2015, 'Sejarah singkat umat manusia', 180000, 35, 'sapiens.jpg');
