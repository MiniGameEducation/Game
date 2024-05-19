<?php
include '../database/koneksi.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Set content type to JSON
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['id'])) {
        $userId = $_SESSION['id']; // Retrieve the user ID from the session

        if (isset($_POST['total_score'])) {
            $totalScore = (int)$_POST['total_score']; // Ensure total_score is an integer

            // Update the user's score in the database
            $sqlUpdateScore = "UPDATE user SET score = score + ? WHERE id = ?";
            $stmt = $conn->prepare($sqlUpdateScore);
            if ($stmt === false) {
                echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
                $conn->close();
                exit();
            }

            $stmt->bind_param("ii", $totalScore, $userId);

            if ($stmt->execute()) {
                // Close the statement before redirection
                $stmt->close();
                $conn->close();

                // Redirect to the main menu
                header("Location: ../tampilanUtama/mainMenu.php");
                exit();
            } else {
                echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
                $stmt->close();
            }
        } else {
            echo json_encode(["success" => false, "message" => "Total score not provided."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "User is not logged in."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "HTTP method not supported."]);
}

$conn->close();
?>
