<?php
include 'koneksi.php';

$mulai = '';
$selesai = '';
$data = null;

if (!empty($_GET['tanggal_mulai']) && !empty($_GET['tanggal_selesai'])) {
    $mulai = date('Y-m-d', strtotime($_GET['tanggal_mulai']));
    $selesai = date('Y-m-d', strtotime($_GET['tanggal_selesai']));

    $data = mysqli_query($koneksi, "SELECT transaksi.id, transaksi.waktu_transaksi, pelanggan.nama, transaksi.keterangan, transaksi.total FROM transaksi JOIN pelanggan ON pelanggan.id = transaksi.pelanggan_id WHERE transaksi.waktu_transaksi BETWEEN '$mulai' AND '$selesai' ORDER BY transaksi.waktu_transaksi");
}
?>
<h2>Laporan Penjualan</h2>
<form method="get">
  Tanggal Mulai: <input type="date" name="tanggal_mulai" value="<?= $mulai ?>" required>
  Tanggal Selesai: <input type="date" name="tanggal_selesai" value="<?= $selesai ?>" required>
  <button type="submit">Tampilkan</button>
</form>

<?php if ($data) { ?>
  <h3>Transaksi <?= $mulai ?> sampai <?= $selesai ?></h3>
  <?php if (mysqli_num_rows($data) == 0) { ?>
    <p>Tidak ada transaksi pada rentang tanggal tersebut.</p>
  <?php } else { ?>
    <table border="1" cellpadding="5">
      <tr><th>ID</th><th>Tanggal</th><th>Pelanggan</th><th>Keterangan</th><th>Total</th></tr>
      <?php while ($r = mysqli_fetch_assoc($data)) { ?>
      <tr>
        <td><?= $r['id'] ?></td>
        <td><?= $r['waktu_transaksi'] ?></td>
        <td><?= $r['nama'] ?></td>
        <td><?= $r['keterangan'] ?></td>
        <td><?= $r['total'] ?></td>
      </tr>
      <?php } ?>
    </table>
  <?php } ?>
<?php } ?>
