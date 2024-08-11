function comprarAhora(productId, cantidad) {
    $.ajax({
        type: 'POST',
        url: 'comprar_ahora.php',
        data: {
            id: productId,
            cantidad: cantidad
        },
        success: function(response) {
            // Redirigir al usuario a la página de checkout
            window.location.href = 'checkout.php';
        },
        error: function() {
            alert('Error al procesar la compra');
        }
    });
}

function addProducto(productId, cantidad) {
    $.ajax({
        type: 'POST',
        url: 'agregar_al_carrito.php',
        data: {
            id: productId,
            cantidad: cantidad
        },
        success: function(response) {
            // Actualizar el carrito o mostrar una notificación
            alert('Producto agregado al carrito');
        },
        error: function() {
            alert('Error al agregar el producto al carrito');
        }
    });
}
