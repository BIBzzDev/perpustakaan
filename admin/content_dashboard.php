<?php
if (!defined('INDEX')) die("Forbidden");


$totalUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM labib_user"))['total'];
$totalBooks = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM labib_buku"))['total'];
$totalBorrowed = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM labib_peminjaman WHERE statuspengembalian IS NULL"))['total'];
$totalCategories = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM labib_kategoribuku"))['total'];
?>

<div class="container py-5">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="text-4xl font-bold text-cyan-400">Dashboard Admin</h1>
        <p class="text-lg text-gray-300">Pantau data sistem perpustakaan secara real-time.</p>
    </div>

    <!-- Statistik -->
    <div class="row g-4">
        <div class="col-md-3">
            <div class="holo-card">
                <div class="icon"><i class="fas fa-users"></i></div>
                <h3>Total Users</h3>
                <h2><?= $totalUsers ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="holo-card">
                <div class="icon"><i class="fas fa-book"></i></div>
                <h3>Total Books</h3>
                <h2><?= $totalBooks ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="holo-card">
                <div class="icon"><i class="fas fa-book-reader"></i></div>
                <h3>Borrowed Books</h3>
                <h2><?= $totalBorrowed ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="holo-card">
                <div class="icon"><i class="fas fa-tags"></i></div>
                <h3>Total Categories</h3>
                <h2><?= $totalCategories ?></h2>
            </div>
        </div>
    </div>