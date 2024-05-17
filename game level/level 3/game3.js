document.addEventListener('DOMContentLoaded', () => {
    const questionElement = document.getElementById('question');
    const answerButtons = document.querySelectorAll('#answer-buttons .btn');
    const nextButton = document.getElementById('next-btn');
    const progressText = document.getElementById('progressText');
    const progressBarFull = document.getElementById('progressBarFull');
    const resultMessage = document.getElementById('resultMessage');
    const restartButton = document.getElementById('restart-btn');

    let currentQuestionIndex = 0;
    let score = 0;

    const questions = [
        {
            question: "What is the capital of France?",
            answers: [
                { text: "Berlin", correct: false },
                { text: "Madrid", correct: false },
                { text: "Paris", correct: true },
                { text: "Rome", correct: false }
            ]
        },
        {
            question: "What is 2 + 2?",
            answers: [
                { text: "3", correct: false },
                { text: "4", correct: true },
                { text: "5", correct: false },
                { text: "6", correct: false }
            ]
        }
        // Tambahkan lebih banyak pertanyaan jika diperlukan
    ];

    function startGame() {
        currentQuestionIndex = 0;
        score = 0;
        resultMessage.style.display = 'none';
        resultMessage.textContent = '';
        restartButton.style.display = 'none';
        answerButtons.forEach(button => button.style.display = 'inline-block');
        nextButton.textContent = 'Next';
        nextButton.style.display = 'none';
        setNextQuestion();
    }

    function setNextQuestion() {
        resetState();
        showQuestion(questions[currentQuestionIndex]);
    }

    function showQuestion(question) {
        questionElement.textContent = question.question;
        progressText.textContent = `Question ${currentQuestionIndex + 1}`;
        progressBarFull.style.width = `${((currentQuestionIndex + 1) / questions.length) * 100}%`;

        question.answers.forEach((answer, index) => {
            const button = answerButtons[index];
            button.textContent = answer.text;
            button.dataset.correct = answer.correct;
            button.addEventListener('click', selectAnswer);
        });
    }

    function resetState() {
        answerButtons.forEach(button => {
            button.classList.remove('correct', 'wrong');
            button.removeEventListener('click', selectAnswer);
        });
        nextButton.style.display = 'none';
    }

    function selectAnswer(e) {
        const selectedButton = e.target;
        const correct = selectedButton.dataset.correct === 'true';
        if (correct) {
            selectedButton.classList.add('correct');
            score++;
        } else {
            selectedButton.classList.add('wrong');
        }
        Array.from(answerButtons).forEach(button => {
            button.removeEventListener('click', selectAnswer);
            if (button.dataset.correct === 'true') {
                button.classList.add('correct');
            }
        });
        nextButton.style.display = 'block';
        if (currentQuestionIndex >= questions.length - 1) {
            nextButton.textContent = 'See Score';
        }
    }

    function showResults() {
        questionElement.textContent = '';
        answerButtons.forEach(button => button.style.display = 'none');
        resultMessage.textContent = `Quiz selesai! Skor Anda: ${score} dari ${questions.length}`;
        resultMessage.style.display = 'block';
        nextButton.style.display = 'none';
        restartButton.style.display = 'block';
    }

    nextButton.addEventListener('click', () => {
        if (currentQuestionIndex >= questions.length - 1) {
            showResults();
        } else {
            currentQuestionIndex++;
            setNextQuestion();
        }
    });

    restartButton.addEventListener('click', startGame);

    startGame();
});
