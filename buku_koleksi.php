<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: login.html");
    exit();
}

$userid = $_SESSION['userid'];
include('includes/db.php');

$queryKoleksi = "
    SELECT 
        b.bukuid, 
        b.judul, 
        b.penulis, 
        b.penerbit, 
        b.tahunterbit, 
        b.cover, 
        GROUP_CONCAT(DISTINCT kb.namakategori SEPARATOR ', ') AS kategori
    FROM labib_buku b
    LEFT JOIN labib_koleksipribadi k ON b.bukuid = k.bukuid 
        AND k.userid = $userid
    LEFT JOIN labib_kategoribuku_relasi kr ON b.bukuid = kr.bukuid
    LEFT JOIN labib_kategoribuku kb ON kr.kategoriid = kb.kategoriid
    WHERE k.userid IS NOT NULL
    GROUP BY b.bukuid, b.judul, b.penulis, b.penerbit, b.tahunterbit, b.cover;
";

$resultKoleksi = mysqli_query($conn, $queryKoleksi);

if (!$resultKoleksi) {
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
                            <li><a href="index.php">Home</a></li>
                            <li class="active"><a href="koleksi_pribadi.php">Koleksi Pribadi</a></li>
                            <li><a href="buku_pinjam.php">Buku Yang Dipinjam</a></li>
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

<section class="product-page spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="product__page__content">
                    <div class="product__page__title">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-6">
                                <div class="section-title">
                                    <h4>Koleksi Pribadi</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
    <?php
    if ($resultKoleksi->num_rows > 0) {
        while ($row = $resultKoleksi->fetch_assoc()) {
            $judul = $row['judul'];
            $cover = $row['cover'];
            $bukuid = $row['bukuid'];
            $kategori = $row['kategori'];
    ?>
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="product__item">
                <div class="product__item__pic set-bg" data-setbg="asset/cover/<?php echo $cover; ?>">
                </div>
                <div class="product__item__text">
                    <ul>
                        <?php if (!empty($kategori)) { ?>
                            <li><?php echo htmlspecialchars($kategori); ?></li>
                        <?php } else { ?>
                            <li>Tidak ada kategori</li>
                        <?php } ?>
                    </ul>
                    <h5><a href="baca_buku.php?bukuid=<?php echo $bukuid; ?>"><?php echo $judul; ?></a></h5>
                    
                    <form action="proses_hapus_koleksi.php" method="POST">
                        <input type="hidden" name="bukuid" value="<?php echo $bukuid; ?>">
                        <button type="submit" class="btn btn-danger">Hapus dari Koleksi</button>
                    </form>

                </div>
            </div>
        </div>
    <?php
        }
    } else {
        echo "<p>Tidak ada buku dalam koleksi pribadi.</p>";
    }
    ?>
</div>
                </div>
            </div>
        </div>
    </div>
</section>

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
</div>


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