<?php
session_start();


if (!isset($_SESSION['userid'])) {
    header("Location: login.html");
    exit();
}

$email = $_SESSION['email'];

include('includes/db.php');

$queryBukuTerbaru = "SELECT labib_buku.*, 
                             GROUP_CONCAT(labib_kategoribuku.namakategori SEPARATOR ', ') AS kategori 
                      FROM labib_buku
                      LEFT JOIN labib_kategoribuku_relasi ON labib_buku.bukuid = labib_kategoribuku_relasi.bukuid
                      LEFT JOIN labib_kategoribuku ON labib_kategoribuku_relasi.kategoriid = labib_kategoribuku.kategoriid
                      GROUP BY labib_buku.bukuid
                      ORDER BY labib_buku.bukuid DESC
                      LIMIT 10";

$resultBukuTerbaru = mysqli_query($conn, $queryBukuTerbaru);

if (!$resultBukuTerbaru) {
    die("Query Error: " . mysqli_error($conn));
}

$queryBukuFiksi = "SELECT labib_buku.*, 
                           GROUP_CONCAT(labib_kategoribuku.namakategori SEPARATOR ', ') AS kategori 
                    FROM labib_buku
                    LEFT JOIN labib_kategoribuku_relasi ON labib_buku.bukuid = labib_kategoribuku_relasi.bukuid
                    LEFT JOIN labib_kategoribuku ON labib_kategoribuku_relasi.kategoriid = labib_kategoribuku.kategoriid
                    WHERE labib_kategoribuku.namakategori = 'fiksi'
                    GROUP BY labib_buku.bukuid
                    ORDER BY labib_buku.bukuid DESC
                    LIMIT 6";

$resultBukuFiksi = mysqli_query($conn, $queryBukuFiksi);

if (!$resultBukuFiksi) {
    die("Query Error: " . mysqli_error($conn));
}


$queryBukuPembelajaran = "SELECT labib_buku.*, 
                           GROUP_CONCAT(labib_kategoribuku.namakategori SEPARATOR ', ') AS kategori 
                    FROM labib_buku
                    LEFT JOIN labib_kategoribuku_relasi ON labib_buku.bukuid = labib_kategoribuku_relasi.bukuid
                    LEFT JOIN labib_kategoribuku ON labib_kategoribuku_relasi.kategoriid = labib_kategoribuku.kategoriid
                    WHERE labib_kategoribuku.namakategori = 'pembelajaran'
                    GROUP BY labib_buku.bukuid
                    ORDER BY labib_buku.bukuid DESC
                    LIMIT 6";

$resultBukuPembelajaran = mysqli_query($conn, $queryBukuPembelajaran);

if (!$resultBukuPembelajaran) {
    die("Query Error: " . mysqli_error($conn));
}
?>



