<?php
include 'koneksi.php';

$sql = "SELECT * FROM supplier";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Master Supplier</title>
    <style>
        /*Warna Judul*/
        h3 {
            color: #87CEEB;
        }

        /*Warna Header Tabel*/
        th {
            background-color: #E0FFFF;
        }

        /*Styling Tombol*/
        button {
            border: none;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-tambah {
            background-color: #6aa84f;
            float: right;
        }

        .btn-edit {
            background-color: #e69138;
        }

        .btn-hapus {
            background-color: #cc0000;
        }
    </style>
</head>
<body>

    <a href="Tugas-4.php"><button class="btn-tambah">Tambah Data</button></a>
    <h3>Data Master Supplier</h3>

    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Telp</th>
                <th>Alamat</th>
                <th>Tindakan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . $row['nama'] . "</td>";
                    echo "<td>" . $row['telp'] . "</td>";
                    echo "<td>" . $row['alamat'] . "</td>";
                    echo "<td>
                            <a href='Tugas-5.php?id=" . $row['id'] . "'><button class='btn-edit'>Edit</button></a>
                            <a href='Tugas-6.php?id=" . $row['id'] . "' onclick=\"return confirm('Anda yakin akan menghapus supplier ini?');\"><button class='btn-hapus'>Hapus</button></a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Data tidak ditemukan</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
<?php mysqli_close($conn); ?>