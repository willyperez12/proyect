function agregarCarrito(id, nombre, imagen, precio) {
    $.ajax({
        type: 'POST',
        url: 'agregar_al_carrito.php',
        data: {
            id: id,
            nombre: nombre,
            imagen: imagen,
            precio: precio,
            cantidad: 1
        },
        success: function() {
            actualizarTotalCarrito();
        },
        error: function() {
            alert('Error al agregar el producto al carrito');
        }
    });
}


function eliminarDelCarrito(productId) {
    $.ajax({
        type: 'POST',
        url: 'eliminar_del_carrito.php',
        data: {
            productId: productId
        },
        success: function(response) {
            $('#product-' + productId).remove();
            actualizarResumenCarrito();
        },
        error: function() {
            alert('Error al eliminar el producto del carrito');
        }
    });
}

function actualizarResumenCarrito() {
    var subtotal = 0;
    $('.cart-item').each(function() {
        var precioText = $(this).find('.precio').text();
        var precio = parseFloat(precioText.replace('$', '').split(' x ')[0]);
        var cantidad = parseInt($(this).find('.cantidad').text());
        subtotal += precio * cantidad;
    });
    $('.subtotal').text('$' + subtotal.toFixed(2));
    $('.total').text('$' + subtotal.toFixed(2));
}
