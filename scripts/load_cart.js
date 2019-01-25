loadCart();

/**
 *
 */
function loadCart() {
  fetch('../server/api/getCart.php').then((response)=> {
    if (response.status == 404) {
      document.getElementById('cart-list').innerHTML = '<p>No products yet added to cart.</p>';
      return;
    }
    response.json().then((json)=> {
      const products = json['products'];
      const quantities = json['quantities'];

      for (let i = 0; i < products.length; i++) {
        document.getElementById('cart-list').appendChild(newProduct(
            products[i]['id'], products[i]['name'], products[i]['sprite'],
            products[i]['price'], quantities[i]
        ));
      }
    });
  });
}

/**
 *
 * @param {int} id
 * @param {string} title
 * @param {location/string} sprite
 * @param {int} price
 * @param {int} quantity
 * @return {HTMLNode}
 */
function newProduct(id, title, sprite, price, quantity) {
  let html = (
    '<img class="sprite" src="..'+sprite+'" alt="sprite" onclick="goToProduct('+id+')"/>'+
        '<div class="info-container" onclick="goToProduct('+id+')">'+
          '<h3>'+title+'</h3>'+
          '<p class="price">'+price+' ADAM</p>'+
        '</div>'+
        '<div class="actions-container">'+
          '<button class="remove-one" onclick="removeOne('+id+')">-</button>'+
          '<p class="quantity">'+quantity+'</p>'+
          '<button class="add-one" onclick="addOne('+id+')">+</button>'+
          '<svg aria-hidden="true" data-prefix="fas" data-icon="trash-alt" class="remove" onclick="remove('+
          id+')" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M0 84V56c0-13.3 10.7-24 24-24h112l9.4-18.7c4-8.2 12.3-13.3 21.4-13.3h114.3c9.1 0 17.4 5.1 21.5 13.3L312 32h112c13.3 0 24 10.7 24 24v28c0 6.6-5.4 12-12 12H12C5.4 96 0 90.6 0 84zm416 56v324c0 26.5-21.5 48-48 48H80c-26.5 0-48-21.5-48-48V140c0-6.6 5.4-12 12-12h360c6.6 0 12 5.4 12 12zm-272 68c0-8.8-7.2-16-16-16s-16 7.2-16 16v224c0 8.8 7.2 16 16 16s16-7.2 16-16V208zm96 0c0-8.8-7.2-16-16-16s-16 7.2-16 16v224c0 8.8 7.2 16 16 16s16-7.2 16-16V208zm96 0c0-8.8-7.2-16-16-16s-16 7.2-16 16v224c0 8.8 7.2 16 16 16s16-7.2 16-16V208z"></path></svg>'+
          '</div>');
  const self = document.createElement('li');
  self.classList = 'cart-product';
  self.id = 'cart_product_'+id;
  self.innerHTML = html;
  return self;
}

/**
 * 
 * @param {int} id 
 */
function addOne(id) { 
  post('../server/api/postCart.php', JSON.stringify({
    'id': id}), (response)=> {
    response.json().then((json)=> {
      const product = json['products'][0];
      const quantity = json['quantities'][0];

      const oldElement = document.getElementById('cart_product_'+product['id']);
      const newElement = newProduct(
          product['id'], product['name'], product['sprite'],
          product['price'], quantity);
      // Replace the element
      oldElement.parentNode.replaceChild(newElement, oldElement);
    });
  });
}

/**
 * 
 * @param {int} id 
 */
function removeOne(id) {
  post('../server/api/deleteFromCartOnce.php', JSON.stringify({
    'id': id}), (response)=> {
    response.json().then((json)=> {
      const product = json['products'][0];
      const quantity = json['quantities'][0];
      if (quantity == 0) {
        const element = document.getElementById('cart_product_'+id);
        element.parentNode.removeChild(element);
        return;
      }
  
      const oldElement = document.getElementById('cart_product_'+product['id']);
      const newElement = newProduct(
          product['id'], product['name'], product['sprite'],
          product['price'], quantity);
      // Replace the element
      oldElement.parentNode.replaceChild(newElement, oldElement);
    });
  });
}

/**
 * 
 * @param {int} id 
 */
function remove(id) {
  post('../server/api/deleteFromCart.php', JSON.stringify({
    'id': id}), (response)=> {
    if (response.status == 200) {
      const element = document.getElementById('cart_product_'+id);
      element.parentNode.removeChild(element);
    }
  });
}

/**
 * 
 * @param {int} id 
 */
function goToProduct(id) {
  window.location.href = './product.html?id='+id;
}

/**
 *
 * @param {URL/string} endpoint
 * @param {JSON/string} body
 */
function post(endpoint, body, handle) {
  fetch(endpoint, {
    method: 'POST',
    headers: {'content-type': 'application/json'},
    body: body,
  }).then(handle);
}
