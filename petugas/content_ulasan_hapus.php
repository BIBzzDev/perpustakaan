<?php
if (!defined('INDEX')) die("Forbidden");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID ulasan tidak valid.");
}

$ulasanid = intval($_GET['id']);

$query = "DELETE FROM labib_ulasanbuku WHERE ulasanid = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $ulasanid);
    $execute = mysqli_stmt_execute($stmt);

    if ($execute) {
        $_SESSION['message'] = "Ulasan berhasil dihapus.";
    } else {
        $_SESSION['message'] = "Gagal menghapus ulasan.";
    }

    mysqli_stmt_close($stmt);
} else {
    $_SESSION['message'] = "Terjadi kesalahan dalam query.";
}

mysqli_close($conn);
header("Location: ?hal=ulasan");
exit();
?>