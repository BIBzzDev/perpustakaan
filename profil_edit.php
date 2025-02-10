<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit;
}

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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_info'])) {
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $namalengkap = htmlspecialchars($_POST['namalengkap']);
        $alamat = htmlspecialchars($_POST['alamat']);

        $update_sql = "UPDATE labib_user SET username=?, email=?, namalengkap=?, alamat=? WHERE userid=?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssssi", $username, $email, $namalengkap, $alamat, $userid);

        if ($update_stmt->execute()) {
            echo "<script>alert('Profil berhasil diperbarui!'); window.location.href='profil.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan, coba lagi.');</script>";
        }
    }

    if (isset($_POST['update_photo']) && isset($_FILES['profile_photo'])) {
        $target_dir = "asset/pp/";
        $file_name = basename($_FILES["profile_photo"]["name"]);
        $target_file = $target_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ["jpg", "jpeg", "png"];

        if (in_array($file_type, $allowed_types)) {
            if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
                $update_photo_sql = "UPDATE labib_user SET pp=? WHERE userid=?";
                $update_photo_stmt = $conn->prepare($update_photo_sql);
                $update_photo_stmt->bind_param("si", $file_name, $userid);

                if ($update_photo_stmt->execute()) {
                    echo "<script>alert('Foto profil berhasil diubah!'); window.location.href='profil.php';</script>";
                } else {
                    echo "<script>alert('Gagal mengupdate foto profil.');</script>";
                }
            } else {
                echo "<script>alert('Gagal mengupload file.');</script>";
            }
        } else {
            echo "<script>alert('Hanya format JPG, JPEG, dan PNG yang diperbolehkan.');</script>";
        }
    }
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

    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="profile-card p-5 rounded-4 shadow-lg">
                        <div class="text-center mb-4">
                            <img src="asset/pp/<?php echo htmlspecialchars($user['pp']); ?>" alt="Foto Profil" class="profile-img">
                        </div>

                        <!-- Form Ganti Foto Profil -->
                        <form method="POST" enctype="multipart/form-data" class="text-center mb-4">
                            <input type="file" name="profile_photo" required>
                            <button type="submit" name="update_photo" class="btn btn-custom mt-2">Ubah Foto Profil</button>
                        </form>

                        <h3 class="text-center mb-4 text-red fw-bold">Profil Pengguna</h3>
                        
                        <!-- Form Edit Profil -->
                        <form method="POST">
                            <div class="mb-3">
                                <label class="text-red">Username:</label>
                                <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="text-red">Email:</label>
                                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="text-red">Nama Lengkap:</label>
                                <input type="text" name="namalengkap" class="form-control" value="<?php echo htmlspecialchars($user['namalengkap']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="text-red">Alamat:</label>
                                <input type="text" name="alamat" class="form-control" value="<?php echo htmlspecialchars($user['alamat']); ?>" required>
                            </div>
                            <button type="submit" name="update_info" class="btn btn-custom w-100">Simpan Perubahan</button>
                        </form>
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