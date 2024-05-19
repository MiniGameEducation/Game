<?php
include 'koneksi.php';

// Mengaktifkan error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["reg_username"]) && isset($_POST["reg_email"]) && isset($_POST["reg_password"]) && isset($_POST["reg_verify_password"])) {
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
            $foto_path = 'uploads/' . $foto_name;

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
        $sql_user = "INSERT INTO user (username, email, password, foto) VALUES (?, ?, ?, ?)";
        $stmt_user = $conn->prepare($sql_user);
        $stmt_user->bind_param("ssss", $reg_username, $reg_email, $reg_password, $foto); // Remove the last 'i' from bind_param

        if ($stmt_user->execute()) {
            header("location: register.php"); // Redirect to registration page
            exit();
        } else {
            $response["success"] = false;
            $response["message"] = "Registration failed. Please try again.";
        }
    } else {
        $response["success"] = false;
        $response["message"] = "Some fields are missing.";
    }
} else {
    $response["success"] = false;
    $response["message"] = "HTTP method not supported.";
}

echo json_encode($response); // Moved this line to the end of the script
$stmt_user->close();
$conn->close();
exit();
?>
