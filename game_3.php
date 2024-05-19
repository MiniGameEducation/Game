<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game</title>
    <link rel="stylesheet" href="level2.css">
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
                    <a href="#modal-container" id="x"><i data-feather="x"></i></a>
                    <p id="progressText" class="hud-prefix"></p>
                    <div id="progressBar">
                        <div id="progressBarFull"></div>
                    </div>
                </div>
            </div>
            <form action="level3.php" method="post">
                <h2 id="question">Apa</h2>
                <div class="choice-container">
                    <input type="text" name="answer" class="choice-prefix" placeholder="Masukkan Jawaban Anda">
                </div>
                <input type="hidden" name="start_time" id="start_time">
                <input type="hidden" name="level_id" value="3">
                <input type="submit" class="kirim" value="Kirim">
            </form>
        </div>
    </div>

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

            <h1 class="modal__title2">Skor kamu saat ini : 0</h1>
            <p class="modal__description2"></p>
            <button class="modal_button2 modal_button-width2">
                Level Selanjutnya
            </button>
            <button class="modal__button-link2 close-modal2">Keluar</button>
        </div>
    </div>

    <script>
        feather.replace();

        // Set the start time when the page loads
        document.getElementById('start_time').value = Math.floor(Date.now() / 1000);
    </script>
<script src="level3baru.js"></script>
    <script src="main.js"></script>
</body>

</html>
