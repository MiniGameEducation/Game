<div class="leaderboard">

<div class="leaderboard-txt">
    Leaderboard
</div>

<?php
include '../database/koneksi.php';

// Mengaktifkan error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ambil data leaderboard dari database
$sql = "SELECT username, score FROM user ORDER BY score DESC";
$result = $conn->query($sql);

if ($result === FALSE) {
    // Menampilkan error jika query SQL gagal
    echo "Error: " . $conn->error;
    exit;
}

if ($result->num_rows > 0) {
    echo "<table class='tbl-leaderboard'>
            <tr>
                <th class='tbl-leaderboard-judul-no'>No</th>
                <th class='tbl-leaderboard-judul-username'>Username</th>
                <th class='tbl-leaderboard-judul-score'>Score</th>
            </tr>";
    $no = 1; // Inisialisasi variabel counter
    while ($row = $result->fetch_assoc()) {
            echo "  <tr>
                        <td class='tbl-leaderboard-list-no'>" . $no++ . "</td>
                        <td class='tbl-leaderboard-list-username'>" . htmlspecialchars($row["username"]) . "</td>
                        <td class='tbl-leaderboard-list-score'>" . htmlspecialchars($row["score"]) . "</td>
                    </tr>";
    }
    echo "</table>";
} else {
    echo "Leaderboard is empty.";
}
?>
</div>

