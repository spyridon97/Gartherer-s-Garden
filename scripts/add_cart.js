/**
 *
 */
function addToCart() {
  fetch('../server/api/postCart.php', {
    method: 'POST',
    headers: {'content-type': 'application/json'},
    body: JSON.stringify({
      'id': parseInt(id),
    }),
  }).then((response)=> {
    if (response.status == 200) {
      document.getElementById('added-text').classList = '';
      const button = document.getElementById('add-cart');
      button.classList += 'animate';
      setTimeout(()=> button.classList = '', 2000);
    }
  });
}