<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: login.html");
    exit();
}

$email = $_SESSION['email'];
include('includes/db.php');

$bukuid = $_GET['bukuid'] ?? null;
$pdf_file = '';
$judul_buku = '';

if ($bukuid) {
    $query = "SELECT judul, bukupdf FROM labib_buku WHERE bukuid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $bukuid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $judul_buku = $row['judul'];
        $pdf_file = 'asset/buku/' . $row['bukupdf'];
    } else {
        echo "Buku tidak ditemukan.";
        exit;
    }
} else {
    echo "Parameter bukuid tidak valid.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Viewer - <?= htmlspecialchars($judul_buku) ?></title>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.8.162/pdf.min.js"></script>

    <style>
        #pdf-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    max-width: 100%; 
    margin: 0 auto;
    padding: 10px;
    background-color: #102A43;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    overflow-x: auto;
}

canvas {
    width: 100% !important;
    height: auto !important;
    margin-bottom: 10px;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

        .loader {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            display: none;
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

    <!-- Section untuk PDF Viewer -->
    <section class="container mt-4">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="text-center text-white"><?= htmlspecialchars($judul_buku) ?></h2>
                <div class="loader" id="loader">
                    <div class="spinner-border text-light" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div id="pdf-container"></div>
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

    <script>
        const url = '<?= $pdf_file; ?>';
        const container = document.getElementById('pdf-container');
        const loader = document.getElementById('loader');

        loader.style.display = 'block';

        const renderPDF = async (url) => {
            try {
                const pdf = await pdfjsLib.getDocument(url).promise;
                loader.style.display = 'none';

                for (let i = 1; i <= pdf.numPages; i++) {
                    const page = await pdf.getPage(i);
                    const viewport = page.getViewport({ scale: 2 });
                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');

                    canvas.width = viewport.width;
                    canvas.height = viewport.height;

                    container.appendChild(canvas);

                    await page.render({
                        canvasContext: context,
                        viewport: viewport
                    }).promise;
                }
            } catch (error) {
                console.error('Gagal memuat PDF:', error);
                loader.style.display = 'none';
                container.innerHTML = '<p class="text-center text-danger">Gagal memuat PDF. Pastikan file tersedia.</p>';
            }
        };

        renderPDF(url);
    </script>

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