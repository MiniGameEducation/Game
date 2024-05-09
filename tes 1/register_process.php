<?php
include 'koneksi.php';

header('Content-Type: application/json');

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reg_username = $_POST["reg_username"];
    $reg_email = $_POST["reg_email"];
    $reg_password = $_POST["reg_password"];
    $reg_verify_password = $_POST["reg_verify_password"];

    if ($reg_password != $reg_verify_password) {
        $response["success"] = false;
        $response["message"] = "Password dan verifikasi password tidak cocok.";
    } else {
        $sql = "INSERT INTO user (username, email, password) VALUES ('$reg_username', '$reg_email', '$reg_password')";

        if ($conn->query($sql) === TRUE) {
            $response["success"] = true;
            $response["message"] = "Pendaftaran berhasil.";
            header("Location: login.php");
            exit();
        } else {
            $response["success"] = false;
            $response["message"] = "Pendaftaran gagal. Silakan coba lagi.";
        }
    }
} else {
    $response["success"] = false;
    $response["message"] = "Metode HTTP tidak didukung.";
}

echo json_encode($response);
$conn->close();
exit();
?>
