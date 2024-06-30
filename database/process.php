<?php
include 'koneksi.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

header('Content-Type: application/json');
$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['id'])) {
        $userId = $_SESSION['id'];

        if (isset($_POST["answer"]) && isset($_POST["start_time"]) && isset($_POST["question_id"]) && isset($_POST["level_id"])) {
            $userAnswer = (int)$_POST['answer']; // Cast to integer
            $startTime = (int)$_POST['start_time']; // Cast to integer
            $endTime = time();
            $timeTaken = $endTime - $startTime;
            $levelId = (int)$_POST['level_id']; // Cast to integer
            $questionId = (int)$_POST['question_id']; // Cast to integer

            // Mengambil jawaban yang benar dari database berdasarkan question_id
            $sqlCorrectAnswer = "SELECT correct_choice FROM question WHERE id = ?";
            $stmtCorrectAnswer = $conn->prepare($sqlCorrectAnswer);
            if ($stmtCorrectAnswer === false) {
                die("Prepare failed: " . $conn->error);
            }
            $stmtCorrectAnswer->bind_param("i", $questionId);
            if ($stmtCorrectAnswer->execute() === false) {
                die("Execute failed: " . $stmtCorrectAnswer->error);
            }

            $result = $stmtCorrectAnswer->get_result();
            if ($result === false) {
                die("Getting result set failed: " . $stmtCorrectAnswer->error);
            }

            $correctAnswerRow = $result->fetch_assoc();
            $correctAnswer = (int)$correctAnswerRow['correct_choice']; // Cast to integer
            $stmtCorrectAnswer->close();

            // Mengecek apakah jawaban pengguna benar
            if ($userAnswer === $correctAnswer) { // Use === for strict comparison
                if ($timeTaken <= 60) {
                    $score = 100;
                } else {
                    $score = 85;
                }
            } else {
                $score = 0;
            }

            // Memperbarui skor pengguna di tabel user
            $sqlUpdateScore = "UPDATE user SET score = score + ? WHERE id = ?";
            $stmtUpdateScore = $conn->prepare($sqlUpdateScore);
            if ($stmtUpdateScore === false) {
                die("Prepare failed: " . $conn->error);
            }
            $stmtUpdateScore->bind_param("ii", $score, $userId);
            if ($stmtUpdateScore->execute() === false) {
                die("Execute failed: " . $stmtUpdateScore->error);
            }

            // Menyimpan status permainan ke tabel autosave
            $sqlAutosave = "INSERT INTO autosave (user_id, level_id) VALUES (?, ?)
                            ON DUPLICATE KEY UPDATE level_id = ?";
            $stmtAutosave = $conn->prepare($sqlAutosave);
            if ($stmtAutosave === false) {
                die("Prepare failed: " . $conn->error);
            }
            $stmtAutosave->bind_param("iii", $userId, $levelId, $levelId);
            if ($stmtAutosave->execute() === false) {
                die("Execute failed: " . $stmtAutosave->error);
            }

            $response['status'] = 'success';
            $response['score'] = $score;
            $stmtUpdateScore->close();
            $stmtAutosave->close();
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
