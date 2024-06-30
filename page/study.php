<?php
// Include file koneksi database
include "../database/koneksi.php";

// Mulai sesi
// Pastikan user telah login
if (!isset($_SESSION["id"])) {
    die("User is not logged in.");
}

// Ambil ID pengguna yang sedang login
$userId = $_SESSION["id"];  // Pastikan variabel sesi yang benar digunakan

// Debugging: Cetak ID pengguna yang sedang login
error_log("User ID: " . $userId);

// Kueri untuk mendapatkan level terakhir yang dikerjakan oleh pengguna
$sql = "SELECT level_id FROM autosave WHERE user_id = $userId ORDER BY level_id DESC LIMIT 1";
$result = $conn->query($sql);

// Debugging: Cetak hasil kueri
if (!$result) {
    error_log("Query Error: " . $conn->error);
}

$lastCompletedLevel = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastCompletedLevel = $row['level_id'];
}

// Debugging: Cetak level terakhir yang diselesaikan
error_log("Last Completed Level: " . $lastCompletedLevel);

// Tentukan level yang dapat diakses oleh pengguna berdasarkan level terakhir yang dikerjakan
$accessibleLevels = [];
for ($i = 1; $i <= $lastCompletedLevel + 1; $i++) {
    $accessibleLevels[$i] = true;
}
?>

<div class="main-container">
    <ul class="level-atas">
        <?php
        // Loop untuk menampilkan level atas
        for ($i = 1; $i <= 3; $i++) { // Jumlah level atas
            $class = isset($accessibleLevels[$i]) ? '' : 'locked';
            echo "<a href='" . ($class === '' ? "../game_level/game_$i.php" : "#") . "'><li class='level-item $class'>$i</li></a>";
        }
        ?>
    </ul>
    <ul class="level-bawah">
        <?php
        // Loop untuk menampilkan level bawah
        for ($i = 4; $i <= 5; $i++) { // Jumlah level bawah
            $class = isset($accessibleLevels[$i]) ? '' : 'locked';
            echo "<a href='" . ($class === '' ? "../game_level/game_$i.php" : "#") . "'><li class='level-item $class'>$i</li></a>";
        }
        ?>
    </ul>
</div>
