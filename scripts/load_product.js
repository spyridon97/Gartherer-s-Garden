const id = getParameter('id');

loadProductInfo(id);
loadComments(id);

/**
 *
 * @param {int} id the id of the product
 */
function loadProductInfo(id) {
  fetch('../server/api/getProduct.php?id='+id).then((response) =>{
    response.json().then((json) => {
      // Populate html
      const image = document.getElementById('adv_img');
      if (json['ad']) {
        image.src = '..'+json['ad'];
      } else {
        image.parentElement.removeChild(image);
      }
      document.getElementsByClassName('quote')[0].innerHTML = json['quote'];

      document.getElementById('title').innerHTML = json['name'];
      document.title = json['name'];
      document.getElementById('effect').innerHTML = json['effect'];

      for (elem of document.getElementsByClassName('type')) {
        elem.innerHTML += json['type'];
      }
      document.getElementById('casting-cost').innerHTML += json['casting_cost'];
      document.getElementById('price').innerHTML += json['price']+' ADAM';
      document.getElementById('img1').src = '..'+json['bottle'];
      document.getElementById('img2').src = '..'+json['sprite'];
    });
  });
};

/**
 *
 * @param {int} id the id of the product
 */
function loadComments(id) {
  fetch('../server/api/getComments.php?product_id='+id).then((response) =>{
    response.json().then((json) => {
      const comments = json['comments'];
      if (!comments) {
        const noComments = document.createElement('p');
        noComments.innerHTML = 'no comments yet.';
        document.getElementById('comments').appendChild(noComments);
        return;
      }
      for (comment of comments) {
        document.getElementById('comments').appendChild(
            newComment(comment['stars'], comment['date'],
                comment['comment_text'])
        );
      }
    });
  });
};

/**
 *
 * @param {int} stars as a number
 * @param {string} date as specified by the api
 * @param {string} text comment body
 * @return {HTMLNode} the created element
 */
function newComment(stars, date, text) {
  let html = (
    '<div class="header">'+
      '<div class="stars">');

  for (let star=0; star < 5; star++) {
    html += '<svg aria-hidden="true" data-prefix="fas" data-icon="star" class="star';
    // Append the necessary class
    if (star < stars) {
      html += ' enabled';
    }
    html += '" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path></svg>';
  }

  html += (
    '</div>'+
    '<p><span class="emp">Posted on: </span>'+date+'</p>'+
    '</div>'+
    '<p class="text">'+text+'</p>'
  );

  const self = document.createElement('div');
  self.classList = 'comment';
  self.innerHTML = html;

  return self;
}

/**
 * Taken kindly from https://stackoverflow.com/questions/831030/how-to-get-get-request-parameters-in-javascript
 * @param {string} name the name of the parameter
 * @return {*} the parameter's value
 */
function getParameter(name) {
  if (name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)'))
      .exec(location.search)) {
    return decodeURIComponent(name[1]);
  }
}
