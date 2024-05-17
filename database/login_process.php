<?php
include 'koneksi.php';

header('Content-Type: application/json');

session_start();

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['id'] = $row['id'];  // Store user ID in session
        $response["success"] = true;
        $response["message"] = "Login berhasil.";
        header("Location: mainMenu.php");
        exit();
    } else {
        $response["success"] = false;
        $response["message"] = "Login gagal. Periksa kembali username dan password Anda.";
    }
} else {
    $response["success"] = false;
    $response["message"] = "Metode HTTP tidak didukung.";
}

echo json_encode($response);
$conn->close();
?>
