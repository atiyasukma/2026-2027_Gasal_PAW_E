<?php
include 'koneksi.php';

$mulai = '';
$selesai = '';
$labels = [];
$data_total = [];
$ringkasan = [0, 0];

if (!empty($_GET['tanggal_mulai']) && !empty($_GET['tanggal_selesai'])) {
    $mulai = date('Y-m-d', strtotime($_GET['tanggal_mulai']));
    $selesai = date('Y-m-d', strtotime($_GET['tanggal_selesai']));

    // total pendapatan per hari
    $data = mysqli_query($koneksi, "SELECT DATE(waktu_transaksi), SUM(total) FROM transaksi WHERE waktu_transaksi BETWEEN '$mulai' AND '$selesai' GROUP BY DATE(waktu_transaksi) ORDER BY DATE(waktu_transaksi) ASC");
    while ($r = mysqli_fetch_row($data)) {
        $labels[] = $r[0];
        $data_total[] = (int)$r[1];
    }

    $ringkasan = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(DISTINCT pelanggan_id), SUM(total) FROM transaksi WHERE waktu_transaksi BETWEEN '$mulai' AND '$selesai'"));
}
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
  @media print { .no-print { display: none !important; } }
</style>

<h2>Laporan Penjualan</h2>
<form method="get" class="no-print">
  Tanggal Mulai: <input type="date" name="tanggal_mulai" value="<?= $mulai ?>" required>
  Tanggal Selesai: <input type="date" name="tanggal_selesai" value="<?= $selesai ?>" required>
  <button type="submit">Tampilkan</button>
</form>

<?php if (!empty($labels)) { ?>
  <!-- SOAL 4: tombol Cetak dan Excel -->
  <div class="no-print">
    <br>
    <button onclick="window.print()">Cetak</button>
    <button onclick="location.href='export_excel.php?tanggal_mulai=<?= $mulai ?>&tanggal_selesai=<?= $selesai ?>'">Excel</button>
  </div>

  <h3>Rekap Laporan Penjualan <?= $mulai ?> sampai <?= $selesai ?></h3>

  <div style="width: 600px; height: 300px;"><canvas id="myChart"></canvas></div>
  <script>
    new Chart(document.getElementById('myChart'), {
      type: 'bar',
      data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{ label: 'Total Pendapatan', data: <?= json_encode($data_total) ?> }]
      },
      options: {
        scales: {
          x: { title: { display: true, text: 'Tanggal Transaksi' } },
          y: { beginAtZero: true, title: { display: true, text: 'Total Pendapatan (Rp)' } }
        }
      }
    });
  </script>

  <h3>Rekapitulasi</h3>
  <table border="1" cellpadding="5" width="600">
    <tr><th>No</th><th>Total Pendapatan</th><th>Tanggal Transaksi</th></tr>
    <?php foreach ($labels as $i => $tanggal) { ?>
    <tr>
      <td><?= $i + 1 ?></td>
      <td>Rp. <?= number_format($data_total[$i], 0, ',', '.') ?></td>
      <td><?= $tanggal ?></td>
    </tr>
    <?php } ?>
  </table>

  <br>
  <div style="border: 1px solid #000; padding: 10px; width: 580px;">
    <b>Jumlah Pelanggan Unik:</b> <?= $ringkasan[0] ?> Orang<br>
    <b>Total Pendapatan Keseluruhan:</b> Rp. <?= number_format($ringkasan[1], 0, ',', '.') ?>
  </div>
<?php } elseif ($mulai != '') { ?>
  <p>Tidak ada transaksi pada rentang tanggal tersebut.</p>
<?php } ?>
