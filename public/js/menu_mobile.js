var accont = document.querySelector('.user-accont');
var ul = document.querySelector('.accont');
var img = document.querySelector('.img-accont');

accont.addEventListener('mousemove', (event) => {
    accont.style.background = '#fff';
    accont.style.height = '16vh';

    ul.style.display = 'block';
    img.style.display = 'none';
})
accont.addEventListener('mouseout', (event) => {
    accont.style.background = 'rgb(75, 1, 124)';
    accont.style.height = '8vh';

    ul.style.display = 'none';
    img.style.display = 'block';
})