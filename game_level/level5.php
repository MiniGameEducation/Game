<?php
include '../database/koneksi.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

header('Content-Type: application/json');
$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['id'])) {
        $userId = $_SESSION['id'];

        if (isset($_POST["answer"]) && isset($_POST["question_id"]) && isset($_POST["level_id"]) && isset($_POST["kategori_id"])) {
            $userAnswers = $_POST['answer'];
            $questionIds = $_POST['question_id'];
            $levelId = (int)$_POST['level_id'];
            $kategoriId = (int)$_POST['kategori_id'];

            $correctAnswersCount = 0;
            $response['details'] = [];
            $totalScore = 0;
            $correctQuestionNumbers = []; 

            $sqlKategori = "SELECT last_selected_kategori_id FROM user WHERE id = ?";
            $stmtKategori = $conn->prepare($sqlKategori);
            if ($stmtKategori === false) {
                die("Prepare failed: " . $conn->error);
            }
            $stmtKategori->bind_param("i", $userId);
            if ($stmtKategori->execute() === false) {
                die("Execute failed: " . $stmtKategori->error);
            }

            $resultKategori = $stmtKategori->get_result();
            if ($resultKategori === false) {
                die("Getting result set failed: " . $stmtKategori->error);
            }

            $kategoriRow = $resultKategori->fetch_assoc();
            $lastSelectedKategoriId = (int)$kategoriRow['last_selected_kategori_id'];
            $stmtKategori->close();

            foreach ($questionIds as $index => $questionId) {
                $userAnswer = (int)$userAnswers[$index];
                $questionId = (int)$questionId;

                $sqlCorrectAnswer = "SELECT correct_choice FROM question WHERE id = ? AND kategori_id = ?";
                $stmtCorrectAnswer = $conn->prepare($sqlCorrectAnswer);
                if ($stmtCorrectAnswer === false) {
                    die("Prepare failed: " . $conn->error);
                }
                $stmtCorrectAnswer->bind_param("ii", $questionId, $lastSelectedKategoriId);
                if ($stmtCorrectAnswer->execute() === false) {
                    die("Execute failed: " . $stmtCorrectAnswer->error);
                }

                $result = $stmtCorrectAnswer->get_result();
                if ($result === false) {
                    die("Getting result set failed: " . $stmtCorrectAnswer->error);
                }

                $correctAnswerRow = $result->fetch_assoc();
                if ($correctAnswerRow) {
                    $correctAnswer = (int)$correctAnswerRow['correct_choice'];
                } else {
                    $correctAnswer = null;
                }
                $stmtCorrectAnswer->close();

                $response['details'][] = [
                    'question_id' => $questionId,
                    'user_answer' => $userAnswer,
                    'correct_answer' => $correctAnswer
                ];

                if ($userAnswer === $correctAnswer) {
                    $correctAnswersCount++;
                    $correctQuestionNumbers[] = $index + 1; 
                }
            }

            if ($correctAnswersCount === 2) {
                $totalScore = 100;
            } elseif ($correctAnswersCount === 1) {
                $totalScore = 50;
            } else {
                $totalScore = 0;
            }

            $sqlUpdateScore = "UPDATE user SET score = score + ? WHERE id = ?";
            $stmtUpdateScore = $conn->prepare($sqlUpdateScore);
            if ($stmtUpdateScore === false) {
                die("Prepare failed: " . $conn->error);
            }
            $stmtUpdateScore->bind_param("ii", $totalScore, $userId);
            if ($stmtUpdateScore->execute() === false) {
                die("Execute failed: " . $stmtUpdateScore->error);
            }
            $stmtUpdateScore->close();

            $sqlAutosave = "INSERT INTO autosave (user_id, level_id, kategori_id) VALUES (?, ?, ?)
                            ON DUPLICATE KEY UPDATE level_id = ?, kategori_id = ?";
            $stmtAutosave = $conn->prepare($sqlAutosave);
            if ($stmtAutosave === false) {
                die("Prepare failed: " . $conn->error);
            }
            $stmtAutosave->bind_param("iiiii", $userId, $levelId, $kategoriId, $levelId, $kategoriId);
            if ($stmtAutosave->execute() === false) {
                die("Execute failed: " . $stmtAutosave->error);
            }
            $stmtAutosave->close();

            $response['status'] = 'success';
            $response['correct_answers'] = $correctAnswersCount;
            $response['score'] = $totalScore;
            $response['correct_question_numbers'] = $correctQuestionNumbers; 
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Invalid input data.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'User is not logged in.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
$conn->close();
?>
