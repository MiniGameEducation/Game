document.addEventListener('DOMContentLoaded', function() {
    const padZero = (num) => {
        return (num < 10) ? `0${num}` : num;
    };

    const progressText = document.getElementById('progressText');
    const progressBarFull = document.getElementById('progressBarFull');

    const TOTAL_TIME = 60;
    let elapsedTime = 0;
    let timer;

    // Fungsi untuk memperbarui tampilan waktu setiap detik
    const updateTimerDisplay = () => {
        elapsedTime++;
        const minutes = Math.floor(elapsedTime / 60);
        const seconds = elapsedTime % 60;
        progressText.innerText = `${padZero(minutes)}:${padZero(seconds)}`;
    };

    // Fungsi untuk memulai timer
    const startTimer = () => {
        timer = setInterval(() => {
            progressBarFull.style.width = `${(1 - (elapsedTime / TOTAL_TIME)) * 100}%`;
            if (elapsedTime >= TOTAL_TIME) {
                clearInterval(timer);
            }
        }, 1000);

        setInterval(updateTimerDisplay, 1000);
    };

    const startGame = () => {
        startTimer();
    };

    startGame();

    // Ambil semua elemen tombol jawaban
    const answerButtons = document.querySelectorAll('.choice-text');

    // Loop melalui setiap tombol jawaban dan tambahkan event listener
    answerButtons.forEach(button => {
        button.addEventListener('click', function() {
            const selectedAnswer = this.value; // Nilai jawaban yang dipilih oleh pengguna
            const correctAnswer = document.getElementById('correct_choice').value; // Nilai jawaban yang benar dari input tersembunyi

            // Memeriksa apakah jawaban pengguna benar atau salah
            if (selectedAnswer === correctAnswer) {
                alert('Jawaban Anda benar!');
            } else {
                alert('Jawaban Anda salah.');
            }

            // Jika Anda ingin melakukan sesuatu setelah pengguna menjawab, tambahkan di sini
            // Contoh: Mengubah tampilan, memperbarui skor, dll.
        });
    });
});
