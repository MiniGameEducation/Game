<?php
include "../database/koneksi.php";

// Ambil ID pertanyaan dari parameter URL
$id = $_GET ['id']??40;

// Query untuk mengambil pertanyaan berdasarkan ID
$sql_question = "SELECT * FROM question WHERE id = $id";
$result_question = $conn->query($sql_question);

if ($result_question->num_rows > 0) {
    $row_question = $result_question->fetch_assoc();
    $question = $row_question['question'];
    $answer1 = $row_question['pilihan_1'];
    $answer2 = $row_question['pilihan_2'];
    $answer3 = $row_question['pilihan_3'];
    $answer4 = $row_question['pilihan_4'];
    $correct = $row_question['correct_choice'];

    // Query untuk mengambil semua level
    $sql_levels = "SELECT * FROM levels";
    $result_levels = $conn->query($sql_levels);
    $levels = [];
    while ($level_row = $result_levels->fetch_assoc()) {
        $levels[] = $level_row;
    }
} else {
    echo "No results found for the selected question ID.";
}

$conn->close();
?>

<main class="user-table">
    <form action="../database/update.php" method="post" class="questions_form">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id ?? ''); ?>">
        <h1 class="judul">Pertanyaan 4</h1>
        <input type="text" class="questions" id="question" name="question" value="<?php echo htmlspecialchars($question ?? ''); ?>">

        <div class="answer_input">
            <div class="answer_input_items">
                <h1 class="judul">Jawaban</h1>
                <input type="text" class="answer" id="answer1" name="answer1" value="<?php echo htmlspecialchars($answer1 ?? ''); ?>">
                <input type="text" class="answer" id="answer2" name="answer2" value="<?php echo htmlspecialchars($answer2 ?? ''); ?>">
               
            </div>
            <div class="correct_answer">
                <h1 class="judul">Correct Answer</h1>
                <input type="text" class="answer" name="correct_choice" id="correct" value="<?php echo htmlspecialchars($correct ?? ''); ?>">
            </div>
        </div>
        <div class="checkbox-container">
            <input type="submit" name="update" class="update-button" value="Update">
        </div>
    </form>

</main>
