<?php
session_start();
require_once 'Koneksi.php';

// Cek login
if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
    header("Location: Tugas-1.php");
    exit;
}

$nama = $_SESSION['nama'];
$level = $_SESSION['level'];
$id_user = $_SESSION['id_user'];

$hal = $_GET['hal'] ?? 'home';
$tabel = $_GET['t'] ?? 'barang';

// Data Master
$data = [
    'barang' => [
        'judul' => 'Data Barang',
        'kolom' => ['kode_barang', 'nama_barang', 'harga', 'stok', 'id_supplier']
    ],
    'supplier' => [
        'judul' => 'Data Supplier',
        'kolom' => ['nama_supplier', 'telp', 'alamat']
    ],
    'pelanggan' => [
        'judul' => 'Data Pelanggan',
        'kolom' => ['nama_pelanggan', 'jenis_kelamin', 'telp', 'alamat']
    ],
    'user' => [
        'judul' => 'Data User',
        'kolom' => ['username', 'password', 'nama', 'alamat', 'hp', 'level']
    ]
];

// Hak akses kasir
if ($hal == 'master' && $level != 1) {
    header("Location: Tugas-2.php");
    exit;
}

// Memastikan tabel tersedia
if (!isset($data[$tabel])) {
    $tabel = 'barang';
}

$pk = 'id_' . $tabel;

// Proses hapus data
if ($hal == 'master' && isset($_POST['hapus'])) {
    $stmt = $conn->prepare("DELETE FROM $tabel WHERE $pk = ?");
    $stmt->execute([$_POST['id']]);

    header("Location: Tugas-2.php?hal=master&t=$tabel");
    exit;
}

