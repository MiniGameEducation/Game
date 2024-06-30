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
$level_id = isset($_POST['level_id']) ? intval($_POST['level_id']) : 2;

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
$sql_questions = "SELECT id, question, pilihan_1, correct_choice 
                  FROM question 
                  WHERE kategori_id = ? AND level_id = ?";
$stmt_questions = $conn->prepare($sql_questions);
$stmt_questions->bind_param("ii", $last_selected_kategori_id, $level_id);
$stmt_questions->execute();
$result_questions = $stmt_questions->get_result();

// Fetch questions into an array
$questions = array();
while ($row = $result_questions->fetch_assoc()) {
    $questions[] = $row;
}
$stmt_questions->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game</title>
    <link rel="icon" type="image/x-icon" href="../img/Ratsel.png" />
    <link rel="stylesheet" href="level2.css">
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
                    <a href="user.php" id="x"><i data-feather="x"></i></a>
                    <p id="progressText" class="hud-prefix"></p>
                    <div id="progressBar">
                        <div id="progressBarFull"></div>
                    </div>
                </div>
            </div>
            <form id="answerForm" method="POST" action="level3.php">
                <h2 id="question"></h2>
                <div class="choice-container">
                    <input type="text" name="answer" class="choice-prefix" placeholder="Masukkan Jawaban Anda">
                </div>
                <input type="hidden" name="start_time" id="start_time">
                <input type="hidden" name="question_id" id="question_id">
                <input type="hidden" name="level_id" value="<?php echo htmlspecialchars($level_id); ?>">
                <input type="hidden" name="kategori_id" value="<?php echo htmlspecialchars($last_selected_kategori_id); ?>">
                <input type="submit" class="kirim" value="Kirim">
            </form>
        </div>
    </div>
    <div class="modal__container" id="modal-container">
        <div class="modal__content">
            <div class="modal__close close-modal" title="Close"></div>
            <img src="gmbr.png" alt="" class="modal__img">
            <h1 class="modal__title">Semoga bisa main bareng lagi segera! Jaga diri dan sampai ketemu!</h1>
            <button class="modal__button-link">Keluar</button>
            <button class="modal__button-link close-modal">Lanjutkan</button>
        </div>
    </div>

    <script>
        feather.replace();

        // Set the start time when the page loads
        document.getElementById('start_time').value = Math.floor(Date.now() / 1000);

        // Pass PHP questions array to JavaScript
        const questions = <?php echo json_encode($questions); ?>;
    </script>
    <script>
        const questionElement = document.getElementById("question");
        const progressText = document.getElementById('progressText');
        const progressBarFull = document.getElementById('progressBarFull');
        const modalContainer = document.getElementById('modal-container2');
        const modalDescription = document.querySelector('.modal__description2');

        let currentQuestion = {};
        let acceptingAnswer = false;
        let questionCounter = 0;
        let availableQuestions = [...questions];

        const MAX_QUESTIONS = questions.length;
        const TOTAL_TIME = 60;
        let timeLeft = TOTAL_TIME;
        let timer;
        let elapsedTime = 0;

        const startGame = () => {
            questionCounter = 0;
            getNewQuestion();
            startTimer();
        };

        const startTimer = () => {
            progressBarFull.style.width = '100%';
            timeLeft = TOTAL_TIME;
            timer = setInterval(() => {
                elapsedTime++;
                const minutes = Math.floor(elapsedTime / 60);
                const seconds = elapsedTime % 60;
                progressText.innerText = `${padZero(minutes)}:${padZero(seconds)}`;
                if (timeLeft > 0) {
                    timeLeft--; 
                    progressBarFull.style.width = `${(timeLeft / TOTAL_TIME) * 100}%`; 
                }
            }, 1000);
        };

        const padZero = (num) => {
            return (num < 10) ? `0${num}` : num;
        };

        const getNewQuestion = () => {
            if (availableQuestions.length === 0 || questionCounter >= MAX_QUESTIONS) {
                clearInterval(timer);
                modalContainer.classList.add('show-modal2');
                return;
            }
            questionCounter++;
            const questionIndex = Math.floor(Math.random() * availableQuestions.length);
            currentQuestion = availableQuestions[questionIndex];
            questionElement.innerText = currentQuestion.question;
            document.getElementById('question_id').value = currentQuestion.id;

            availableQuestions.splice(questionIndex, 1);
            acceptingAnswer = true;
        };

        startGame();
    </script>  
</body>
</html>
