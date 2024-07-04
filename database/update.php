<?php
include "../database/koneksi.php";

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the posted data
    $id = $_POST['id'];
    $question = $_POST['question'];
    $answer1 = $_POST['answer1'];
    $answer2 = $_POST['answer2'];
    $answer3 = $_POST['answer3'];
    $answer4 = $_POST['answer4'];
    $correct_choice = $_POST['correct_choice'];

    // Prepare the SQL query to update the question
    $sql = "UPDATE question SET question=?, pilihan_1=?, pilihan_2=?, pilihan_3=?, pilihan_4=?, correct_choice=? WHERE id=?";
    
    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param("ssssssi", $question, $answer1, $answer2, $answer3, $answer4, $correct_choice, $id);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>
                alert('Data berhasil diperbarui');
                  window.history.back();
                window.location.reload();
              </script>";
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Close the connection
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
