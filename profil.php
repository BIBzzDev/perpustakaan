<?php
include 'includes/db.php';

session_start();
$userid = $_SESSION['userid'];

$sql = "SELECT * FROM labib_user WHERE userid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User tidak ditemukan.";
    exit;
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
    <title>Profil Pengguna</title>

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
        .profile-card {
            background: #1f1f2e;
            color: white;
        }
        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid #e63946;
        }
        .btn-custom {
            background-color: #e63946;
            color: white;
            transition: all 0.3s ease-in-out;
        }
        .btn-custom:hover {
            background-color: #c92c3a;
        }
        .text-red {
            color: #e63946;
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
 
    <!-- Header End -->

    <!-- Breadcrumb -->
    <section class="normal-breadcrumb set-bg" data-setbg="img/normal-breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>Profil Pengguna</h2>
                        <p>Selamat datang di halaman profil Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
   
    
    <!-- Profil -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="profile-card p-5 rounded-4 shadow-lg">
                        
                        <!-- Foto Profil -->
                        <div class="text-center mb-4">
                            <img src="asset/pp/<?php echo htmlspecialchars($user['pp']); ?>" alt="Foto Profil" class="profile-img">
                        </div>

                        <!-- Informasi Profil -->
                        <h3 class="text-center mb-4 text-red fw-bold">Profil Pengguna</h3>
                        <table class="table text-white">
                            <tr>
                                <th class="text-end text-red" style="width: 30%;">Username:</th>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                            </tr>
                            <tr>
                                <th class="text-end text-red">Email:</th>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                            </tr>
                            <tr>
                                <th class="text-end text-red">Nama Lengkap:</th>
                                <td><?php echo htmlspecialchars($user['namalengkap']); ?></td>
                            </tr>
                            <tr>
                                <th class="text-end text-red">Alamat:</th>
                                <td><?php echo htmlspecialchars($user['alamat']); ?></td>
                            </tr>
                        </table>

                        <!-- Tombol Aksi -->
                        <div class="text-center mt-4">
                            <a href="buku_pinjaman.php" class="btn btn-custom px-4 py-2 me-2">Buku Pinjaman</a>
                            <a href="buku_koleksi.php" class="btn btn-custom px-4 py-2">Koleksi Pribadi</a>
<a href="profil_edit.php" class="btn btn-custom px-4 py-2">Edit Profil</a>
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