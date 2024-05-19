const showModal = (triggerId, modalContentId) => {
    const triggerElement = document.getElementById(triggerId);
    const modalContainer = document.getElementById(modalContentId);
    
    if (triggerElement && modalContainer) {
        triggerElement.addEventListener('click', () => {
            modalContainer.classList.add('show-modal');
        });
    }
};

showModal('x', 'modal-container');

const closeBtns = document.querySelectorAll('.close-modal');

const closeModal = () => {
    const modalContainer = document.getElementById('modal-container');
    modalContainer.classList.remove('show-modal');
};

closeBtns.forEach(btn => btn.addEventListener('click', closeModal));
