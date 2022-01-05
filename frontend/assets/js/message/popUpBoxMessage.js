const boxSearchWrapper = document.querySelector('.content__new-message-box');
const boxSearch = document.querySelector('.content__new-message-box-main');
const openBoxSearchBtns = document.querySelectorAll('.content__openBoxSearchUser');
const closeBoxSearchBtn = document.querySelector('.close');
[...openBoxSearchBtns].forEach(button => {
    button.addEventListener('click', function(e) {
        boxSearchWrapper.classList.toggle('active');
    });
})

closeBoxSearchBtn.addEventListener('click', function(e) {
    boxSearchWrapper.classList.remove('active');
})