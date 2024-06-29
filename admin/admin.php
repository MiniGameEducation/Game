<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                        <a href="admin.php?page=agama"><li>Agama</li></a>
                        <a href="admin.php?page=matematika"><li>Matematika</li></a>
                        <a href="admin.php?page=bahasaindo"><li>Bahasa Indonesia</li></a>
                        <a href="admin.php?page=bahasainggris"><li>Bahasa Inggris</li></a>
                        <a href="admin.php?page=sejarah"><li>Sejarah</li></a>
                        <a href="admin.php?page=informatika"><li>Informatika</li></a>
                        <a href="admin.php?page=ipas"><li>IPAS</li></a>
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
                case 'agama':
                    include "page/agama.php";
                    break;
                case 'bahasaindo':
                    include "page/bahasaindo.php";
                    break;
                case 'bahasainggris':
                    include "page/bahasainggris.php";
                    break;
                case 'sejarah':
                    include "page/sejarah.php";
                    break;
                case 'informatika':
                    include "page/informatika.php";
                    break;
                case 'ipas':
                    include "page/ipas.php";
                    break;
                case 'matematika':
                    include "page/matematika.php";
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

