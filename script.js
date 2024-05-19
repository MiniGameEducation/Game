const question = document.getElementById("question");
const choices = Array.from(document.getElementsByClassName("choice-text"));
const progressText = document.getElementById('progressText');
const progressBarFull = document.getElementById('progressBarFull');
const answerForm = document.getElementById('answerForm');
const answerInput = document.getElementById('answerInput');

let currentQuestion = {
    question: "Translate the following sentence into French: I want to eat bread.",
    choices: [
        "Je veux manger du pain dans la cuisine.",
        "Ich mache meine Hausaufgaben am Nachmittag.",
        "Je veux manger du pain.",
        "Я получил задание из школы."
    ],
    answer: 3
};

const loadQuestion = () => {
    progressText.innerText = 'Pertanyaan 1';
    progressBarFull.style.width = '100%';
    question.innerText = currentQuestion.question;

    choices.forEach((choice, index) => {
        choice.innerText = currentQuestion.choices[index];
    });
};

choices.forEach(choice => {
    choice.addEventListener('click', e => {
        const selectedChoice = e.target;
        const selectedAnswer = selectedChoice.dataset["number"];

        answerInput.value = selectedAnswer;
        answerForm.submit();
    });
});

loadQuestion();
