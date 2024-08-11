let preveiwContainer = document.querySelector('.products-preview');
let previewBox = preveiwContainer.querySelectorAll('.preview');

document.querySelectorAll('.products-container .product').forEach(product =>{
  product.onclick = () =>{
    preveiwContainer.style.display = 'flex';
    let name = product.getAttribute('data-name');
    previewBox.forEach(preview =>{
      let target = preview.getAttribute('data-target');
      if(name == target){
        preview.classList.add('active');
      }
    });
  };
});

previewBox.forEach(close =>{
  close.querySelector('.fa-times').onclick = () =>{
    close.classList.remove('active');
    preveiwContainer.style.display = 'none';
  };
});

// Obtener elementos del DOM
const cartIcon = document.getElementById('cart-icon');
const cartDropdown = document.getElementById('cart-dropdown');

// Evento para abrir el menú desplegable al hacer clic en el icono de carrito
cartIcon.addEventListener('click', function() {
    // Alternar la visibilidad del menú desplegable
    if (cartDropdown.style.display === 'block') {
        cartDropdown.style.display = 'none';
    } else {
        cartDropdown.style.display = 'block';
    }
});

// Evento para cerrar el menú desplegable si se hace clic fuera de él
document.addEventListener('click', function(event) {
    if (!cartIcon.contains(event.target) && !cartDropdown.contains(event.target)) {
        cartDropdown.style.display = 'none';
    }
});

document.addEventListener('DOMContentLoaded', () => {
  const cartItems = [
      {
          id: 1,
          name: 'Product 1',
          description: 'Description for product 1',
          price: 20.00,
          quantity: 2,
          image: 'https://via.placeholder.com/100'
      },
      {
          id: 2,
          name: 'Product 2',
          description: 'Description for product 2',
          price: 15.00,
          quantity: 1,
          image: 'https://via.placeholder.com/100'
      }
  ];

  const cartItemsContainer = document.querySelector('.cart-items');
  const subtotalElement = document.querySelector('.subtotal');
  const discountElement = document.querySelector('.discount');
  const shippingElement = document.querySelector('.shipping');
  const totalElement = document.querySelector('.total');

  const renderCartItems = () => {
      cartItemsContainer.innerHTML = '';
      let subtotal = 0;

      cartItems.forEach(item => {
          subtotal += item.price * item.quantity;

          const cartItemElement = document.createElement('div');
          cartItemElement.classList.add('cart-item');

          cartItemElement.innerHTML = `
              <img src="${item.image}" alt="${item.name}">
              <div class="cart-item-details">
                  <h3>${item.name}</h3>
                  <p>${item.description}</p>
                  <p>$${item.price.toFixed(2)}</p>
              </div>
              <div class="cart-item-quantity">
                  <button class="decrease" data-id="${item.id}">-</button>
                  <span>${item.quantity}</span>
                  <button class="increase" data-id="${item.id}">+</button>
              </div>
              <div class="cart-item-price">
                  <p>$${(item.price * item.quantity).toFixed(2)}</p>
              </div>
          `;

          cartItemsContainer.appendChild(cartItemElement);
      });

      subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
      const discount = subtotal * 0.1;  // Example discount calculation
      discountElement.textContent = `$${discount.toFixed(2)}`;
      const shipping = 5.00;
      shippingElement.textContent = `$${shipping.toFixed(2)}`;
      totalElement.textContent = `$${(subtotal - discount + shipping).toFixed(2)}`;
  };

  cartItemsContainer.addEventListener('click', (e) => {
      if (e.target.classList.contains('increase')) {
          const id = parseInt(e.target.dataset.id);
          const item = cartItems.find(item => item.id === id);
          item.quantity++;
          renderCartItems();
      }

      if (e.target.classList.contains('decrease')) {
          const id = parseInt(e.target.dataset.id);
          const item = cartItems.find(item => item.id === id);
          if (item.quantity > 1) {
              item.quantity--;
              renderCartItems();
          }
      }
  });

  renderCartItems();
});

