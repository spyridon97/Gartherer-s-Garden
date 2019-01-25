let stars = 0;

/**
 * 
 * @param {int} no 
 */
function sumbitRating(no) {
  if (no > 0 && no < 6) {
    stars = no;
  }
  // Reset
  for (let i = 1; i<= 5; i++) {
    document.getElementById('star'+i).classList = 'star';
  }
  // Mark the stars
  for (let i = 1; i <= no; i++) {
    document.getElementById('star'+i).classList += ' enabled';
  }
}

/**
 *
 */
function clearErrors() {
  document.getElementById('text').classList = '';
}

/**
 *
 */
function postComment() {
  const text = document.getElementById('text');
  if (text.value.length < 1) {
    text.classList += ' error';
  }

  fetch('../server/api/postComment.php', {
    method: 'POST',
    headers: {'content-type': 'application/json'},
    body: JSON.stringify({
      'product_id': parseInt(getParameter('id')),
      'comment_text': text.value,
      'stars': stars,
    }),
  }).then((response)=> {
    response.json().then((json)=> {
      console.log(json);
    });
  });
}