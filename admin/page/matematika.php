<?php
include "../database/koneksi.php";

// Ambil ID pertanyaan dan level_id dari parameter URL
$id = isset($_GET['id']) ? $_GET['id'] : 31;
$level_id = isset($_GET['level_id']) ? $_GET['level_id'] : 1; // Default level_id jika tidak ada

// Query untuk mengambil pertanyaan dan jawaban berdasarkan ID dan level_id
$sql = "SELECT * FROM question WHERE id = $id AND level_id = $level_id";
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

// Query untuk mengambil semua level
$sql_levels = "SELECT * FROM levels";
$result_levels = $conn->query($sql_levels);
$levels = [];
while ($level_row = $result_levels->fetch_assoc()) {
    $levels[] = $level_row;
}

$conn->close();
?>


<main class="user-table">
        <form action="../database/update.php" method="post" class="questions_form">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <input type="hidden" name="level_id" value="<?php echo htmlspecialchars($level_id); ?>">
            <h1 class="judul">Pertanyaan</h1>
            <input type="text" class="questions" id="question" name="question" value="<?php echo htmlspecialchars($question); ?>">

            <div class="answer_input">
                <div class="answer_input_items">
                    <h1 class="judul">Jawaban</h1>
                    <input type="text" class="answer" id="answer1" name="answer1" value="<?php echo htmlspecialchars($answer1); ?>">
                    <input type="text" class="answer" id="answer2" name="answer2" value="<?php echo htmlspecialchars($answer2); ?>">
                    <input type="text" class="answer" id="answer3" name="answer3" value="<?php echo htmlspecialchars($answer3); ?>">
                    <input type="text" class="answer" id="answer4" name="answer4" value="<?php echo htmlspecialchars($answer4); ?>">
                </div>
                <div class="correct_answer">
                    <h1 class="judul">Correct Answer</h1>
                    <input type="text" class="answer" name="correct_choice" id="correct" value="<?php echo htmlspecialchars($correct); ?>">
                </div>
            </div>
            <div class="checkbox-container">
                <input type="submit" name="update" class="update-button" value="Update">
            </div>
        </form>

        <ul class="linkpages">
            <?php foreach ($levels as $level) : ?>
                <a href="admin.php?page=matematika2&id=<?php echo htmlspecialchars($id); ?>&level_id=<?php echo htmlspecialchars($level['level_id']); ?>" class="link">
                    <li class="linkpages-items"> <?php echo htmlspecialchars($level['level_id']); ?></li>
                </a>
            <?php endforeach; ?>
        </ul>
    </main>