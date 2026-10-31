<?php
include 'koneksi.php';

if (isset($_POST['update'])) {
    $id     = $_POST['id'];
    $nama   = $_POST['nama'];
    $telp   = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $sql_update = "UPDATE supplier SET nama='$nama', telp='$telp', alamat='$alamat' WHERE id=$id";
    
    if (mysqli_query($conn, $sql_update)) {
        header("Location: Tugas-3.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$id = isset($_GET['id']) ? $_GET['id'] : '';

$data = [
    'id'     => '',
    'nama'   => '',
    'telp'   => '',
    'alamat' => ''
];

if (!empty($id)) {
    $sql = "SELECT * FROM supplier WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Master Supplier</title>
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

    <h4>Edit Data Master Supplier</h4>

    <form action="Tugas-5.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

        <table>
            <tr>
                <td align="right"><label><b>Nama</b></label></td>
                <td><input type="text" name="nama" value="<?php echo $data['nama']; ?>" required size="30"></td>
            </tr>
            <tr>
                <td align="right"><label><b>Telp</b></label></td>
                <td><input type="text" name="telp" value="<?php echo $data['telp']; ?>" required size="20"></td>
            </tr>
            <tr>
                <td align="right"><label><b>Alamat</b></label></td>
                <td><input type="text" name="alamat" value="<?php echo $data['alamat']; ?>" required size="20"></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit" name="update" class="btn-simpan">Update</button>
                    <a href="Tugas-3.php"><button type="button" class="btn-batal">Batal</button></a>
                </td>
            </tr>
        </table>
    </form>

</body>
</html>
<?php mysqli_close($conn); ?>