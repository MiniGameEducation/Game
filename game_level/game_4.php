<?php
include '../database/koneksi.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];
$level_id = isset($_POST['level_id']) ? intval($_POST['level_id']) : 4; // Ubah $_GET menjadi $_POST jika Anda mengirimkannya melalui POST

// Query to fetch last_selected_kategori_id
$sql_kategori = "SELECT last_selected_kategori_id FROM user WHERE id = ?";
$stmt_kategori = $conn->prepare($sql_kategori);
$stmt_kategori->bind_param("i", $user_id);
$stmt_kategori->execute();
$stmt_kategori->bind_result($last_selected_kategori_id);
$stmt_kategori->fetch();
$stmt_kategori->close();

// Validate last_selected_kategori_id
if (!$last_selected_kategori_id) {
    die("Kategori tidak valid.");
}

// Query to fetch questions based on kategori_id and level_id
$sql_questions = "SELECT id, question, pilihan_1, pilihan_2, pilihan_3, pilihan_4, correct_choice 
                  FROM question 
                  WHERE kategori_id = ? AND level_id = ?";

$stmt_questions = $conn->prepare($sql_questions);
$stmt_questions->bind_param("ii", $last_selected_kategori_id, $level_id); // Mengikat dua integer parameters
$stmt_questions->execute();
$result_questions = $stmt_questions->get_result();
$stmt_questions->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game</title>
    <link rel="icon" type="image/x-icon" href="../img/Ratsel.png" />
    <link rel="stylesheet" href="level1.css">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Changa+One:ital@0;1&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div id="game" class="justify-center flex-column">
            <div id="hud">
                <div id="hud-item">
                    <a href="user.php" id="x"><i data-feather="x"></i></a>
                    <p id="progressText" class="hud-prefix"></p>
                    <div id="progressBar">
                        <div id="progressBarFull"></div>
                    </div>
                </div>
            </div>
            <?php while ($question_data = $result_questions->fetch_assoc()): ?>
                <h2 id="question"><?php echo htmlspecialchars($question_data['question']); ?></h2>
            <div class="choice-container">
                <input type="button" class="choice-prefix" value="A">
                <input type="button" class="choice-text" data-number="1" value="<?php echo htmlspecialchars($question_data['pilihan_1']); ?>">
            </div>
            <div class="choice-container">
                <input type="button" class="choice-prefix" value="B">
                <input type="button" class="choice-text" data-number="2" value="<?php echo htmlspecialchars($question_data['pilihan_2']); ?>">
            </div>
        </div>
    </div>
<?php endwhile; ?>
    <div class="modal__container" id="modal-container">
        <div class="modal__content">
            <div class="modal__close close-modal" title="Close"></div>
            <img src="gmbr.png" alt="" class="modal__img">
            <h1 class="modal__title">Semoga bisa main bareng lagi segera! Jaga diri dan sampai ketemu!</h1>
            <button class="modal__button-link">Keluar</button>
            <button class="modal__button-link close-modal">Lanjutkan</button>
        </div>
    </div>

    <div class="modal__container2" id="modal-container2">
        <div class="modal__content2">
            <div class="modal__close2 close-modal2" title="Close2"></div>
        </div>
    </div>

    <form id="answerForm" method="POST">
    <input type="hidden" name="answer" id="answerInput">
    <input type="hidden" name="start_time" id="startTimeInput" value="<?php echo time(); ?>">
    <input type="hidden" name="kategori_id" id="kategoriIdInput" value="<?php echo htmlspecialchars($last_selected_kategori_id); ?>"> 
    <input type="hidden" name="question_id" id="questionIdInput" value="<?php echo htmlspecialchars($question_data['id'] ?? ''); ?>"> 
    <input type="hidden" name="level_id" id="levelIdInput" value="<?php echo htmlspecialchars($level_id); ?>"> 
        </form>
        <script>
    feather.replace();
</script>
<script src="level1.js"></script>
        <script>
    document.addEventListener('DOMContentLoaded', function() {
        const choiceButtons = document.querySelectorAll('.choice-text');
        const startTime = Math.floor(Date.now() / 1000);
    
        choiceButtons.forEach(button => {
            button.addEventListener('click', function() {
                console.log('Event listener dipanggil'); // Tambahkan ini untuk memeriksa apakah event listener terpanggil saat tombol diklik
                const answer = this.value;
                document.getElementById('answerInput').value = answer;
                document.getElementById('startTimeInput').value = startTime;
    
                // Kirim data jawaban menggunakan AJAX
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'process.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        // Tanggapan dari process.php
                        const response = JSON.parse(xhr.responseText);
                        if (response.status === 'success') {
                            // Jika jawaban berhasil diproses, redirect ke halaman user.php
                            window.location.href = 'user.php';
                        } else {
                            // Jika terjadi kesalahan, tampilkan pesan kesalahan
                            document.getElementById('game').innerHTML += '<p class="error">Terjadi kesalahan: ' + response.message + '</p>';
                        }
                    } else {
                        // Jika terjadi kesalahan saat melakukan permintaan, tampilkan pesan kesalahan
                        document.getElementById('game').innerHTML += '<p class="error">Terjadi kesalahan saat mengirim permintaan.</p>';
                    }
                };
                const formData = new FormData(document.getElementById('answerForm'));
                xhr.send(new URLSearchParams(formData));
            });
        });
    });
</script>
    
</body>

</html>