<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-logos">
            <div class="hamburger" id="hamburger">&#9776;</div>
            <div class="logo">
                <a href="admin.php?page=home">RÄTSEL<br>
                <span>ADMIN</span></a>
            </div>
        </div>
        <div class="sidebar-item">
            <ul class="main-menu">
                <li class="user"><a href="admin.php?page=home">Users</a></li>
                <li class="kategori-menu">
                    <a href="#" id="kategori-link">Kategori</a>
                </ul>
                    <ul class="submenu" id="submenu">
                        <li><a href="admin.php?page=agama">Agama</a></li>
                        <li><a href="admin.php?page=matematika">Matematika</a></li>
                        <li><a href="admin.php?page=bahasaindo">Bahasa Indonesia</a></li>
                        <li><a href="admin.php?page=bahasainggris">Bahasa Inggris</a></li>
                        <li><a href="admin.php?page=sejarah">Sejarah</a></li>
                        <li><a href="admin.php?page=informatika">Informatika</a></li>
                        <li><a href="admin.php?page=ipas">IPAS</a></li>

                    </ul>
        </div>
    </nav>

    <div class="navbar">
        <div class="admin">
            <div class="profil">
                <img src="../img/admin.jpg">
            </div>
            <span>Admin</span>
        </div>
    </div>

    <main>
    <?php
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                switch ($page) {
                    case 'home':
                        include "page/home.php";
                        break;
                    case 'agama':
                        include "page/agama.php";
                        break;
                    case 'bahasaindo';
                        include "page/bahasaindo.php";
                        break;
                    case 'bahasainggris';
                        include "page/bahasainggris.php";
                        break;
                    case 'sejarah';
                        include "page/sejarah.php";
                        break;
                    case 'informatika';
                        include "page/informatika.php";
                        break;
                    case 'ipas';
                        include "page/ipas.php";
                        break;
                    case 'matematika';
                        include "page/matematika.php";
                        break;
                    default:
                        echo "<script>alert('Maaf. Halaman tidak ditemukan!'); window.location.href = '../index.php';</script>";
                }
            } else {
                include "page/home.php";
            }
            ?>
    </main>

    <script>
        document.getElementById('hamburger').onclick = function () {
            var sidebar = document.getElementById('sidebar');
            var userTable = document.querySelector('.user-table');
            sidebar.classList.toggle('active');
            if (sidebar.classList.contains('active')) {
                userTable.style.marginLeft = '150px';
                userTable.style.transition = "0.4s ease-in-out";
            } else {
                userTable.style.marginLeft = '0px';
                userTable.style.transition = "0.4s ease-in-out";
            }
        }

        document.getElementById('kategori-link').onclick = function (event) {
            event.preventDefault(); // Prevent default link behavior
            var submenu = document.getElementById('submenu');
            submenu.classList.toggle('active');
        }

        document.getElementById('select_all').onclick = function () {
            var checkboxes = document.getElementsByName('user_ids[]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        }
    </script>
</body>

</html>
