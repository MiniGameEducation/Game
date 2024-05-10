<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Menangani hasil jawaban dari pengguna
    $userAnswer = $_POST['answer'];

    // Skor yang diberikan berdasarkan jawaban
    $score = ($userAnswer == 15) ? 100 : 0; // Menambahkan 100 poin untuk setiap level yang berhasil

    // Mendapatkan user_id dari cookie
    if(isset($_COOKIE['user_id'])){
        $userId = $_COOKIE['user_id'];

        // Memperbarui atau menyisipkan skor pengguna ke dalam leaderboard
        $sqlLeaderboard = "INSERT INTO leaderboard (user_id, score) VALUES ('$userId', '$score') ON DUPLICATE KEY UPDATE score = score + '$score'";

        if ($conn->query($sqlLeaderboard) === TRUE) {
            // Pesan sukses untuk leaderboard
            echo "Score updated successfully for leaderboard. ";
        } else {
            echo "Error: " . $sqlLeaderboard . "<br>" . $conn->error;
        }

        // Menyimpan data game ke dalam tabel autosave
        $gameData = "Game data to be saved"; 
        $sqlAutosave = "REPLACE INTO Autosave (user_id, game_data) VALUES ('$userId', '$gameData')";

        if ($conn->query($sqlAutosave) === TRUE) {
            // Pesan sukses untuk autosave
            echo "Game saved successfully for autosave.";
            echo "<a href='user.php> Kembali </a>'";
        } else {
            echo "Error: " . $sqlAutosave . "<br>" . $conn->error;
        }
    } else {
        echo "User is not logged in.";
    }
}
?>
