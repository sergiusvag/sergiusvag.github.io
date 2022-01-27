let adminShowBtn = document.querySelector('.admin-panel-btn_show');
let adminNewBtn = document.querySelector('.admin-panel-btn_new');
let adminmistakeBtn = document.querySelector('.admin-panel-btn_mistake');
let formShow = document.querySelector('.form-question_show');
let formNew = document.querySelector('.form-question_new');
let formmistake = document.querySelector('.form-question_mistake');
let formAll = document.querySelectorAll('.form-question');

let messageDiv = document.querySelectorAll('.message');

function hideAllForms() {
    for(let i = 0; i < formAll.length; i++) {
        formAll[i].classList.add('hide');
    }
    for(let i = 0; i < messageDiv.length; i++) {
        console.log(messageDiv);
        messageDiv[i].classList.add('hide');
    }
}

adminShowBtn.addEventListener('click', () => {
    hideAllForms();
    formShow.classList.remove('hide');
})

adminNewBtn.addEventListener('click', () => {
    hideAllForms();
    formNew.classList.remove('hide');
})

adminmistakeBtn.addEventListener('click', () => {
    hideAllForms();
    formmistake.classList.remove('hide');
})
