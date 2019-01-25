let showingImageNo = 1;

/**
 * Loads an image to the carousel
 * @param {int} no the number of the image to load
 */
function loadImage(no) {
  if (showingImageNo == no) {
    return;
  }
  const prevImage = document.getElementById('img'+showingImageNo);
  const image = document.getElementById('img'+no);
  document.getElementById('dot'+showingImageNo).classList = 'dot';
  showingImageNo = no;

  prevImage.classList = 'disappear';
  setTimeout(()=> {
    prevImage.classList = 'none';
    image.classList = '';
    document.getElementById('dot'+no).classList += ' selected';
  }, 500);
}


