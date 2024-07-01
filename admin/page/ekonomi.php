<?php

include "../database/koneksi.php";


// Ambil ID pertanyaan dari parameter URL
$id = isset($_GET['id']) ? $_GET['id'] : 13;

// Query untuk mengambil pertanyaan dan jawaban berdasarkan ID
$sql = "SELECT * FROM question WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $question = $row['question'];
    $answer1 = $row['pilihan_1'];
    $answer2 = $row['pilihan_2'];
    $answer3 = $row['pilihan_3'];
    $answer4 = $row['pilihan_4'];
    $correct = $row['correct_choice'];
} else {
    echo "No results found";
}
$conn->close();
?>

<main class="user-table">
    <form action="../database/update.php" method="post" class="questions_form">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <h1 class="judul">Pertanyaan</h1>
        <input type="text" class="questions" id="question" name="question" value="<?php echo htmlspecialchars($question); ?>">
        
        <h1 class="judul">Jawaban</h1>
        <input type="text" class="answer" id="answer1" name="answer1" value="<?php echo htmlspecialchars($answer1); ?>">
        <input type="text" class="answer" id="answer2" name="answer2" value="<?php echo htmlspecialchars($answer2); ?>">
        <input type="text" class="answer" id="answer3" name="answer3" value="<?php echo htmlspecialchars($answer3); ?>">
        <input type="text" class="answer" id="answer4" name="answer4" value="<?php echo htmlspecialchars($answer4); ?>">
        <h1 class="judul">Correct Answer</h1>
        <input type="text" class="answer" name="correct_choice" id="correct" value="<?php echo htmlspecialchars(($correct)) ?>">
        <div class="checkbox-container">
            <input type="submit" name="update" class="update-button" value="Update">
        </div>
    </form>

</main>
