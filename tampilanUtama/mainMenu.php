<?php
// Mulai sesi
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include file koneksi database
include "../database/koneksi.php";

// Pastikan user telah login
if (!isset($_SESSION["id"])) {
    die("User is not logged in.");
}

// Ambil ID pengguna yang sedang login
$userId = $_SESSION["id"];

// Ambil kategori yang dipilih
$sql = "SELECT last_selected_kategori_id FROM user WHERE id = $userId";
$result = $conn->query($sql);
$kategoriId = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $kategoriId = $row['last_selected_kategori_id'];
}

// Jika kategori belum dipilih, arahkan ke halaman pemilihan kategori
if ($kategoriId == 0) {
    header("Location: select_category.php");
    exit();
}

// Kueri untuk mendapatkan level terakhir yang dikerjakan oleh pengguna dalam kategori yang dipilih
$sql = "SELECT level_id FROM autosave WHERE user_id = $userId AND kategori_id = $kategoriId ORDER BY level_id DESC LIMIT 1";
$result = $conn->query($sql);

$lastCompletedLevel = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastCompletedLevel = $row['level_id'];
}

// Tentukan level yang dapat diakses oleh pengguna berdasarkan level terakhir yang dikerjakan
$accessibleLevels = [];
for ($i = 1; $i <= $lastCompletedLevel + 1; $i++) {
    $accessibleLevels[$i] = true;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rätsel</title>
<<<<<<< HEAD
    <link rel="icon" type="image/x-icon" href="img/Ratsel.png" />
=======
    <link rel="icon" type="image/x-icon" href="../img/Ratsel.png" />
>>>>>>> nizar
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
<?php

if (!isset($_GET['page']) || $_GET['page'] === 'study' || $_GET['page'] === 'user') {
    echo '<a href="select_category.php" class="kategori-button">Kategori</a>';
}
?>
 <!--=============== HEADER ===============-->
 <header class="header">
         <div class="header__container container">
            <div class="header__toggle" id="header-toggle">
               <i class="ri-menu-line"></i>
            </div>
    <div class="container">
        <div class="sidebar-container">
            <div class="sidebar-logo">
<<<<<<< HEAD
                <a href="mainMenu.php?page=study" <?php if(isset($_GET['page']) && $_GET['page'] === '../page/study') echo 'class="active"' ?>>RÄTSEL</a>
            </div>
            <div class="sidebar-item">
    <ul class="sidebar-itemlist">
        <a href="mainMenu.php?page=study">
            <li class="sidebar-item <?php if(isset($_GET['page']) && $_GET['page'] === 'study') echo 'active' ?>"><img src="../img/Benteng.png"><span>BELAJAR</span></li>
        </a>
        <a href="mainMenu.php?page=profile">
            <li class="sidebar-item <?php if(isset($_GET['page']) && $_GET['page'] === 'profile') echo 'active' ?>"><img src="../img/Profile.png"><span>PROFIL</span></li>
        </a>
        <a href="mainMenu.php?page=leaderboard">
            <li class="sidebar-item <?php if(isset($_GET['page']) && $_GET['page'] === 'leaderboard') echo 'active' ?>"><img src="../img/leaderboard.png" class="leaderboard"><span>PAPAN SKOR</span></li>
        </a>
        <a href="../database/logout.php"> <!-- Tambahkan link logout di sini -->
            <li class="sidebar-item"><img src="../img/logout.png" class="logout"><span>KELUAR</span></li>
        </a>
    </ul>
</div>

=======
                <a href="mainMenu.php?page=study" <?php if(isset($_GET['page']) && $_GET['page'] === 'study') echo 'class="active"' ?>>RÄTSEL</a>
            </div>
            <div class="sidebar-item">
                <ul class="sidebar-itemlist">
                    <a href="mainMenu.php?page=study">
                        <li class="sidebar-item <?php if(isset($_GET['page']) && $_GET['page'] === 'study') echo 'active' ?>"><img src="../img/benteng.png"><span>BELAJAR</span></li>
                    </a>
                    <a href="mainMenu.php?page=profile">
                        <li class="sidebar-item <?php if(isset($_GET['page']) && $_GET['page'] === 'profile') echo 'active' ?>"><img src="../img/profile.png"><span>PROFIL</span></li>
                    </a>
                    <a href="mainMenu.php?page=leaderboard">
                        <li class="sidebar-item <?php if(isset($_GET['page']) && $_GET['page'] === 'leaderboard') echo 'active' ?>"><img src="../img/leaderboard.png" class="leaderboard"><span>PAPAN SKOR</span></li>
                    </a>
                    <a href="../database/logout.php">
                        <li class="sidebar-item"><img src="../img/logout.png" class="logout"><span>KELUAR</span></li>
                    </a>
                </ul>
            </div>
>>>>>>> nizar
        </div>
        <div class="main-container">
            <?php
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                switch ($page) {
                    case 'study':
                        include "../page/study.php";
                        break;
                    case 'profile':
                        include "../page/profile.php";
                        break;
                    case 'leaderboard':
                        include "../page/leaderboard.php";
                        break;
                    default:
                        echo "<script>alert('Maaf. Halaman tidak ditemukan!'); window.location.href = 'index.php';</script>";
                }
            } else {
                include "../page/study.php";
            }
            ?>
        </div>
    </div>
    <script src="user.js"></script>
</body>

</html>
