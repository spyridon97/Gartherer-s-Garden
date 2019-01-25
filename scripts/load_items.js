/**
 *
 */
class Product {
  /**
   *
   * @param {int} id the id of the element
   * @param {string} sprite name of the file
   * @param {string} bottle name of the file
   * @param {string} name display name
   * @param {Number} price display price in ADAM
   */
  constructor(id, sprite, bottle, name, price) {
    const html = (
      '<div class="flipper">'+
        '<img class="sprite" src=".'+sprite+'"/>'+
        '<img class="bottle" src=".'+bottle+'"/>'+
      '</div>'+
      '<a href="#" class="name">'+name+'</a>'+
      '<p class="price">'+price+' ADAM</p>'
    );
    const self = document.createElement('div');
    self.classList = 'product';
    self.onclick = () => openProductPage(id);
    self.innerHTML = html;
    return self;
  }
}

/* RUNTIME */
let currentPage = 1;

const container = document.getElementById('products-container');
loadProducts('./server/api/getProducts.php');


/**
 * Shows the pages buttons
 * @param {Array[]} paging as specified by the api json
 */
function createPageButtons(paging) {
  const container = document.getElementById('page-number-container');
  // Clear the buttons
  container.innerHTML = (paging.length > 1)
      ? '<button id="last-page-btn">n</button>' : '';

  if (paging.length > 1) {
    const lastPage = document.getElementById('last-page-btn');
    lastPage.innerHTML = paging.length;
    lastPage.classList = (currentPage == paging.length) ? 'selected' : '';
    lastPage.onclick = () => loadPage(paging.length);
  }

  if (paging.length == 3) {
    // create the necessary buttons
    for (let i = 2; i < paging.length; i++) {
      const pageButton = document.createElement('button');
      pageButton.innerHTML = i;
      pageButton.onclick = () => loadPage(i);
      pageButton.classList = (currentPage == i) ? 'selected' : '';
      container.appendChild(pageButton);
    }
  }

  const firstPage = document.createElement('button');
  firstPage.classList = (currentPage == 1) ? 'selected' : '';
  firstPage.innerHTML = 1;
  firstPage.onclick = () => loadPage(1);
  container.appendChild(firstPage);
}

/**
 *
 * @param {int} no the number of the page
 * @param {string} endpoint
 */
function loadPage(no, endpoint) {
  let url;
  if (!endpoint) {
    if (currentPage == no) {
      return;
    }
    url = './server/api/getProducts.php?page='+no;
  } else {
    url = endpoint;
  }

  // Animations make the user happy
  products = document.getElementsByClassName('product');
  for (product of products) {
    product.classList += ' disappear';
  }

  setTimeout(() =>{
    // Clear the current page
    container.innerHTML = '';

    // Load the new items
    loadProducts(url);
    currentPage = no;
  }, 800);
};

/**
 *
 * @param {string} endpoint get request on this endpoint
 */
function loadProducts(endpoint) {
  fetch(endpoint).then((response) =>{
    response.json().then((json) => {
      console.log(json);
      const products = json['products'];

      // Load the products
      for (product of products) {
        container.appendChild(
            new Product(product['id'], product['sprite'], product['bottle'],
                product['name'], product['price']));
      }

      createPageButtons(json['paging']);
    });
  });
}

/**
 *
 */
function onFilterGoPressed() {
  const minPrice = document.getElementById('input_price_min').value;
  const maxPrice = document.getElementById('input_price_max').value;
  const minCast = document.getElementById('input_cast_min').value;
  const maxCast = document.getElementById('input_cast_max').value;
  const plasmid = document.getElementById('input_plasmid').checked;
  const tonic = document.getElementById('input_tonic').checked;
  let type = undefined;

  // Send the type var only if the user has specified one of the types
  if (plasmid && !tonic) {
    type = 'Plasmid';
  } else if (!plasmid && tonic) {
    type = 'Gene Tonic';
  }
  applyFilters(minPrice, maxPrice, minCast, maxCast, type);
  hideFilters();
}

/**
 * 
 * @param {int} minPrice
 * @param {int} maxPrice
 * @param {int} minCasting
 * @param {int} maxCasting
 * @param {string} type
 */
function applyFilters(minPrice, maxPrice, minCasting, maxCasting, type) {
  let requestURL = './server/api/getProducts.php?';
  requestURL += (minPrice) ? 'price_min='+minPrice : '';
  requestURL += (maxPrice) ? '&price_max='+maxPrice : '';
  requestURL += (minCasting) ? '&casting_cost_min='+minCasting : '';
  requestURL += (maxCasting) ? '&casting_cost_max='+maxCasting : '';
  requestURL += (type) ? '&type='+type : '';
  console.log('Sending request:' + requestURL);
  loadPage(1, requestURL);
}

/**
 *
 * @param {int} id the id of the product as sent by the api
 */
function openProductPage(id) {
  if (id < 1) {
    return;
  }

  window.location.href = './pages/product.html?id='+id;
}
