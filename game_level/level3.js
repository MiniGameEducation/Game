const question = document.getElementById("question");
const choices = Array.from(document.getElementsByClassName("choice-text"));
const progressText = document.getElementById('progressText');
const progressBarFull = document.getElementById('progressBarFull');
const modalContainer = document.getElementById('modal-container2');
const modalDescription = document.querySelector('.modal__description2');

let currentQuestion = {};
let acceptingAnswer = false;
let questionCounter = 0;
let availableQuestions = [];

let questions = [
    {
        question: "Change it to the correct past tense verb sentence : John visit his grandparents and help them with their garden.",
        answer: "John visited his grandparents and helped them with their garden"
    },
];

const MAX_QUESTIONS = 1;
const TOTAL_TIME = 60;
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
            modalContainer.classList.add('show-modal2');
        }
    }, 1000);
};

const getNewQuestion = () => {
    if (availableQuestions.length === 0 || questionCounter >= MAX_QUESTIONS) {
        clearInterval(timer);
        modalContainer.classList.add('show-modal2');
        return;
    }
    questionCounter++;
    progressText.innerText = `Pertanyaan ${questionCounter}`;
    const questionIndex = Math.floor(Math.random() * availableQuestions.length);
    currentQuestion = availableQuestions[questionIndex];
    question.innerText = currentQuestion.question;

    // Since there are no choices to display, remove this block
    // choices.forEach(choice => {
    //     const number = choice.dataset['number'];
    //     choice.value = currentQuestion['choice' + number];
    // });

    availableQuestions.splice(questionIndex, 1);
    acceptingAnswer = true;
};

// Remove event listener for choices as they are not needed for this question type
// choices.forEach(choice => {
//     choice.addEventListener('click', e => {
//         if (!acceptingAnswer) return;
//         acceptingAnswer = false;
//         getNewQuestion();
//     });
// });

startGame();