document.addEventListener('DOMContentLoaded', () => {
  const cartItems = [];
  
  const cartItemsContainer = document.querySelector('.cart-items');
  const subtotalElement = document.querySelector('.subtotal');
  const discountElement = document.querySelector('.discount');
  const shippingElement = document.querySelector('.shipping');
  const totalElement = document.querySelector('.total');

  const renderCartItems = () => {
      cartItemsContainer.innerHTML = '';
      let subtotal = 0;

      cartItems.forEach(item => {
          subtotal += item.price * item.quantity;

          const cartItemElement = document.createElement('div');
          cartItemElement.classList.add('cart-item');

          cartItemElement.innerHTML = `
              <img src="${item.image}" alt="${item.name}">
              <div class="cart-item-details">
                  <h3>${item.name}</h3>
                  <p>${item.description}</p>
                  <p>$${item.price.toFixed(2)}</p>
              </div>
              <div class="cart-item-quantity">
                  <button class="decrease" data-id="${item.id}">-</button>
                  <span>${item.quantity}</span>
                  <button class="increase" data-id="${item.id}">+</button>
              </div>
              <div class="cart-item-price">
                  <p>$${(item.price * item.quantity).toFixed(2)}</p>
              </div>
          `;

          cartItemsContainer.appendChild(cartItemElement);
      });

      subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
      const discount = subtotal * 0.1;  // Example discount calculation
      discountElement.textContent = `$${discount.toFixed(2)}`;
      const shipping = 5.00;
      shippingElement.textContent = `$${shipping.toFixed(2)}`;
      totalElement.textContent = `$${(subtotal - discount + shipping).toFixed(2)}`;
  };

  document.addEventListener('click', (e) => {
      if (e.target.classList.contains('add-to-cart')) {
          e.preventDefault();
          const productElement = e.target.closest('.product');
          const id = parseInt(productElement.dataset.id);
          const name = productElement.dataset.name;
          const price = parseFloat(productElement.dataset.price);
          const description = productElement.dataset.description;
          const image = productElement.dataset.image;

          const existingItem = cartItems.find(item => item.id === id);
          if (existingItem) {
              existingItem.quantity++;
          } else {
              cartItems.push({
                  id,
                  name,
                  price,
                  description,
                  image,
                  quantity: 1
              });
          }

          renderCartItems();
      }

      if (e.target.classList.contains('increase')) {
          const id = parseInt(e.target.dataset.id);
          const item = cartItems.find(item => item.id === id);
          item.quantity++;
          renderCartItems();
      }

      if (e.target.classList.contains('decrease')) {
          const id = parseInt(e.target.dataset.id);
          const item = cartItems.find(item => item.id === id);
          if (item.quantity > 1) {
              item.quantity--;
              renderCartItems();
          }
      }
  });

  renderCartItems();
});

 // Función para manejar los clics en los filtros
 document.addEventListener('DOMContentLoaded', function() {
    const filtros = document.querySelectorAll('.filtro-lista a');

    filtros.forEach(filtro => {
        filtro.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Obtener el valor del filtro seleccionado
            const categoria = filtro.getAttribute('data-categoria');
            const tamano = filtro.getAttribute('data-tamano');
            const tipo = filtro.getAttribute('data-tipo');
            const precio = filtro.getAttribute('data-precio');
            
            // Aquí puedes implementar la lógica para filtrar los productos
            // Puedes usar AJAX para llamar a un script PHP que devuelva los productos filtrados
            // Por ahora, simplemente imprimiré los filtros seleccionados en la consola para demostrar
            
            console.log('Categoría:', categoria);
            console.log('Tamaño:', tamano);
            console.log('Tipo:', tipo);
            console.log('Precio:', precio);
            
            // Aquí puedes realizar una petición AJAX para obtener y mostrar los productos filtrados
            // Por ejemplo, usando fetch() o XMLHttpRequest()
        });
    });
});

function limpiarFiltros() {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = false;
    });
}

