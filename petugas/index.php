<?php
session_start();

include "config.php";
define('INDEX', true);


if (!isset($_SESSION['userid'])) {
  
    header("Location: ../login.html");
    exit();
}
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petugas Area</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom right, #0f2027, #203a43, #2c5364);
            color: #ffffff;
            overflow-x: hidden;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(15, 23, 42, 0.9);
            padding: 20px;
            z-index: 10;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
        }

        header h1 {
            font-size: 24px;
            font-weight: 600;
            color: #38bdf8;
        }

        header .logout-btn {
    display: flex;
    align-items: center;
    gap: 5px;
    background: #ef4444; 
    color: #ffffff;
    padding: 8px 15px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: background 0.3s ease-in-out;
}

header .logout-btn i {
    font-size: 18px;
}

header .logout-btn:hover {
    background: #dc2626; 
}

        aside {
            position: fixed;
            top: 80px;
            left: 0;
            width: 250px;
            height: calc(100vh - 80px);
            background: rgba(30, 41, 59, 0.9);
            padding: 20px 10px;
            box-shadow: 4px 0px 10px rgba(0, 0, 0, 0.3);
            z-index: 5;
            overflow-y: auto;
        }

        .menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 15px;
            color: #94a3b8;
            text-decoration: none;
            font-weight: 500;
            font-size: 16px;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: all 0.3s ease-in-out;
        }

        .menu-item i {
            margin-right: 15px;
            font-size: 18px;
        }

        .menu-item:hover {
            background: linear-gradient(90deg, #2563eb, #1e40af);
            color: #ffffff;
        }

        .main {
            margin-left: 250px;
            margin-top: 80px;
            padding: 20px;
            min-height: 100vh;
        }

        footer {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background: rgba(15, 23, 42, 0.9);
    text-align: center;
    padding: 10px;
    color: #94a3b8;
    box-shadow: 0px -4px 10px rgba(0, 0, 0, 0.5);
    z-index: 5; 
}

        .holo-card {
            background: rgba(56, 189, 248, 0.1);
            border: 2px solid rgba(56, 189, 248, 0.3);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0px 10px 20px rgba(56, 189, 248, 0.3);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        

        .scrollable {
            overflow-y: auto;
            max-height: 100vh;
            padding-right: 10px;
        }
    </style>
</head>

<body>
    
    <header>
        <h1>Petugas Area</h1>
     <div class="profile">
    <a href="logout.php" class="logout-btn">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</div>
    </header>

    <aside>
        <ul class="menu">
            <li><a href="?hal=dashboard" class="menu-item"><i class="fas fa-chart-line"></i> Dashboard</a></li>
            <li><a href="?hal=user" class="menu-item"><i class="fas fa-user"></i> User</a></li>
            <li><a href="?hal=buku" class="menu-item"><i class="fas fa-book"></i> Buku</a></li>
            <li><a href="?hal=peminjaman" class="menu-item"><i class="fas fa-book-reader"></i>Peminjaman</a></li>
            <li><a href="?hal=ulasan" class="menu-item"><i class="fas fa-star"></i> Ulasan Buku</a></li>
            <li><a href="?hal=kategoribuku" class="menu-item"><i class="fas fa-tags"></i> Kategori Buku</a></li>
        </ul>
    </aside>

   
    <section class="main">
        <div class="holo-card scrollable">
            <?php include "konten.php"; ?>
        </div>
    </section>

  
    <footer>
        &copy; 2050 Muhammad Labib. All rights reserved.
    </footer>

   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>