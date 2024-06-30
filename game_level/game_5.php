<?php
// Include koneksi.php
include '../database/koneksi.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Redirect pengguna ke halaman login jika belum login
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

// Dapatkan kategori_id dari request atau session
$level_id = isset($_POST['level_id']) ? intval($_POST['level_id']) : 5; // Ubah $_GET menjadi $_POST jika Anda mengirimkannya melalui POST

// Query untuk mengambil last_selected_kategori_id
$sql_kategori = "SELECT last_selected_kategori_id FROM user WHERE id = ?";
$stmt_kategori = $conn->prepare($sql_kategori);
$stmt_kategori->bind_param("i", $user_id);
$stmt_kategori->execute();
$stmt_kategori->bind_result($last_selected_kategori_id);
$stmt_kategori->fetch();
$stmt_kategori->close();

// Query untuk mengambil pertanyaan berdasarkan kategori_id dan level_id
$sql_questions = "SELECT id, question, pilihan_1, pilihan_2, pilihan_3, pilihan_4, correct_choice 
                  FROM question 
                  WHERE kategori_id = ? AND level_id = ?";
$stmt_questions = $conn->prepare($sql_questions);
$stmt_questions->bind_param("ii", $last_selected_kategori_id, $level_id);
$stmt_questions->execute();
$result_questions = $stmt_questions->get_result();

$questions = [];
while ($row = $result_questions->fetch_assoc()) {
    $questions[] = [
        'id' => $row['id'],
        'question' => $row['question'],
        'choices' => [
            '1' => $row['pilihan_1'],
            '2' => $row['pilihan_2'],
            '3' => $row['pilihan_3'],
            '4' => $row['pilihan_4']
        ]
    ];
}

$stmt_questions->close();

// Close koneksi database
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game 5</title>
    <link rel="stylesheet" href="level.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link href="https://fonts.googleapis.com/css2?family=Changa+One:ital@0;1&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../img/Ratsel.png" />

</head>
<body>
    
    <div class="container">
        <div id="game" class="justify-center flex-column">
            <div id="hud">
                <div id="hud-item">
                    <a href="#modal-container" id="x"><i data-feather="x"></i></a>
                    <p id="progressText" class="hud-prefix"></p>
                    <div id="progressBar">
                        <div id="progressBarFull"></div>
                    </div>
                </div>
            </div>
            <h2 id="question"></h2>
            <div class="choice-container">
                <button class="choice-prefix">A</button>
                <button class="choice-text" data-number="1"></button>
            </div>
            <div class="choice-container">
                <button class="choice-prefix">B</button>
                <button class="choice-text" data-number="2"></button>
            </div>
            <div class="choice-container">
                <button class="choice-prefix">C</button>
                <button class="choice-text" data-number="3"></button>
            </div>
            <div class="choice-container">
                <button class="choice-prefix">D</button>
                <button class="choice-text" data-number="4"></button>
            </div>
        </div>
    </div>

    <form id="answerForm" method="POST" action="level5.php" style="display: none;">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <input type="hidden" name="level_id" id="levelIdInput" value="<?php echo $level_id; ?>">
        <input type="hidden" name="kategori_id" value="<?php echo $last_selected_kategori_id; ?>">
        <div id="answersContainer"></div> <!-- Container to hold the answers -->
    </form>

    <script>
    feather.replace();
</script>

    <script>
        const questions = <?php echo json_encode($questions); ?>;
        let currentQuestionIndex = 0;

        function loadQuestion() {
            if (currentQuestionIndex >= questions.length) {
                // Submit the form when all questions are answered
                document.getElementById('answerForm').submit();
                return;
            }

            const questionData = questions[currentQuestionIndex];
            document.querySelector('#question').textContent = questionData.question;
            document.querySelectorAll('.choice-text').forEach((btn, index) => {
                btn.textContent = questionData.choices[index + 1];
                btn.onclick = () => selectAnswer(index + 1, questionData.id);
            });

            document.querySelector('#progressText').textContent = `Pertanyaan ${currentQuestionIndex + 1} dari ${questions.length}`;
            const progressBarFull = document.querySelector('#progressBarFull');
            progressBarFull.style.width = `${((currentQuestionIndex + 1) / questions.length) * 100}%`;
        }

        function selectAnswer(choice, questionId) {
            const answersContainer = document.getElementById('answersContainer');
            
            // Create hidden input elements for question ID and answer
            const questionIdInput = document.createElement('input');
            questionIdInput.type = 'hidden';
            questionIdInput.name = 'question_id[]';
            questionIdInput.value = questionId;

            const answerInput = document.createElement('input');
            answerInput.type = 'hidden';
            answerInput.name = 'answer[]';
            answerInput.value = choice;

            // Append hidden inputs to the answers container
            answersContainer.appendChild(questionIdInput);
            answersContainer.appendChild(answerInput);
            

            currentQuestionIndex++;
            loadQuestion();
        }

        document.addEventListener('DOMContentLoaded', loadQuestion);
    </script>

  
</body>
</html>
