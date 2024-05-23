<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rätsel</title>
    <link rel="icon" type="image/x-icon" href="img/Ratsel.png" />
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container">
        <div class="sidebar-container">
            <div class="sidebar-logo">
                <a href="mainMenu.php?page=study" <?php if(isset($_GET['page']) && $_GET['page'] === '../page/study') echo 'class="active"' ?>>RÄTSEL</a>
            </div>
            <div class="sidebar-item">
    <ul class="sidebar-itemlist">
        <a href="mainMenu.php?page=study">
            <li class="sidebar-item <?php if(isset($_GET['page']) && $_GET['page'] === 'study') echo 'active' ?>"><img src="../img/Benteng.png"><span>STUDY</span></li>
        </a>
        <a href="mainMenu.php?page=profile">
            <li class="sidebar-item <?php if(isset($_GET['page']) && $_GET['page'] === 'profile') echo 'active' ?>"><img src="../img/Profile.png"><span>PROFILE</span></li>
        </a>
        <a href="mainMenu.php?page=leaderboard">
            <li class="sidebar-item <?php if(isset($_GET['page']) && $_GET['page'] === 'leaderboard') echo 'active' ?>"><img src="../img/leaderboard.png" class="leaderboard"><span>LEADERBOARD</span></li>
        </a>
        <a href="../database/logout.php"> <!-- Tambahkan link logout di sini -->
            <li class="sidebar-item"><img src="../img/logout.png" class="logout"><span>LOGOUT</span></li>
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
    <script src="user.js"></script>
</body>

</html>
