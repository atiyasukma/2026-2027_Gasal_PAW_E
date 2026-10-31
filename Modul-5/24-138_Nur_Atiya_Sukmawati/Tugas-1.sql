-- 1. MEMBUAT DATABASE
CREATE DATABASE IF NOT EXISTS penjualan;
USE penjualan;

-- 2. MEMBUAT TABEL UTAMA (TANPA FOREIGN KEY)
-- Tabel Pelanggan
CREATE TABLE pelanggan (
    id VARCHAR(20) NOT NULL PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    telp VARCHAR(12),
    alamat TEXT
);

-- Tabel Supplier
CREATE TABLE supplier (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    telp VARCHAR(12),
    alamat TEXT
);

-- Tabel User
CREATE TABLE user (
    id_user TINYINT(2) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(35) NOT NULL,
    nama VARCHAR(50) NOT NULL,
    alamat VARCHAR(150),
    hp VARCHAR(20),
    level TINYINT(1) NOT NULL
);


-- 3. BUAT TABEL RELASI (MENGGUNAKAN FOREIGN KEY)
-- Tabel Barang
CREATE TABLE barang (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(10) NOT NULL,
    nama_barang VARCHAR(100) NOT NULL,
    harga INT(11) NOT NULL,
    stok INT(11) NOT NULL,
    supplier_id INT(11),
    FOREIGN KEY (supplier_id) REFERENCES supplier(id) ON DELETE SET NULL ON UPDATE CASCADE
);

-- Tabel Transaksi
CREATE TABLE transaksi (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    waktu_transaksi DATE NOT NULL,
    keterangan TEXT,
    total INT(11) NOT NULL,
    pelanggan_id VARCHAR(20),
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id) ON DELETE SET NULL ON UPDATE CASCADE
);

-- Tabel Transaksi Detail (Composite Primary Key)
CREATE TABLE transaksi_detail (
    transaksi_id INT(11) NOT NULL,
    barang_id INT(11) NOT NULL,
    harga INT(11) NOT NULL,
    qty INT(11) NOT NULL,
    PRIMARY KEY (transaksi_id, barang_id),
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (barang_id) REFERENCES barang(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabel Pembayaran
CREATE TABLE pembayaran (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    waktu_bayar DATETIME NOT NULL,
    total INT(11) NOT NULL,
    metode ENUM('TUNAI', 'TRANSFER', 'EDC') NOT NULL,
    transaksi_id INT(11),
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE ON UPDATE CASCADE
);