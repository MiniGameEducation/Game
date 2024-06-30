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
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container">
        <div class="sidebar-container">
            <div class="sidebar-logo">
                <a>RÄTSEL</a>
            </div>
            <div class="sidebar-item">
                <ul class="sidebar-itemlist">
                    <a href="mainMenu.php?page=study">
                        <li class="sidebar-item"><img src="../img/benteng.png"><span>STUDY</span></li>
                    </a>
                    <a href="mainMenu.php?page=profile">
                        <li class="sidebar-item"><img src="../img/profile.png"><span>PROFILE</span></li>
                    </a>
                    <a href="mainMenu.php?page=leaderboard">
                        <li class="sidebar-item"><img src="../img/leaderboard.png" class="leaderboard"><span>LEADERBOARD</span></li>
                    </a>
                </ul>
            </div>
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
    <script src="script.js"></script>
</body>

</html>