<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=rekap_penjualan.xls");

include 'koneksi.php';

$mulai = date('Y-m-d', strtotime($_GET['tanggal_mulai']));
$selesai = date('Y-m-d', strtotime($_GET['tanggal_selesai']));

$data = mysqli_query($koneksi, "SELECT DATE(waktu_transaksi), SUM(total) FROM transaksi WHERE waktu_transaksi BETWEEN '$mulai' AND '$selesai' GROUP BY DATE(waktu_transaksi) ORDER BY DATE(waktu_transaksi) ASC");
?>
<h3>Rekap Laporan Penjualan <?= $mulai ?> sampai <?= $selesai ?></h3>
<table border="1">
  <tr><th>No</th><th>Total Pendapatan</th><th>Tanggal Transaksi</th></tr>
  <?php $no = 1; while ($r = mysqli_fetch_row($data)) { ?>
  <tr>
    <td><?= $no++ ?></td>
    <td><?= $r[1] ?></td>
    <td><?= $r[0] ?></td>
  </tr>
  <?php } ?>
</table>
