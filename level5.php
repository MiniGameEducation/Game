<?php
include 'koneksi.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['id'])) {
        $userId = $_SESSION['id']; // Retrieve the user ID from the session
        $totalScore = $_POST['total_score'];

        // Update the user's score in the database
        $sqlUpdateScore = "UPDATE user SET score = score + ? WHERE id = ?";
        $stmt = $conn->prepare($sqlUpdateScore);
        $stmt->bind_param("ii", $totalScore, $userId);

        if ($stmt->execute()) {
            // Success response
            header("location:user.php");
        } else {
            // Error response
            echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "User is not logged in."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "HTTP method not supported."]);
}

$conn->close();
?>
