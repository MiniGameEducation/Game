<?php
include '../database/koneksi.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];
$level_id = isset($_POST['level_id']) ? intval($_POST['level_id']) : 1; // Ubah $_GET menjadi $_POST jika Anda mengirimkannya melalui POST

// Query to fetch last_selected_kategori_id
$sql_kategori = "SELECT last_selected_kategori_id FROM user WHERE id = ?";
$stmt_kategori = $conn->prepare($sql_kategori);
$stmt_kategori->bind_param("i", $user_id);
$stmt_kategori->execute();
$stmt_kategori->bind_result($last_selected_kategori_id);
$stmt_kategori->fetch();
$stmt_kategori->close();

// Validate last_selected_kategori_id
if (!$last_selected_kategori_id) {
    die("Kategori tidak valid.");
}

// Query to fetch questions based on kategori_id and level_id
$sql_questions = "SELECT id, question, pilihan_1, pilihan_2, pilihan_3, pilihan_4, correct_choice 
                  FROM question 
                  WHERE kategori_id = ? AND level_id = ?";

$stmt_questions = $conn->prepare($sql_questions);
$stmt_questions->bind_param("ii", $last_selected_kategori_id, $level_id); // Mengikat dua integer parameters
$stmt_questions->execute();
$result_questions = $stmt_questions->get_result();
$stmt_questions->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game</title>
    <link rel="icon" type="image/x-icon" href="img/Ratsel.png" />
    <link rel="stylesheet" href="game.css">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Changa+One:ital@0;1&display=swap" rel="stylesheet">
</head>

<body>

    <div class="container">
        <div id="game" class="justify-center flex-column">
            <div id="hud">
                <div id="hud-item">
                    <a href="../tampilanUtama/mainMenu.php" id="x"><i data-feather="x"></i></a>
                    <p id="progressText" class="hud-prefix"></p>
                    <div id="progressBar">
                        <div id="progressBarFull"></div>
                    </div>
                </div>
            </div>
            <?php while ($question_data = $result_questions->fetch_assoc()) : ?>
                <h2 id="question"><?php echo htmlspecialchars($question_data['question']); ?></h2>
                <form method="POST" action="../database/process.php">
                    <input type="hidden" name="start_time" value="<?php echo time(); ?>">
                    <input type="hidden" name="kategori_id" value="<?php echo htmlspecialchars($last_selected_kategori_id); ?>">
                    <input type="hidden" name="question_id" value="<?php echo htmlspecialchars($question_data['id']); ?>">
                    <input type="hidden" name="level_id" value="<?php echo htmlspecialchars($level_id); ?>">
                    <input type="hidden" id="correct_choice" value="<?php echo htmlspecialchars($question_data['correct_choice']); ?>">
                    <div class="choice-container">
                        <button class="choice-prefix">A</button>
                        <input type="submit" name="answer" class="choice-text" data-number="1" value="<?php echo htmlspecialchars($question_data['pilihan_1']); ?>">
                    </div>
                    <div class="choice-container">
                        <button class="choice-prefix">B</button>
                        <input type="submit" name="answer" class="choice-text" data-number="2" value="<?php echo htmlspecialchars($question_data['pilihan_2']); ?>">
                    </div>
                    <div class="choice-container">
                        <button class="choice-prefix">C</button>
                        <input type="submit" name="answer" class="choice-text" data-number="3" value="<?php echo htmlspecialchars($question_data['pilihan_3']); ?>">
                    </div>
                    <div class="choice-container">
                        <button class="choice-prefix">D</button>
                        <input type="submit" name="answer" class="choice-text" data-number="4" value="<?php echo htmlspecialchars($question_data['pilihan_4']); ?>">
                    </div>
                </form>
            <?php endwhile; ?>
        </div>
    </div>

    <div class="modal-edit" id="myModal">
        <div class="modal-profil">
            <div class="modal-close close-modal" title="Close"></div>
            <h1 class="modal-title">Selamat Anda Dinyatakan Tidak Naik Kelas</h1>
            <p class="modal-p">Skor : </p>
            <div class="button-container">
                <a href="game_1.php" class="button">Coba Lagi</a>
                <a href="user.php" class="button2">Keluar</a>
            </div>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
    <script src="level.js"></script>
</body>

</html>