let mistakesArray = document.querySelectorAll('.single-mistake');

const toggleHide = (index) => {
    mistakesArray[index].children[1].children[0].classList.toggle('hide');
    mistakesArray[index].children[1].children[1].classList.toggle('hide');
    mistakesArray[index].children[2].classList.toggle('hide');
}

for(let i = 0; i < mistakesArray.length; i++) {
    mistakesArray[i].children[1].children[0].addEventListener('click', e => {
        toggleHide(i);
    })
    mistakesArray[i].children[1].children[1].addEventListener('click', e => {
        toggleHide(i);
    })
}