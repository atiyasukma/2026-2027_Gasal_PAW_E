<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM supplier WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: Tugas-3.php");
        exit();
    } else {
        echo "Error menghapus data: " . mysqli_error($conn);
    }
} else {
    header("Location: Tugas-3.php");
    exit();
}

mysqli_close($conn);
?>