// Proses tambah dan edit data
if ($hal == 'master' && isset($_POST['simpan'])) {

    $isi = [];

    foreach ($data[$tabel]['kolom'] as $k) {

        if ($k == 'password' && $_POST[$k] == '' && isset($_POST['id'])) {
            continue;
        }

        $isi[$k] = ($k == 'password')
            ? md5($_POST[$k])
            : $_POST[$k];
    }

    if (isset($_POST['id'])) {

        $set = [];

        foreach ($isi as $k => $v) {
            $set[] = "$k = ?";
        }

        $sql = "UPDATE $tabel SET " . implode(',', $set) . " WHERE $pk = ?";
        $isi[] = $_POST['id'];

    } else {

        $sql = "INSERT INTO $tabel (" . implode(',', array_keys($isi)) . ")
                VALUES (" . implode(',', array_fill(0, count($isi), '?')) . ")";
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute(array_values($isi));

    header("Location: Tugas-2.php?hal=master&t=$tabel");
    exit;
}

// Ambil data untuk diedit
$edit = null;

if ($hal == 'master' && isset($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT * FROM $tabel WHERE $pk = ?");
    $stmt->execute([$_GET['edit']]);
    $edit = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Ambil data master
$hasil = [];

if ($hal == 'master') {
    $hasil = $conn->query("SELECT * FROM $tabel")->fetchAll(PDO::FETCH_ASSOC);
}

// Proses transaksi
if ($hal == 'transaksi' && isset($_POST['transaksi'])) {

    $id_barang = $_POST['id_barang'];
    $jumlah = (int) $_POST['jumlah'];

    $stmt = $conn->prepare("SELECT * FROM barang WHERE id_barang = ?");
    $stmt->execute([$id_barang]);
    $barang = $stmt->fetch(PDO::FETCH_ASSOC);

    // Cek barang dan stok
    if ($barang && $jumlah > 0 && $jumlah <= $barang['stok']) {

        $total = $barang['harga'] * $jumlah;
        $faktur = 'TRX-' . date('YmdHis');

        try {
            $conn->beginTransaction();

            $pelanggan = !empty($_POST['id_pelanggan'])
                ? $_POST['id_pelanggan'] : null;

            // Simpan transaksi
            $stmt = $conn->prepare("
                INSERT INTO transaksi
                (no_faktur, tanggal, id_user, id_pelanggan, total)
                VALUES (?, NOW(), ?, ?, ?)
            ");

            $stmt->execute([
                $faktur,
                $id_user,
                $pelanggan,
                $total
            ]);

            $id_transaksi = $conn->lastInsertId();

            // Simpan detail transaksi
            $stmt = $conn->prepare("
                INSERT INTO detail_transaksi
                (id_transaksi, id_barang, jumlah, harga, subtotal)
                VALUES (?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $id_transaksi,
                $id_barang,
                $jumlah,
                $barang['harga'],
                $total
            ]);

            // Kurangi stok barang
            $stmt = $conn->prepare("
                UPDATE barang SET stok = stok - ? WHERE id_barang = ?
            ");

            $stmt->execute([$jumlah, $id_barang]);

            $conn->commit();

            header("Location: Tugas-2.php?hal=laporan");
            exit;

        } catch (PDOException $e) {
            $conn->rollBack();
            $pesan = "Transaksi gagal disimpan.";
        }

    } else {
        $pesan = "Barang tidak tersedia atau stok tidak mencukupi.";
    }
}

// Ambil data barang dan pelanggan
$barang = $conn->query("SELECT * FROM barang")->fetchAll(PDO::FETCH_ASSOC);
$pelanggan = $conn->query("SELECT * FROM pelanggan")->fetchAll(PDO::FETCH_ASSOC);

// Ambil data laporan
if ($hal == 'laporan') {
    $laporan = $conn->query("
        SELECT transaksi.*, user.nama
        FROM transaksi
        JOIN user ON transaksi.id_user = user.id_user
        ORDER BY transaksi.tanggal DESC
    ")->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<!-- NAVIGASI -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">

        <a class="navbar-brand" href="Tugas-2.php">Sistem Penjualan</a>

        <div class="navbar-nav me-auto">
            <a class="nav-link" href="Tugas-2.php">Home</a>

            <?php if ($level == 1) { ?>
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    Data Master
                </a>

                <ul class="dropdown-menu">
                    <?php foreach ($data as $t => $d) { ?>
                    <li>
                        <a class="dropdown-item" href="Tugas-2.php?hal=master&t=<?= $t ?>">
                            <?= $d['judul'] ?>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <?php } ?>

            <a class="nav-link" href="Tugas-2.php?hal=transaksi">Transaksi</a>
            <a class="nav-link" href="Tugas-2.php?hal=laporan">Laporan</a>
        </div>

        <!-- NAMA USER DAN LOGOUT -->
        <div class="navbar-nav">
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    <?= htmlspecialchars($nama) ?>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <span class="dropdown-item-text">
                            <?= $level == 1 ? 'Owner' : 'Kasir' ?>
                        </span>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="Tugas-3.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</nav>

<div class="container mt-4">

<?php if ($hal == 'home') { ?>

    <h3>Selamat Datang, <?= htmlspecialchars($nama) ?>!</h3>
    <p>Anda login sebagai <?= $level == 1 ? 'Owner' : 'Kasir' ?>.</p>

<?php } elseif ($hal == 'master' && $level == 1) { ?>

    <h3><?= $data[$tabel]['judul'] ?></h3>

    <!-- FORM TAMBAH DAN EDIT -->
    <form method="POST" class="card card-body mb-4">

        <?php if ($edit) { ?>
            <input type="hidden" name="id" value="<?= $edit[$pk] ?>">
        <?php } ?>

        <div class="row">

            <?php foreach ($data[$tabel]['kolom'] as $k) { ?>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    <?= ucwords(str_replace('_', ' ', $k)) ?>
                </label>

                <?php if ($k == 'level') { ?>

                    <select name="level" class="form-select">
                        <option value="1" <?= ($edit && $edit[$k] == 1) ? 'selected' : '' ?>>
                            1 - Owner
                        </option>

                        <option value="2" <?= ($edit && $edit[$k] == 2) ? 'selected' : '' ?>>
                            2 - Kasir
                        </option>
                    </select>

                <?php } else { ?>

                    <input
                        type="<?= $k == 'password' ? 'password' : 'text' ?>"
                        name="<?= $k ?>"
                        class="form-control"
                        value="<?= ($edit && $k != 'password') ? htmlspecialchars($edit[$k]) : '' ?>"
                        <?= ($k == 'password' && $edit) ? '' : 'required' ?>
                        placeholder="<?= ($k == 'password' && $edit) ? 'Kosongkan jika tidak diubah' : '' ?>"
                    >

                <?php } ?>

            </div>

            <?php } ?>

        </div>

        <button type="submit" name="simpan" class="btn btn-primary">
            <?= $edit ? 'Update' : 'Tambah' ?>
        </button>

    </form>

    <!-- TABEL DATA -->
    <table class="table table-bordered">

        <thead class="table-primary">
            <tr>
                <th>No</th>

                <?php foreach ($data[$tabel]['kolom'] as $k) { ?>
                    <?php if ($k != 'password') { ?>
                        <th><?= ucwords(str_replace('_', ' ', $k)) ?></th>
                    <?php } ?>
                <?php } ?>

                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($hasil as $i => $r) { ?>

            <tr>
                <td><?= $i + 1 ?></td>

                <?php foreach ($data[$tabel]['kolom'] as $k) { ?>
                    <?php if ($k != 'password') { ?>
                        <td><?= htmlspecialchars($r[$k]) ?></td>
                    <?php } ?>
                <?php } ?>

                <td>
                    <a href="Tugas-2.php?hal=master&t=<?= $tabel ?>&edit=<?= $r[$pk] ?>"
                       class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <form method="POST" class="d-inline"
                          onsubmit="return confirm('Hapus data ini?')">

                        <input type="hidden" name="id" value="<?= $r[$pk] ?>">

                        <button type="submit" name="hapus" class="btn btn-danger btn-sm">
                            Hapus
                        </button>

                    </form>
                </td>
            </tr>

            <?php } ?>

            <?php if (count($hasil) == 0) { ?>
            <tr>
                <td colspan="10" class="text-center">Belum ada data.</td>
            </tr>
            <?php } ?>

        </tbody>
    </table>

<?php } elseif ($hal == 'transaksi') { ?>

    <h3>Transaksi Penjualan</h3>

    <?php if (isset($pesan)) { ?>
        <div class="alert alert-danger"><?= $pesan ?></div>
    <?php } ?>

    <form method="POST" class="card card-body">

        <label class="form-label">Pelanggan</label>

        <select name="id_pelanggan" class="form-select mb-3">
            <option value="">Umum</option>

            <?php foreach ($pelanggan as $p) { ?>
            <option value="<?= $p['id_pelanggan'] ?>">
                <?= htmlspecialchars($p['nama_pelanggan']) ?>
            </option>
            <?php } ?>

        </select>

        <label class="form-label">Barang</label>

        <select name="id_barang" class="form-select mb-3" required>

            <?php foreach ($barang as $b) { ?>
            <option value="<?= $b['id_barang'] ?>">
                <?= htmlspecialchars($b['nama_barang']) ?>
                - Rp<?= number_format($b['harga']) ?>
            </option>
            <?php } ?>

        </select>

        <label class="form-label">Jumlah</label>

        <input type="number" name="jumlah" class="form-control mb-3" min="1" required>

        <button type="submit" name="transaksi" class="btn btn-primary">
            Simpan Transaksi
        </button>

    </form>

<?php } elseif ($hal == 'laporan') { ?>

    <h3>Laporan Transaksi</h3>

    <table class="table table-bordered">

        <thead class="table-primary">
            <tr>
                <th>No</th>
                <th>Faktur</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($laporan as $i => $r) { ?>

            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($r['no_faktur']) ?></td>
                <td><?= $r['tanggal'] ?></td>
                <td><?= htmlspecialchars($r['nama']) ?></td>
                <td>Rp<?= number_format($r['total']) ?></td>
            </tr>

            <?php } ?>

            <?php if (count($laporan) == 0) { ?>
            <tr>
                <td colspan="5" class="text-center">Belum ada transaksi.</td>
            </tr>
            <?php } ?>

        </tbody>
    </table>

<?php } ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