<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Perpustakaan">
    <meta name="keywords" content="Buku, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Perpustakaan</title>

   
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/plyr.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>

    <div id="preloder">
        <div class="loader"></div>
    </div>

    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="index.php">
                            <img src="asset/logo.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="header__nav">
                        <nav class="header__menu mobile-menu">
                            <ul>
                                <li class="active"><a href="index.php">Home</a></li>
                                <li><a href="koleksi_pribadi.php">Koleksi Pribadi</a></li>
                                <li><a href="buku_pinjam.php">Buku Yang Di Pinjam</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="header__right">
                        <a href="./profil.php"><span class="icon_profile"></span></a>
                        <a href="./logout.php" title="Logout"><i class="fas fa-sign-out-alt"></i></a>
                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <div class="hero__slider owl-carousel">
                <div class="hero__items set-bg" data-setbg="asset/cover/1739125922_1737381547_algoritma_20250120_205716_1.png">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="hero__text">
                                <div class="label">Populer</div>
                                <h2>algoritma Pemograman c++</h2>
                                <p>After 30 days of travel across the world...</p>
                                <a href="#"><span>Baca Sekarang</span> <i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero__items set-bg" data-setbg="asset/cover/lookism.jpeg">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="hero__text">
                                <div class="label">Manhwa</div>
                                <h2>Lookism</h2>
                                <p>After 30 days of travel across the world...</p>
                                <a href="#"><span>Baca Sekarang</span> <i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero__items set-bg" data-setbg="asset/cover/1739128881_thumbnail.jpg">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="hero__text">
                                <div class="label">Adventure</div>
                                <h2>Date With Tia</h2>
                                <p>After 30 days of travel across the world...</p>
                                <a href="#"><span>Baca Sekarang</span> <i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="product spad">
        <div class="container">
            <div class="section-title">
                <h4>Buku Terbaru</h4>
            </div>
            <div class="row">
                <?php
                if ($resultBukuTerbaru->num_rows > 0) {
                    while ($row = $resultBukuTerbaru->fetch_assoc()) {
                        $judul = $row['judul'];
                        $cover = $row['cover'];
                        $bukuid = $row['bukuid'];
                        $kategori = $row['kategori'];
                ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="asset/cover/<?php echo $cover; ?>"></div>
                            <div class="product__item__text">
                                <ul>
                                    <li><?php echo !empty($kategori) ? htmlspecialchars($kategori) : "Tidak ada kategori"; ?></li>
                                </ul>
                                <h5><a href="buku_detail.php?bukuid=<?php echo $bukuid; ?>"><?php echo $judul; ?></a></h5>
                            </div>
                        </div>
                    </div>
                <?php
                    }
                } else {
                    echo "<p>Tidak ada buku terbaru ditemukan.</p>";
                }
                ?>
            </div>

            <div class="section-title">
                <h4>Buku Kategori Fiksi</h4>
            </div>
            <div class="row">
                <?php
                if ($resultBukuFiksi->num_rows > 0) {
                    while ($row = $resultBukuFiksi->fetch_assoc()) {
                        $judul = $row['judul'];
                        $cover = $row['cover'];
                        $bukuid = $row['bukuid'];
                        $kategori = $row['kategori'];
                ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="asset/cover/<?php echo $cover; ?>"></div>
                            <div class="product__item__text">
                                <ul>
                                    <li><?php echo !empty($kategori) ? htmlspecialchars($kategori) : "Tidak ada kategori"; ?></li>
                                </ul>
                                <h5><a href="buku_detail.php?bukuid=<?php echo $bukuid; ?>"><?php echo $judul; ?></a></h5>
                            </div>
                        </div>
                    </div>
                <?php
                    }
                } else {
                    echo "<p>Tidak ada buku kategori fiksi ditemukan.</p>";
                }
                ?>
            </div>

<div class="section-title">
                <h4>Buku Kategori Pembelajaran</h4>
            </div>
            <div class="row">
                <?php
                if ($resultBukuPembelajaran->num_rows > 0) {
                    while ($row = $resultBukuPembelajaran->fetch_assoc()) {
                        $judul = $row['judul'];
                        $cover = $row['cover'];
                        $bukuid = $row['bukuid'];
                        $kategori = $row['kategori'];
                ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="asset/cover/<?php echo $cover; ?>"></div>
                            <div class="product__item__text">
                                <ul>
                                    <li><?php echo !empty($kategori) ? htmlspecialchars($kategori) : "Tidak ada kategori"; ?></li>
                                </ul>
                                <h5><a href="buku_detail.php?bukuid=<?php echo $bukuid; ?>"><?php echo $judul; ?></a></h5>
                            </div>
                        </div>
                    </div>
                <?php
                    }
                } else {
                    echo "<p>Tidak ada buku kategori fiksi ditemukan.</p>";
                }
                ?>
            </div>
        </div>
    </section>

    <?php $conn->close(); ?>
<footer class="footer">
    <div class="page-up">
        <a href="#" id="scrollToTopButton"><span class="arrow_carrot-up"></span></a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="footer__logo">
                    <a href="./index.php"><img src="asset/logo.png" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="footer__nav">
                    <ul>
                        <li class="active"><a href="index.php">Home</a></li>
                        <li><a href="buku_pinjaman.php">Buku Pinjaman</a></li>
                        <li><a href="buku_koleksi.php">koleksi pribadi</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3">
                <p>
                  Copyright &copy;<script>document.write(new Date().getFullYear());</script> Muhammad Labib All rights reserved</a></p>

              </div>
          </div>
      </div>
  </footer>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/player.js"></script>
<script src="js/jquery.nice-select.min.js"></script>
<script src="js/mixitup.min.js"></script>
<script src="js/jquery.slicknav.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/main.js"></script>


</body>

</html>