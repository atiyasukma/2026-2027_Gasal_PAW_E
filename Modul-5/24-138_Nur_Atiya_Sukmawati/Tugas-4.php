<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $nama   = $_POST['nama'];
    $telp   = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $sql = "INSERT INTO supplier (nama, telp, alamat) VALUES ('$nama', '$telp', '$alamat')";

    if (mysqli_query($conn, $sql)) {
        header("Location: Tugas-3.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Master Supplier Baru</title>
    <style>
        h4 {
            color: #87CEEB;
            margin-bottom: 20px;
        }
        td {
            padding: 8px;
        }

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

        .btn-simpan {
            background-color: #6aa84f;
        }

        .btn-batal {
            background-color: #cc0000;
        }
    </style>
</head>
<body>

    <h4>Tambah Data Master Supplier Baru</h4>

    <form action="" method="POST">
        <table>
            <tr>
                <td align="right"><label><b>Nama</b></label></td>
                <td><input type="text" name="nama" placeholder="Nama" required size="30"></td>
            </tr>
            <tr>
                <td align="right"><label><b>Telp</b></label></td>
                <td><input type="text" name="telp" placeholder="telp" required size="20"></td>
            </tr>
            <tr>
                <td align="right"><label><b>Alamat</b></label></td>
                <td><input type="text" name="alamat" placeholder="alamat" required size="20"></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit" name="simpan" class="btn-simpan">Simpan</button>
                    <a href="Tugas-3.php"><button type="button" class="btn-batal">Batal</button></a>
                </td>
            </tr>
        </table>
    </form>

</body>
</html>
<?php mysqli_close($conn); ?>