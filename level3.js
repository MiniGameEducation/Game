const question = document.getElementById("question");
const progressText = document.getElementById('progressText');
const progressBarFull = document.getElementById('progressBarFull');
const modalContainer = document.getElementById('modal-container2');
const modalDescription = document.querySelector('.modal__description2');

let currentQuestion = {};
let acceptingAnswer = false;
let questionCounter = 0;
let availableQuestions = [];
let totalScore = 0;

let questions = [
    {
        question: "Change it to the correct past tense verb sentence: John visit his grandparents and help them with their garden.",
        answer: "John visited his grandparents and helped them with their garden"
    },
];

const MAX_QUESTIONS = 1;
const TOTAL_TIME = 120; // 2 minutes in seconds
let timeLeft = TOTAL_TIME;
let timer;

const startGame = () => {
    questionCounter = 0;
    availableQuestions = [...questions];
    getNewQuestion();
    startTimer();
};

const startTimer = () => {
    progressBarFull.style.width = '100%';
    timeLeft = TOTAL_TIME;
    timer = setInterval(() => {
        timeLeft--;
        progressBarFull.style.width = `${(timeLeft / TOTAL_TIME) * 100}%`;
        if (timeLeft <= 0) {
            clearInterval(timer);
            showModal();
        }
    }, 1000);
};

const getNewQuestion = () => {
    if (availableQuestions.length === 0 || questionCounter >= MAX_QUESTIONS) {
        clearInterval(timer);
        showModal();
        return;
    }
    questionCounter++;
    progressText.innerText = `Question ${questionCounter}`;
    const questionIndex = Math.floor(Math.random() * availableQuestions.length);
    currentQuestion = availableQuestions[questionIndex];
    question.innerText = currentQuestion.question;
    availableQuestions.splice(questionIndex, 1);
    acceptingAnswer = true;
};

const showModal = () => {
    modalDescription.innerText = `Your total score is ${totalScore}`;
    modalContainer.classList.add('show-modal2');
};

startGame();
