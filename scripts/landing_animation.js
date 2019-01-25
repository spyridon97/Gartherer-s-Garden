const back = document.getElementById('landing');
const front = document.getElementById('gatherer');

window.addEventListener('scroll', () => {
  back.style.backgroundSize=''+(100 + window.pageYOffset/5)+'%';
});

