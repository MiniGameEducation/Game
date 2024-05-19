const question = document.getElementById("question");
const choices = Array.from(document.getElementsByClassName("choice-text"));
const progressText = document.getElementById('progressText');
const progressBarFull = document.getElementById('progressBarFull');
const modalContainer = document.getElementById('modal-container');
const modalTitle = modalContainer.querySelector('.modal__title');
const answerForm = document.getElementById('answerForm');
const answerInput = document.getElementById('answerInput');
const questionIdInput = document.getElementById('questionIdInput');
const startTimeInput = document.getElementById('startTimeInput');
const totalScoreInput = document.getElementById('totalScoreInput');

let currentQuestion = {};
let acceptingAnswer = false;
let questionCounter = 0;
let availableQuestions = [];
let totalScore = 0;
let timer;
let timeLimit = 30; // 30 seconds per question

let questions = [
    {
        question: "Terjemahkan Kalimat di samping ini ke Bahasa Inggris: 'hari ini hujan'",
        choice1: "It's raining today.",
        choice2: "It's nice weather today.",
        choice3: "It's cloudy today.",
        choice4: "It's snowing today.",
        answer: 1,
        id: 1
    },
    {
        question: "How do you say 'Thank you' in Indonesian?",
        choice1: "Makasih",
        choice2: "Sama Sama",
        choice3: "Matur Suwun",
        choice4: "Terima Kasih",
        answer: 4,
        id: 2
    },
];

const MAX_QUESTIONS = 2;

startGame = () => {
    questionCounter = 0;
    totalScore = 0;
    availableQuestions = [...questions];
    getNewQuestion();
};

getNewQuestion = () => {
    if (availableQuestions.length === 0 || questionCounter >= MAX_QUESTIONS) {
        totalScoreInput.value = totalScore;
        answerForm.submit();
        return;
    }
    questionCounter++;
    progressText.innerText = `Pertanyaan ${questionCounter}/${MAX_QUESTIONS}`;
    progressBarFull.style.width = `${(questionCounter / MAX_QUESTIONS) * 100}%`;

    const questionIndex = Math.floor(Math.random() * availableQuestions.length);
    currentQuestion = availableQuestions[questionIndex];
    question.innerText = currentQuestion.question;

    choices.forEach(choice => {
        const number = choice.dataset['number'];
        choice.innerText = currentQuestion['choice' + number];
    });

    questionIdInput.value = currentQuestion.id;
    availableQuestions.splice(questionIndex, 1);
    acceptingAnswer = true;

    startTimer();
};

startTimer = () => {
    timeLeft = 30; 
    updateTimerDisplay(timeLeft);

    timer = setInterval(() => {
        timeLeft--;
        updateTimerDisplay(timeLeft);

        if (timeLeft <= 0) {
            clearInterval(timer);
            showTimeoutModal();
        }
    }, 1000);
};

updateTimerDisplay = (timeLeft) => {
    progressBarFull.style.width = `${(timeLeft / 30) * 100}%`;
};

const showTimeoutModal = () => {
    modalTitle.innerText = `Waktu Habis!`;
    modalTitle.classList.add('modal__title--big'); // Menambahkan kelas untuk membuat tulisan besar
    modalContainer.classList.add('show-modal');
};

choices.forEach(choice => {
    choice.addEventListener('click', e => {
        if (!acceptingAnswer) return;
        acceptingAnswer = false;
        clearInterval(timer);

        const selectedChoice = e.target;
        const selectedAnswer = selectedChoice.dataset['number'];

        const classToApply = selectedAnswer == currentQuestion.answer ? 'correct' : 'incorrect';

        if (classToApply === 'correct') {
            totalScore += 50;
        }

        selectedChoice.classList.add(classToApply);

        answerInput.value = selectedChoice.innerText;
        questionIdInput.value = currentQuestion.id;
        startTimeInput.value = startTimeInput.value;

        setTimeout(() => {
            selectedChoice.classList.remove(classToApply);
            getNewQuestion();
        }, 1000);
    });
});

document.querySelectorAll('.close-modal').forEach(button => {
    button.addEventListener('click', () => {
        modalContainer.classList.remove('show-modal');
        totalScoreInput.value = totalScore;
        answerForm.submit();
    });
});

startGame();