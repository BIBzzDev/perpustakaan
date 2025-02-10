<?php
if (!defined('INDEX')) die("Forbidden");


if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID pengguna tidak ditemukan.");
}

$id = intval($_GET['id']);

$query = "SELECT * FROM labib_user WHERE userid = $id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    die("Pengguna tidak ditemukan.");
}

$user = mysqli_fetch_assoc($result);


if ($user['pp'] !== 'default.jpg') {
    @unlink("../asset/pp/" . $user['pp']);
}


$deleteQuery = "DELETE FROM labib_user WHERE userid = $id";
if (mysqli_query($conn, $deleteQuery)) {
    echo "<script>alert('Data pengguna berhasil dihapus.'); window.location.href='?hal=user';</script>";
} else {
    die("Gagal menghapus data: " . mysqli_error($conn));
}
?>