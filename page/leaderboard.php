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
    // Output data dari leaderboard dalam tabel HTML
    echo "<table>";
    echo "<tr><th>Username</th><th>Score</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . htmlspecialchars($row["username"]) . "</td><td>" . htmlspecialchars($row["score"]) . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "Leaderboard is empty.";
}
?>