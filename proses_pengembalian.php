<?php
session_start();
include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bukuid'])) {
    $bukuid = intval($_POST['bukuid']);
    $userid = $_SESSION['userid'];
    $tanggalpengembalian = date('Y-m-d'); // Tanggal pengembalian diisi dengan tanggal saat ini

    // Update status dan tanggal pengembalian
    $queryUpdate = "UPDATE labib_peminjaman 
                    SET statuspengembalian = 'sudah dikembalikan', tanggalpengembalian = ? 
                    WHERE bukuid = ? AND userid = ? AND statuspengembalian = 'belum dikembalikan'";

    $stmt = $conn->prepare($queryUpdate);
    $stmt->bind_param("sii", $tanggalpengembalian, $bukuid, $userid);

    if ($stmt->execute()) {
        echo "<script>alert('Buku berhasil dikembalikan!'); window.location.href='buku_pinjaman.php';</script>";
    } else {
        echo "<script>alert('Gagal mengembalikan buku.'); window.location.href='buku_pinjaman.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Akses tidak valid.'); window.location.href='buku_pinjaman.php';</script>";
}

$conn->close();
?>