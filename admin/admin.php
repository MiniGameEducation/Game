<?php
// Mengaktifkan pelaporan kesalahan untuk tujuan debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../database/koneksi.php';

// Memeriksa apakah kategori dipilih
$sql = "SELECT last_selected_kategori_id FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$kategoriId = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $kategoriId = $row['last_selected_kategori_id'];
}

// Kueri untuk mendapatkan level terakhir yang dikerjakan oleh pengguna dalam kategori yang dipilih
$sql = "SELECT level_id FROM autosave WHERE user_id = ? AND kategori_id = ? ORDER BY level_id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $user_id, $kategoriId);
$stmt->execute();
$result = $stmt->get_result();

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
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/Ratsel.png" />
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
                        <?php
                        $sql = "
                            SELECT k.kategori_id, k.kategori, COALESCE(MAX(up.level_id), 1) AS level_id
                            FROM kategori k
                            LEFT JOIN autosave up ON k.kategori_id = up.kategori_id AND up.user_id = ?
                            GROUP BY k.kategori_id, k.kategori
                        ";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param('i', $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) :
                        ?>
                            <a href="admin.php?page=<?php echo $row['kategori_id']; ?>&level_id=<?php echo $row['level_id']; ?>&page=<?php echo strtolower($row['kategori']); ?>">
                                <li><?php echo htmlspecialchars($row['kategori']); ?></li>
                            </a>
                        <?php endwhile; ?>
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
                case 'ilmu sosial':
                    include "page/ilmusosial.php";
                    break;
                case 'teknologi dan komputer':
                    include "page/tekompu.php";
                    break;
                case 'ekonomi':
                    include "page/ekonomi.php";
                    break;
                case 'biologi':
                    include "page/biologi.php";
                    break;
                default:
                    echo "<script>alert('Maaf. Halaman tidak ditemukan!'); window.location.href = 'admin.php';</script>";
            }
        } else {
            include "page/home.php";
        }
        ?>
    </div>

    <script>
        document.getElementById('kategori-link').onclick = function(event) {
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
