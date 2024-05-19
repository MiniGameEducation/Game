<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game</title>
    <link rel="stylesheet" href="level1.css"
    .css">
    
    <!-- Feathericons -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>
    <div class="container">
        <div id="game" class="justify-center flex-column">
            <div id="hud">
                <div id="hud-item">
                    <a href="#modal-container" id="x"><i data-feather="x"></i></a>
                    <p id="progressText" class="hud-prefix"></p>
                    <div id="progressBar">
                        <div id="progressBarFull" class="progressBarFull"></div>
                    </div>
                </div>
            </div>
            <h2 id="question">Translate the following sentence into Indonesian: I want to eat bread.</h2>
            <div class="choice-container">
                <input type="button" class="choice-prefix" value="A">
                <input type="button" class="choice-text" data-number="1" value="Aku ingin tidur dikamar">
            </div>
            <div class="choice-container">
                <input type="button" class="choice-prefix" value="B">
                <input type="button" class="choice-text" data-number="2" value="Aku ingin makan di Ruang tamu">
            </div>
            <div class="choice-container">
                <input type="button" class="choice-prefix" value="C">
                <input type="button" class="choice-text" data-number="3" value="Aku ingin makan roti">
            </div>
            <div class="choice-container">
                <input type="button" class="choice-prefix" value="D">
                <input type="button" class="choice-text" data-number="4" value="Aku ingin bermain di Dapur">
            </div>
            
            <div class="modal__container" id="modal-container">
                <div class="modal__content">
                    <div class="modal__close close-modal" title="Close">
                        
                    </div>
                    <img src="gmbr.png" alt="" class="modal__img">
                    <h1 class="modal__title">Semoga bisa main bareng lagi segera! Jaga diri dan sampai ketemu!</h1>
                    
                    <button class="modal_button modal_button-width">Lanjutkan</button>
                    <button class="modal__button-link close-modal">Keluar</button>
                </div>
            </div>
        </div>
    </div>
    <form id="answerForm" method="POST" action="../database/process.php" style="display: none;">
        <input type="hidden" name="answer" id="answerInput">
        <input type="hidden" name="start_time" id="startTimeInput" value="<?php echo time(); ?>">
        <input type="hidden" name="question_id" id="questionIdInput" value="1"> 
        <input type="hidden" name="level_id" id="levelIdInput" value="1"> 
    </form>
    <script>
        feather.replace();
    </script>
    <!-- Main JS -->
    <script src="main.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const choiceButtons = document.querySelectorAll('.choice-text');
    const startTime = Math.floor(Date.now() / 1000); // Get the current time in seconds

    choiceButtons.forEach(button => {
        button.addEventListener('click', function() {
            const answer = this.value;
            document.getElementById('answerInput').value = answer;
            document.getElementById('startTimeInput').value = startTime;
            document.getElementById('answerForm').submit();
        });
    });
});
</script>

</body>
</html>
