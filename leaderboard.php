<?php
include 'koneksi.php';

// Ambil data leaderboard dari database
$sql = "SELECT user.username, leaderboard.score FROM leaderboard JOIN user ON leaderboard.user_id = user.user_id ORDER BY leaderboard.score DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data dari leaderboard dalam tabel HTML
    echo "<table>";
    echo "<tr><th>Username</th><th>Score</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["username"]. "</td><td>" . $row["score"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "Leaderboard is empty.";
}
?>
