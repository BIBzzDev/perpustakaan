<?php
session_start();
include('includes/db.php');


if (!isset($_SESSION['userid'])) {
    header("Location: login.html");
    exit();
}


if (!isset($_GET['bukuid']) || !is_numeric($_GET['bukuid'])) {
    echo "<script>alert('ID buku tidak valid!'); window.location='index.php';</script>";
    exit();
}

$bukuid = intval($_GET['bukuid']);


$query = "SELECT * FROM labib_buku WHERE bukuid = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'i', $bukuid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $buku = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Data buku tidak ditemukan!'); window.location='index.php';</script>";
        exit();
    }

    mysqli_stmt_close($stmt);
} else {
    error_log("Query Error: " . mysqli_error($conn));
    echo "<script>alert('Terjadi kesalahan pada database!'); window.location='index.php';</script>";
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['ulasan']) && isset($_POST['rating'])) {
        $ulasan = htmlspecialchars(trim($_POST['ulasan']), ENT_QUOTES, 'UTF-8');
        $rating = intval($_POST['rating']);
        $userid = $_SESSION['userid'];
        $tanggal = date('Y-m-d');

        $query = "INSERT INTO labib_ulasanbuku (userid, bukuid, ulasan, rating, tanggal) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'iisis', $userid, $bukuid, $ulasan, $rating, $tanggal);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Ulasan berhasil dikirim!'); window.location='buku_detail.php?bukuid=$bukuid';</script>";
            } else {
                error_log("Error: " . mysqli_stmt_error($stmt));
                echo "<script>alert('Gagal mengirim ulasan, coba lagi!');</script>";
            }

            mysqli_stmt_close($stmt);
        } else {
            error_log("Query Error: " . mysqli_error($conn));
            echo "<script>alert('Kesalahan pada database!');</script>";
        }
    } else {
        echo "<script>alert('Mohon isi semua bidang!');</script>";
    }
}


$query = "
    SELECT ulasanbuku.*, user.username, user.pp 
    FROM labib_ulasanbuku ulasanbuku
    LEFT JOIN labib_user user ON ulasanbuku.userid = user.userid
    WHERE ulasanbuku.bukuid = ?
    ORDER BY ulasanbuku.ulasanid DESC 
    LIMIT 6
";

$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'i', $bukuid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $ulasan_list = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $ulasan_list[] = $row;
    }

    mysqli_stmt_close($stmt);
} else {
    error_log("Query Error: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Anime Template">
    <meta name="keywords" content="Anime, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Buku</title>
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

<style>
    .rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: start;
    }
    .rating input {
        display: none;
    }
    .rating label {
        font-size: 2rem;
        color: #ccc;
        cursor: pointer;
        transition: color 0.2s;
    }
    .rating input:checked ~ label {
        color: #ffcc00;
    }
    .rating label:hover,
    .rating label:hover ~ label {
        color: #ffcc00;
    }
</style>

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

    <section class="anime-details spad">
        <div class="container">
            <div class="anime__details__content">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="anime__details__pic set-bg" data-setbg="asset/cover/<?php echo htmlspecialchars($buku['cover']); ?>"></div>
                    </div>
                    <div class="col-lg-9">
                        <div class="anime__details__text">
                            <div class="anime__details__title">
                                <h3><?php echo htmlspecialchars($buku['judul']); ?></h3>
                            </div>
                            <div class="anime__details__widget">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li><span>Penulis:</span> <?php echo htmlspecialchars($buku['penulis']); ?></li>
                                            <li><span>Penerbit:</span> <?php echo htmlspecialchars($buku['penerbit']); ?></li>
                                            <li><span>Tahun Terbit:</span> <?php echo htmlspecialchars($buku['tahunterbit']); ?></li>
                                        </ul>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="anime__details__btn">
                                <a href="peminjaman.php?bukuid=<?php echo $bukuid; ?>" class="follow-btn">Pinjam</a>
                                <a href="addkoleksi.php?bukuid=<?php echo $bukuid; ?>" class="follow-btn">Simpan Ke Koleksi</a>
                                <a href="baca_buku.php?bukuid=<?php echo $bukuid; ?>" class="watch-btn">
                                    <span>Baca Sekarang</span> <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                </div>


                <div class="row">
                    <div class="col-lg-8 col-md-8">
                        <div class="anime__details__review">

                            
                        <div class="section-title">
    <h5>Reviews</h5>
</div>
<?php
$stmt = mysqli_prepare($conn, $query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'i', $bukuid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($ulasan = mysqli_fetch_assoc($result)) {
        echo '<div class="anime__review__item">';

        $profilePic = !empty($ulasan['pp']) ? 'asset/pp/' . $ulasan['pp'] : 'asset/pp/placeholder.jpg';
        echo '<div class="anime__review__item__pic"><img src="' . htmlspecialchars($profilePic) . '" alt="Profile Picture"></div>';
        
        echo '<div class="anime__review__item__text">';
        echo '<h6>' . htmlspecialchars($ulasan['username']) . ' - <span>';
        
        $reviewDate = strtotime($ulasan['tanggal']); 
        echo date('F j, Y', $reviewDate); 
        
        echo '</span></h6>';
        
      
        echo '<p>' . htmlspecialchars($ulasan['ulasan']) . '</p>';
        echo '</div></div>';
    }
    mysqli_stmt_close($stmt);
} else {
    echo "<p>Failed to fetch reviews.</p>";
}
?>

                        </div>
                    </div>
                </div>

                <div class="anime__details__form">
                    <div class="section-title">
                        <h5>Your Comment</h5>
                    </div>



    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?bukuid=<?php echo $bukuid; ?>" method="POST">
    <div class="mb-3">
        <textarea name="ulasan" class="form-control" rows="5" placeholder="Your Comment" required></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label fs-5 fw-bold text-primary">Rating:</label>
        <div class="rating">
            <input type="radio" id="star5" name="rating" value="5" required /><label for="star5" class="star">&#9733;</label>
            <input type="radio" id="star4" name="rating" value="4" required /><label for="star4" class="star">&#9733;</label>
            <input type="radio" id="star3" name="rating" value="3" required /><label for="star3" class="star">&#9733;</label>
            <input type="radio" id="star2" name="rating" value="2" required /><label for="star2" class="star">&#9733;</label>
            <input type="radio" id="star1" name="rating" value="1" required /><label for="star1" class="star">&#9733;</label>
        </div>
        <div class="form-text text-muted">Please select your rating.</div>
    </div>

    <button type="submit" class="btn btn-primary"><i class="fa fa-location-arrow"></i> Submit</button>
</form>



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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</body>
</html>