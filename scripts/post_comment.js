let stars = 1;

/**
 * 
 * @param {int} no 
 */
function sumbitRating(no) {
  if (no > 1 && no < 6) {
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
    return;
  }

  fetch('../server/api/postComment.php', {
    method: 'POST',
    headers: {'content-type': 'application/json'},
    body: JSON.stringify({
      'product_id': parseInt(id),
      'comment_text': text.value,
      'stars': stars,
    }),
  }).then((response)=> {
    response.json().then((json)=> {
      document.getElementById('comments').appendChild(
          newComment(json['stars'], json['date'],
              json['comment_text'])
      );
    });
  });
}
