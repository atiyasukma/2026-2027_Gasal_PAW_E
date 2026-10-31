-- INSERT DATA ( 10 DATA/TABEL)
-- Data Supplier
INSERT INTO supplier (nama, telp, alamat) VALUES
('PT. Maju Bersama', '08123456', 'Sumenep'),
('PT. Senang Sekali', '081515563', 'Bangkalan'),
('PT. Segar Segar', '0845454663', 'Surabaya'),
('CV. Sumber Makmur', '081298765432', 'Malang'),
('PT. Jaya Abadi', '085678901234', 'Sidoarjo'),
('CV. Berkah Utama', '087812345678', 'Gresik'),
('PT. Nusantara Indah', '089611223344', 'Jakarta'),
('CV. Prima Mandiri', '083899887766', 'Bandung'),
('PT. Cahaya Sejahtera', '082133445566', 'Semarang'),
('CV. Tirta Kencana', '081355667788', 'Yogyakarta');

-- Data Pelanggan
INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES
('PLG001', 'Arya Pradipta', 'L', '081211112222', 'Surabaya'),
('PLG002', 'Atiya Sukma', 'P', '081233334444', 'Sumenep'),
('PLG003', 'Damar Gautama', 'L', '081255556666', 'Kamal'),
('PLG004', 'Kahiyang Arum', 'P', '081277778888', 'Sidoarjo'),
('PLG005', 'Narayana Teja', 'L', '081299990000', 'Gresik'),
('PLG006', 'Bening Hasthi', 'P', '085611112222', 'Malang'),
('PLG007', 'Dewa Mahawira', 'L', '085633334444', 'Surabaya'),
('PLG008', 'Gita Anindita', 'P', '085655556666', 'Mojokerto'),
('PLG009', 'Bramantyo Sadara', 'L', '085677778888', 'Jombang'),
('PLG010', 'Samudera Ningrum', 'P', '085699990000', 'Lamongan');

-- Data User
INSERT INTO user (username, password, nama, alamat, hp, level) VALUES
('admin', MD5('admin123'), 'Administrator Utama', 'Surabaya', '081200000001', 1),
('kasir1', MD5('kasir123'), 'Zorion Kasir', 'Bangkalan', '081200000002', 2),
('kasir2', MD5('kasir123'), 'Arum Kasir', 'Surabaya', '081200000003', 2),
('manager', MD5('manager123'), 'Pandu Manager', 'Sidoarjo', '081200000004', 1),
('gudang1', MD5('gudang123'), 'Sena Gudang', 'Gresik', '081200000005', 3),
('gudang2', MD5('gudang123'), 'Manggala Gudang', 'Malang', '081200000006', 3),
('supervisor', MD5('spv123'), 'Cempaka SPV', 'Surabaya', '081200000007', 1),
('kasir3', MD5('kasir123'), 'Murni Kasir', 'Kamal', '081200000008', 2),
('audit1', MD5('audit123'), 'Arsa Auditor', 'Jakarta', '081200000009', 1),
('owner', MD5('owner123'), 'Owner Toko', 'Surabaya', '081200000010', 1);

-- Data Barang
INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) VALUES
('BRG001', 'Buku Tulis A5', 5000, 100, 1),
('BRG002', 'Pensil 2B', 3000, 200, 1),
('BRG003', 'Pulpen Hitam', 4000, 150, 2),
('BRG004', 'Penggaris 30cm', 6000, 80, 2),
('BRG005', 'Penghapus Karet', 2000, 300, 3),
('BRG006', 'Spidol Boardmarker', 8000, 90, 3),
('BRG007', 'Kertas A4 80gr', 55000, 50, 4),
('BRG008', 'Map Snelhecter', 3500, 120, 5),
('BRG009', 'Tipe-X Liquid', 7000, 70, 6),
('BRG010', 'Stapler Kecil', 12000, 40, 7);

-- Data Transaksi
INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) VALUES
('2026-03-01', 'Penjualan tunai ATK', 15000, 'PLG001'),
('2026-03-01', 'Penjualan grosir', 110000, 'PLG002'),
('2026-03-02', 'Pembelian eceran', 20000, 'PLG003'),
('2026-03-02', 'Pembelian perlengkapan', 45000, 'PLG004'),
('2026-03-03', 'Penjualan ATK kantor', 65000, 'PLG005'),
('2026-03-03', 'Penjualan tunai', 12000, 'PLG006'),
('2026-03-04', 'Penjualan grosir', 150000, 'PLG007'),
('2026-03-04', 'Pembelian eceran', 25000, 'PLG008'),
('2026-03-05', 'Penjualan kantor', 80000, 'PLG009'),
('2026-03-05', 'Pembelian sekolah', 35000, 'PLG010');

-- Data Transaksi Detail
INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES
(1, 1, 5000, 3),
(2, 7, 55000, 2),
(3, 3, 4000, 5),
(4, 6, 8000, 5),
(5, 7, 55000, 1),
(6, 2, 3000, 4),
(7, 10, 12000, 10),
(8, 4, 6000, 3),
(9, 9, 7000, 10),
(10, 8, 3500, 10);

-- Data Pembayaran
INSERT INTO pembayaran (waktu_bayar, total, metode, transaksi_id) VALUES
('2026-03-01 10:00:00', 15000, 'TUNAI', 1),
('2026-03-01 11:30:00', 110000, 'TRANSFER', 2),
('2026-03-02 09:15:00', 20000, 'TUNAI', 3),
('2026-03-02 14:20:00', 45000, 'EDC', 4),
('2026-03-03 08:45:00', 65000, 'TRANSFER', 5),
('2026-03-03 13:10:00', 12000, 'TUNAI', 6),
('2026-03-04 15:00:00', 150000, 'TRANSFER', 7),
('2026-03-04 16:30:00', 25000, 'EDC', 8),
('2026-03-05 10:05:00', 80000, 'TRANSFER', 9),
('2026-03-05 11:50:00', 35000, 'TUNAI', 10);