<?php
include 'koneksi.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$response = array();

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_SESSION['id'])) {
            $userId = $_SESSION['id'];

            if (isset($_POST["answer"]) && isset($_POST["start_time"]) && isset($_POST["question_id"]) && isset($_POST["kategori_id"]) && isset($_POST['level_id'])) {
                $userAnswer = $_POST['answer'];
                $startTime = (int)$_POST['start_time'];
                $endTime = time();
                $timeTaken = $endTime - $startTime;
                $kategoriId = (int)$_POST['kategori_id'];
                $questionId = (int)$_POST['question_id'];
                $levelId = (int)$_POST['level_id'];


                $sqlCorrectAnswer = "SELECT correct_choice FROM question WHERE id = ?";
                $stmtCorrectAnswer = $conn->prepare($sqlCorrectAnswer);
                if ($stmtCorrectAnswer === false) {
                    throw new Exception("Prepare failed: " . $conn->error);
                }
                $stmtCorrectAnswer->bind_param("i", $questionId);
                if ($stmtCorrectAnswer->execute() === false) {
                    throw new Exception("Execute failed: " . $stmtCorrectAnswer->error);
                }

                $result = $stmtCorrectAnswer->get_result();
                if ($result === false) {
                    throw new Exception("Getting result set failed: " . $stmtCorrectAnswer->error);
                }

                $correctAnswerRow = $result->fetch_assoc();
                $correctAnswer = $correctAnswerRow['correct_choice'];
                $stmtCorrectAnswer->close();


                if ($userAnswer == $correctAnswer) {
                    if ($timeTaken <= 60) {
                        $score = 100;
                    } else {
                        $score = 85;
                    }
                } else {
                    $score = 0;
                }

                $sqlUpdateScore = "UPDATE user SET score = score + ? WHERE id = ?";
                $stmtUpdateScore = $conn->prepare($sqlUpdateScore);
                if ($stmtUpdateScore === false) {
                    throw new Exception("Prepare failed: " . $conn->error);
                }
                $stmtUpdateScore->bind_param("ii", $score, $userId);
                if ($stmtUpdateScore->execute() === false) {
                    throw new Exception("Execute failed: " . $stmtUpdateScore->error);
                }


                $sqlAutosave = "INSERT INTO autosave (user_id, level_id, kategori_id) VALUES (?, ?, ?)
                                ON DUPLICATE KEY UPDATE level_id = VALUES(level_id), kategori_id = VALUES(kategori_id)";
                $stmtAutosave = $conn->prepare($sqlAutosave);
                if ($stmtAutosave === false) {
                    throw new Exception("Prepare failed: " . $conn->error);
                }
                $stmtAutosave->bind_param("iii", $userId, $levelId, $kategoriId);
                if ($stmtAutosave->execute() === false) {
                    throw new Exception("Execute failed: " . $stmtAutosave->error);
                }

                header('Location: ../tampilanUtama/mainMenu.php');
                exit();
            } else {
                throw new Exception('Invalid input data.');
            }
        } else {
            throw new Exception('User is not logged in.');
        }
    } else {
        throw new Exception('Invalid request method.');
    }
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
} finally {
    $conn->close();
}
?>
