const question = document.getElementById("question");
const choices = Array.from(document.getElementsByClassName("choice-text"));
const progressText = document.getElementById('progressText');
const progressBarFull = document.getElementById('progressBarFull');
const modalContainer = document.getElementById('modal-container2');
const modalDescription = document.querySelector('.modal__description2');
const answerForm = document.getElementById('answerForm');
const answerInput = document.getElementById('answerInput');

let currentQuestion = {};
let acceptingAnswer = false;
let questionCounter = 0;
let availableQuestions = [];

let questions = [
    {
        question: "The scientist's groundbreaking research was recognized worldwide. What was the scientist's research recognized for?",
        choice1: "Being innovative globally",
        choice2: "Being recognized globally",
        answer: 2
    },
];

const MAX_QUESTIONS = 1;
const TOTAL_TIME = 45;
let timeLeft = TOTAL_TIME;
let timer;
let elapsedTime = 0;

const startGame = () => {
    questionCounter = 0;
    availableQuestions = [...questions];
    elapsedTime = 0;  // Reset elapsed time
    startTimer();
    getNewQuestion();
};

const startTimer = () => {
    progressBarFull.style.width = '100%';
    timeLeft = TOTAL_TIME;
    timer = setInterval(() => {
        elapsedTime++;
        const minutes = Math.floor(elapsedTime / 60);
        const seconds = elapsedTime % 60;
        progressText.innerText = `${padZero(minutes)}:${padZero(seconds)}`;
        timeLeft--; 
        progressBarFull.style.width = `${(timeLeft / TOTAL_TIME) * 100}%`; // Atur lebar progress bar
        if (timeLeft <= 0) {
            clearInterval(timer);
            showModal();
        }
    }, 1000);
};

const padZero = (num) => {
    return (num < 10) ? `0${num}` : num;
};

const getNewQuestion = () => {
    if (availableQuestions.length === 0 || questionCounter >= MAX_QUESTIONS) {
        clearInterval(timer);
        showModal();
        return;
    }
    questionCounter++;
    const questionIndex = Math.floor(Math.random() * availableQuestions.length);
    currentQuestion = availableQuestions[questionIndex];

    question.innerText = currentQuestion.question;

    choices.forEach(choice => {
        const number = choice.dataset['number'];
        choice.value = currentQuestion['choice' + number];
    });

    availableQuestions.splice(questionIndex, 1);
    acceptingAnswer = true;
};

const showModal = () => {
    modalContainer.classList.add('show-modal2');   
};

choices.forEach(choice => {
    choice.addEventListener('click', e => {
        if (!acceptingAnswer) return;
        acceptingAnswer = false;
        const selectedChoice = e.target;
        const selectedAnswer = selectedChoice.value;
        
        // Set answer input value and submit the form
        answerInput.value = selectedAnswer;
        answerForm.submit();
    });
});

startGame();
