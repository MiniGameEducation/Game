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
    question: "Translate the sentences into simple continuous tense : 'Saya sedang membaca buku di perpustakaan' ",
    answer: "i am reading a book in the library",
},

];

const MAX_QUESTIONS = 1;
const TOTAL_TIME = 60;
let timeLeft = TOTAL_TIME;
let timer;
let elapsedTime = 0;

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
        elapsedTime++;
        const minutes = Math.floor(elapsedTime / 60);
        const seconds = elapsedTime % 60;
        progressText.innerText = `${padZero(minutes)}:${padZero(seconds)}`;
        if (timeLeft > 0) {
            timeLeft--; 
            progressBarFull.style.width = `${(timeLeft / TOTAL_TIME) * 100}%`; 
        }
    }, 1000);
};

const padZero = (num) => {
    return (num < 10) ? `0${num}` : num;
};


const getNewQuestion = () => {
    if (availableQuestions.length === 0 || questionCounter >= MAX_QUESTIONS) {
        clearInterval(timer);
        modalContainer.classList.add('show-modal2');
        return;
    }
    questionCounter++;
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
