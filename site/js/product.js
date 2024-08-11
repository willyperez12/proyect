document.addEventListener("DOMContentLoaded", function() {
    const encabezados = document.querySelectorAll(".filtro-encabezado");

    encabezados.forEach(function(encabezado) {
        encabezado.addEventListener("click", function() {
            const lista = this.nextElementSibling;
            lista.classList.toggle("activo");
        });
    });

    const priceRange = document.getElementById('price-range');
    const priceValue = document.getElementById('price-value');

    priceRange.addEventListener('input', function() {
        priceValue.textContent = `$${this.value}`;
    });
});

$(document).ready(function() {
    $('.pagination a').on('click', function(e) {
        e.preventDefault(); // Evitar el comportamiento por defecto del enlace

        var page = $(this).attr('data-page'); // Obtener el número de página desde el atributo data-page
        loadProducts(page); // Cargar productos para la página especificada
    });

    function loadProducts(page) {
        $.ajax({
            url: 'load_products.php', // Ruta del archivo PHP que carga los productos
            type: 'GET',
            data: {page: page},
            success: function(response) {
                $('#product-list').html(response); // Insertar los productos cargados en el contenedor
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }
});

$(document).ready(function() {
    let currentPage = 1;

    function loadProducts(page) {
        $.ajax({
            url: 'fetch_products.php',
            type: 'GET',
            data: { page: page },
            dataType: 'json',
            success: function(response) {
                let products = response.products;
                let totalPages = response.total_pages;

                $('#product-container').empty();
                products.forEach(product => {
                    $('#product-container').append(`
                        <div class="columna-33 mb-4">
                            <div class="tarjeta">
                                <img src="img/1.jpg" class="imagen-tarjeta" alt="Producto ${product.nombre}">
                                <div class="cuerpo-tarjeta">
                                    <h5 class="titulo-tarjeta">${product.nombre}</h5>
                                    <p class="texto-tarjeta">$${product.precio}</p>
                                    <a href="#" class="btn-carrito">Agregar</a>
                                </div>
                            </div>
                        </div>
                    `);
                });

                $('#pagination').empty();
                if (page > 1) {
                    $('#pagination').append(`<a href="#" class="prev" data-page="${page - 1}">&laquo; Anterior</a>`);
                }

                for (let i = 1; i <= totalPages; i++) {
                    $('#pagination').append(`<a href="#" class="page" data-page="${i}"${i == page ? ' class="active"' : ''}>${i}</a>`);
                }

                if (page < totalPages) {
                    $('#pagination').append(`<a href="#" class="next" data-page="${page + 1}">Siguiente &raquo;</a>`);
                }

                currentPage = page;
            }
        });
    }

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let page = $(this).data('page');
        loadProducts(page);
    });

    loadProducts(currentPage);
});

$(document).ready(function() {
    // Función para cargar productos según la página seleccionada
    $('.page-link').on('click', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        
        $.ajax({
            url: 'shop.php',
            type: 'GET',
            data: { page: page },
            success: function(response) {
                $('#product-container').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar productos:', error);
            }
        });
    });
});

$(document).ready(function() {
    // Manejar clics en los filtros
    $('.filtro-lista a').click(function(e) {
        e.preventDefault();
        $(this).toggleClass('activo');
    });

    // Manejar clic en "Aplicar Filtros"
    $('#aplicar-filtros').click(function() {
        // Recolectar filtros seleccionados
        var categorias = obtenerFiltrosSeleccionados('filtro-categorias');
        var tamanos = obtenerFiltrosSeleccionados('filtro-tamanos');
        var tipos = obtenerFiltrosSeleccionados('filtro-tipos');
        var precios = obtenerFiltrosSeleccionados('filtro-precios');

        // Aquí puedes enviar los filtros al servidor (por ejemplo, con AJAX)
        console.log('Categorías seleccionadas:', categorias);
        console.log('Tamaños seleccionados:', tamanos);
        console.log('Tipos seleccionados:', tipos);
        console.log('Precios seleccionados:', precios);
        
        // Simulación de resultados en el frontend
        mostrarResultadosFiltrados(categorias, tamanos, tipos, precios);
    });

    // Función para obtener filtros seleccionados
    function obtenerFiltrosSeleccionados(idGrupo) {
        var filtros = [];
        $('#' + idGrupo + ' a.activo').each(function() {
            filtros.push($(this).data(idGrupo.replace('filtro-', '')));
        });
        return filtros;
    }

    // Función para mostrar resultados filtrados (simulación)
    function mostrarResultadosFiltrados(categorias, tamanos, tipos, precios) {
        // Aquí puedes implementar lógica para mostrar los resultados filtrados
        // Puedes utilizar AJAX para enviar los filtros al servidor y obtener los resultados reales
        var resultadosHtml = '<h3>Resultados Filtrados</h3>';
        resultadosHtml += '<p>Filtros aplicados:</p>';
        resultadosHtml += '<ul>';
        resultadosHtml += '<li>Categorías: ' + categorias.join(', ') + '</li>';
        resultadosHtml += '<li>Tamaños: ' + tamanos.join(', ') + '</li>';
        resultadosHtml += '<li>Tipos: ' + tipos.join(', ') + '</li>';
        resultadosHtml += '<li>Precios: ' + precios.join(', ') + '</li>';
        resultadosHtml += '</ul>';

        $('#resultados').html(resultadosHtml);
    }
});

$(document).ready(function() {
    $('.btn-carrito').click(function(e) {
        e.preventDefault();
        var producto_id = $(this).data('id');

        // Hacer la petición AJAX para agregar el producto al carrito
        $.ajax({
            type: 'POST',
            url: 'agregar_al_carrito.php',
            data: { id_producto: producto_id },
            dataType: 'json', // Esperamos recibir JSON como respuesta
            success: function(response) {
                if (response.success) {
                    alert('Producto agregado al carrito.');
                    // Opcional: Actualizar el contador de productos en el carrito en la interfaz
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Error al agregar el producto al carrito.');
            }
        });
    });
});

   // JavaScript para manejar la adición al carrito
   document.querySelectorAll('.btn-carrito').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const productId = this.getAttribute('data-producto-id');
        // Aquí puedes realizar la lógica para agregar el producto al carrito
        // Por ejemplo, puedes usar fetch para enviar una solicitud al servidor PHP
        fetch(`carrito.php?action=addToCart&id=${productId}`, {
            method: 'GET'
        }).then(response => {
            if (response.ok) {
                // Producto agregado exitosamente al carrito, redirigir al carrito
                window.location.href = 'carrito.php';
            } else {
                console.error('Error al agregar producto al carrito');
            }
        }).catch(error => {
            console.error('Error en la solicitud:', error);
        });
    });
});