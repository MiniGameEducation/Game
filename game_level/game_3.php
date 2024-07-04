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
$level_id = isset($_POST['level_id']) ? intval($_POST['level_id']) : 3;

$sql_kategori = "SELECT last_selected_kategori_id FROM user WHERE id = ?";
$stmt_kategori = $conn->prepare($sql_kategori);
$stmt_kategori->bind_param("i", $user_id);
$stmt_kategori->execute();
$stmt_kategori->bind_result($last_selected_kategori_id);
$stmt_kategori->fetch();
$stmt_kategori->close();

if (!$last_selected_kategori_id) {
    die("Kategori tidak valid.");
}

$sql_questions = "SELECT id, question, pilihan_1, pilihan_2, pilihan_3, pilihan_4, correct_choice 
                  FROM question 
                  WHERE kategori_id = ? AND level_id = ?";

$stmt_questions = $conn->prepare($sql_questions);
$stmt_questions->bind_param("ii", $last_selected_kategori_id, $level_id);
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
    <link rel="stylesheet" href="level2.css?v=<?php echo time()?>">
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
        <?php while ($question_data = $result_questions->fetch_assoc()): ?>
            <h2 id="question"><?php echo htmlspecialchars($question_data['question']); ?></h2>
            <form id="answerForm">
                <input type="hidden" name="start_time" value="<?php echo time(); ?>">
                <input type="hidden" name="kategori_id" value="<?php echo htmlspecialchars($last_selected_kategori_id); ?>">
                <input type="hidden" name="question_id" value="<?php echo htmlspecialchars($question_data['id']); ?>">
                <input type="hidden" name="level_id" value="<?php echo htmlspecialchars($level_id); ?>">
                <input type="hidden" id="correct_choice" value="<?php echo htmlspecialchars($question_data['correct_choice']); ?>">
                <div class="choice-container">
                    <input type="text" name="answer" class="choice-prefix" placeholder="Masukkan Jawaban Anda">
                </div>
                <input type="submit" class="kirim" value="Kirim">
            </form>
        <?php endwhile; ?>
    </div>
</div>

<div class="modal-edit" id="myModal" style="display: none;">
    <div class="modal-profil">
        <h1 class="modal-title" id="modalTitle">Skor: </h1>
        <h1 class="modal-title" id="correctQuestionNumbers"></h1>
        <h1 class="modal-title" id="correctAnswersText">Jawaban yang benar:</h1>
        
        <div class="button-container">
            <button onclick="restartGame()" class="button">Coba Lagi</button>
            <a href="../tampilanUtama/mainMenu.php" class="button2">Keluar</a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    feather.replace();

    $(document).ready(function() {
        $('#answerForm').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                type: 'POST',
                url: 'level2.php',
                data: $(this).serialize(),
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        $('#modalTitle').text('Skor: ' + data.score);
                        $('#correctQuestionNumbers').text(data.message);
                        $('#correctAnswersText').text('Jawaban yang benar: ' + data.correctAnswer);
                        $('#myModal').css('display', 'flex');  // Change to 'flex' to use flexbox centering
                    } else {
                        alert(data.message);
                    }
                },
                error: function() {
                    alert('Error processing your request.');
                }
            });
        });
    });

    function restartGame() {
        $('#myModal').css('display', 'none');
    }
</script>
<script src="level.js"></script>
</body>
</html>
