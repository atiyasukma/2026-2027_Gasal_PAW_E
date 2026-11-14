<?php
include 'koneksi.php';

$mulai = '';
$selesai = '';
$labels = [];
$data_total = [];

if (!empty($_GET['tanggal_mulai']) && !empty($_GET['tanggal_selesai'])) {
    $mulai = date('Y-m-d', strtotime($_GET['tanggal_mulai']));
    $selesai = date('Y-m-d', strtotime($_GET['tanggal_selesai']));

    $data = mysqli_query($koneksi, "SELECT DATE(waktu_transaksi), SUM(total) FROM transaksi WHERE waktu_transaksi BETWEEN '$mulai' AND '$selesai' GROUP BY DATE(waktu_transaksi) ORDER BY DATE(waktu_transaksi) ASC");
    while ($r = mysqli_fetch_row($data)) {
        $labels[] = $r[0];
        $data_total[] = (int)$r[1];
    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<h2>Laporan Penjualan</h2>
<form method="get">
  Tanggal Mulai: <input type="date" name="tanggal_mulai" value="<?= $mulai ?>" required>
  Tanggal Selesai: <input type="date" name="tanggal_selesai" value="<?= $selesai ?>" required>
  <button type="submit">Tampilkan</button>
</form>

<?php if (!empty($labels)) { ?>
  <h3>Grafik Penjualan <?= $mulai ?> sampai <?= $selesai ?></h3>
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
<?php } elseif ($mulai != '') { ?>
  <p>Tidak ada transaksi pada rentang tanggal tersebut.</p>
<?php } ?>
