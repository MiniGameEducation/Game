<?php
include '../database/koneksi.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

header('Content-Type: application/json');
$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['id'])) {
        $userId = $_SESSION['id'];  // Mengambil ID pengguna dari sesi

        if (isset($_POST["answer"]) && isset($_POST["start_time"]) && isset($_POST["level_id"])) {
            $userAnswer = $_POST['answer'];
            $startTime = (int)$_POST['start_time'];  // Convert to integer
            $endTime = time();
            $timeTaken = $endTime - $startTime;
            $levelId = (int)$_POST['level_id'];  // Convert to integer

            $correctAnswer = "Being recognized globally";

            if ($userAnswer === $correctAnswer) {
                $score = ($timeTaken <= 60) ? 100 : 85;
            } else {
                $score = 0;
            }

            // Debugging: Log the calculated score and other variables
            error_log("User ID: $userId");
            error_log("Answer: $userAnswer");
            error_log("Correct Answer: $correctAnswer");
            error_log("Time Taken: $timeTaken seconds");
            error_log("Score: $score");
            error_log("Level ID: $levelId");

            $sqlUpdateScore = "UPDATE user SET score = score + ? WHERE id = ?";
            $stmt = $conn->prepare($sqlUpdateScore);
            if ($stmt === false) {
                $response["success"] = false;
                $response["message"] = "Prepare failed: " . $conn->error;
                echo json_encode($response);
                $conn->close();
                exit;
            }

            $stmt->bind_param("ii", $score, $userId);

            if ($stmt->execute()) {
                // Save the game state to autosave table
                $sqlAutosave = "INSERT INTO autosave (user_id, level_id) VALUES (?, ?)
                                ON DUPLICATE KEY UPDATE level_id = ?";
                $stmtAutosave = $conn->prepare($sqlAutosave);
                if ($stmtAutosave === false) {
                    $response["success"] = false;
                    $response["message"] = "Prepare failed: " . $conn->error;
                    echo json_encode($response);
                    $stmt->close();
                    $conn->close();
                    exit;
                }

                $stmtAutosave->bind_param("iii", $userId, $levelId, $levelId);

                if ($stmtAutosave->execute()) {
                    // Send JSON response indicating success before redirection
                    $response["success"] = true;
                    $response["message"] = "Score updated and game state saved.";
                    echo json_encode($response);
                    
                    // Close statements and connection before redirection
                    $stmtAutosave->close();
                    $stmt->close();
                    $conn->close();
                    
                    // Redirect to main menu
                    header("Location: ../tampilanUtama/mainMenu.php");
                    exit();
                } else {
                    $response["success"] = false;
                    $response["message"] = "Error: " . $stmtAutosave->error;
                }
                $stmtAutosave->close();
            } else {
                $response["success"] = false;
                $response["message"] = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $response["success"] = false;
            $response["message"] = "Some fields are missing.";
        }
    } else {
        $response["success"] = false;
        $response["message"] = "User is not logged in.";
    }
} else {
    $response["success"] = false;
    $response["message"] = "HTTP method not supported.";
}

echo json_encode($response);
$conn->close();
?>
