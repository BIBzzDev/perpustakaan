<?php
if (!defined('INDEX')) die("Forbidden");


if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID peminjaman tidak ditemukan.");
}

$id = intval($_GET['id']); 

$query = "SELECT * FROM labib_peminjaman WHERE peminjamanid = $id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    die("Data peminjaman tidak ditemukan.");
}


$deleteQuery = "DELETE FROM labib_peminjaman WHERE peminjamanid = $id";
if (mysqli_query($conn, $deleteQuery)) {
    echo "<script>alert('Data peminjaman berhasil dihapus.'); window.location.href='?hal=peminjaman';</script>";
} else {
    die("Gagal menghapus data: " . mysqli_error($conn));
}
?>