<?php
include '../database/koneksi.php';

// Mengaktifkan error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Mulai atau lanjutkan sesi
// Ambil data leaderboard dari database
$sql = "SELECT username, score FROM user ORDER BY score DESC";
$result = $conn->query($sql);

if ($result === FALSE) {
    // Tampilkan error jika query SQL gagal
    echo "Error: " . $conn->error;
    exit;
}

// Dapatkan nama pengguna yang login dari sesi
$loggedInUsername = isset($_SESSION['username']) ? $_SESSION['username'] : ''; 

if ($result->num_rows > 0) {
    echo "<table class='tbl-leaderboard'>
            <tr>
                <th class='tbl-leaderboard-judul-no'>No</th>
                <th class='tbl-leaderboard-judul-username'>Nama</th>
                <th class='tbl-leaderboard-judul-score'>Skor</th>
            </tr>";
    $no = 1; // Inisialisasi variabel counter
    while ($row = $result->fetch_assoc()) {
        $username = htmlspecialchars($row["username"]);
        $score = htmlspecialchars($row["score"]);
        // Tambahkan kelas "active" jika pengguna saat ini adalah pengguna yang sedang login
        $activeClass = ($username == $loggedInUsername) ? "tbl-leaderboard-list-active" : "";
        echo "<tr class='tbl-leaderboard-list $activeClass'>
                    <td class='tbl-leaderboard-list-no'>" . $no++ . "</td>
                    <td class='tbl-leaderboard-list-username'>" . $username . "</td>
                    <td class='tbl-leaderboard-list-score'>" . $score . "</td>
                </tr>";
    }
    echo "</table>";
} else {
    echo "Leaderboard is empty.";
}
?>