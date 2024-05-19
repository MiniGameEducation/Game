<?php
include 'koneksi.php';

header('Content-Type: application/json');

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reg_username = $_POST["reg_username"];
    $reg_email = $_POST["reg_email"];
    $reg_password = $_POST["reg_password"];
    $reg_verify_password = $_POST["reg_verify_password"];

    // Check if passwords match
    if ($reg_password != $reg_verify_password) {
        $response["success"] = false;
        $response["message"] = "Password and verify password do not match.";
        echo json_encode($response);
        exit();
    }

    // Handle file upload
    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto_tmp_name = $_FILES['foto']['tmp_name'];
        $foto_name = basename($_FILES['foto']['name']);
        $foto_path = '../tampilanUtama/uploads/' . $foto_name;

        // Ensure the 'uploads' directory is writable
        if (!is_dir('uploads')) {
            mkdir('uploads', 0755, true);
        }

        if (move_uploaded_file($foto_tmp_name, $foto_path)) {
            $foto = $foto_path;
        } else {
            $response["success"] = false;
            $response["message"] = "Failed to move the uploaded file.";
            echo json_encode($response);
            exit();
        }
    } else {
        $error_messages = [
            UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
            UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
            UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
            UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.'
        ];

        $response["success"] = false;
        $response["message"] = isset($error_messages[$_FILES['foto']['error']]) ? $error_messages[$_FILES['foto']['error']] : 'Unknown error occurred.';
        echo json_encode($response);
        exit();
    }

    // Insert into the user table
    $sql_user = "INSERT INTO user (username, email, password, foto, score) VALUES ('$reg_username', '$reg_email', '$reg_password', '$foto', 'user')";
    if ($conn->query($sql_user) === TRUE) {
        $response["success"] = true;
        $response["message"] = "Registration successful.";
        header("location: index.php"); // Remove single quotes
        exit();
    } else {
        $response["success"] = false;
        $response["message"] = "Registration failed. Please try again.";
    }
} else {
    $response["success"] = false;
    $response["message"] = "HTTP method not supported.";
}

echo json_encode($response);
$conn->close();
exit();
?>
