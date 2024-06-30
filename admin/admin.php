<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link rel="icon" type="image/x-icon" href="../img/Ratsel.png"/>
    <title>Halaman Admin</title>
    <link rel="stylesheet" href="admin.css?v=<?php echo time(); ?>">
</head>

<body>
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-item">
            <ul class="main-menu">
                <li class="user"><a href="admin.php?page=home">Users</a></li>
                <li class="kategori-menu">
                    <a href="#" id="kategori-link">Kategori</a>
                    <ul class="submenu" id="submenu">
                        <a href="admin.php?page=matematika"><li>MATEMATIKA</li></a>
                        <a href="admin.php?page=fisika"><li>FISIKA</li></a>
                        <a href="admin.php?page=bahasa"><li>BAHASA</li></a>
                        <a href="admin.php?page=ilmusosial"><li>ILMU SOSIAL</li></a>
                        <a href="admin.php?page=tekompu"><li>TEKNOLOGI DAN KOMPUTER</li></a>
                        <a href="admin.php?page=ekonomi"><li>EKONOMI</li></a>
                        <a href="admin.php?page=biologi"><li>BIOLOGI</li></a>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <div class="user-table">
        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            switch ($page) {
                case 'home':
                    include "page/home.php";
                    break;
                case 'matematika':
                    include "page/matematika.php";
                    break;
                case 'fisika':
                    include "page/fisika.php";
                    break;
                case 'bahasa':
                    include "page/bahasa.php";
                    break;
                case 'ilmusosial':
                    include "page/ilmusosial.php";
                    break;
                case 'tekompu':
                    include "page/tekompu.php";
                    break;
                case 'ekonomi':
                    include "page/ekonomi.php";
                    break;
                case 'biologi':
                    include "page/biologi.php";
                    break;
                default:
                    echo "<script>alert('Maaf. Halaman tidak ditemukan!'); window.location.href = '../index.php';</script>";
            }
        } else {
            include "page/home.php";
        }
        ?>
    </div>

    <script>
              document.getElementById('kategori-link').onclick = function (event) {
            event.preventDefault();
            var submenu = document.getElementById('submenu');
            submenu.classList.toggle('active');
        }


        document.getElementById('select_all').addEventListener('click', function(event) {
            var checkboxes = document.querySelectorAll('.user_checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = event.target.checked;
            });
        });
    </script>
</body>

</html>