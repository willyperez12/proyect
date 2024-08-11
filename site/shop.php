<?php
session_start();

require_once 'C:\xampp\htdocs\neumati\Config\Database.php';
require_once 'C:\xampp\htdocs\neumati\Config\Config.php';

// Verificar si el usuario ha iniciado sesión
$loggedIn = isset($_SESSION['email']);
$nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : '';

// Inicializar variables de filtro si no están definidas
$filtros = [
    'buscar' => '',
    'buscadepartamento' => '',
    'color' => '',
    'buscafechadesde' => '',
    'buscafechahasta' => '',
    'buscapreciodesde' => '',
    'buscapreciohasta' => '',
    'categorias' => [],
    'tamano' => [],
    'tipo' => [],
    'marca' => [],
    'precio' => [],
    'orden' => '',
    'page' => 1
];

foreach ($filtros as $filtro => $valor) {
    if (!isset($_GET[$filtro])) {
        $_GET[$filtro] = $valor;
    }
}

// Configurar paginación
$limit = 9; // Número de productos por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}
$offset = ($page - 1) * $limit;

// Construcción de la consulta SQL dinámica
$sql = "SELECT * FROM productos WHERE 1=1";
$countSql = "SELECT COUNT(*) as total FROM productos WHERE 1=1";
$params = [];

// Filtros de búsqueda
if (!empty($_GET['buscar'])) {
    $aKeyword = explode(" ", $_GET['buscar']);
    $sql .= " AND (LOWER(nombre) LIKE LOWER(?) OR LOWER(descripcion) LIKE LOWER(?))";
    $countSql .= " AND (LOWER(nombre) LIKE LOWER(?) OR LOWER(descripcion) LIKE LOWER(?))";
    $params[] = '%' . $aKeyword[0] . '%';
    $params[] = '%' . $aKeyword[0] . '%';
    for ($i = 1; $i < count($aKeyword); $i++) {
        if (!empty($aKeyword[$i])) {
            $sql .= " OR LOWER(nombre) LIKE LOWER(?) OR LOWER(descripcion) LIKE LOWER(?)";
            $countSql .= " OR LOWER(nombre) LIKE LOWER(?) OR LOWER(descripcion) LIKE LOWER(?)";
            $params[] = '%' . $aKeyword[$i] . '%';
            $params[] = '%' . $aKeyword[$i] . '%';
        }
    }
}

// Filtros de categorías
if (!empty($_GET['categorias']) && is_array($_GET['categorias'])) {
    $categorias = $_GET['categorias'];
    if (!in_array('Todos', $categorias)) {
        $placeholders = rtrim(str_repeat('?,', count($categorias)), ',');
        $sql .= " AND categorias IN ($placeholders)";
        $countSql .= " AND categorias IN ($placeholders)";
        $params = array_merge($params, $categorias);
    }
}

// Filtros de tamaño
if (!empty($_GET['tamaño']) && is_array($_GET['tamaño'])) {
    $tamano = $_GET['tamaño'];
    $placeholders = rtrim(str_repeat('?,', count($tamano)), ',');
    $sql .= " AND tamaño IN ($placeholders)";
    $countSql .= " AND tamaño IN ($placeholders)";
    $params = array_merge($params, $tamano);
}

// Filtros de tipo
if (!empty($_GET['tipo']) && is_array($_GET['tipo'])) {
    $tipo = $_GET['tipo'];
    $placeholders = rtrim(str_repeat('?,', count($tipo)), ',');
    $sql .= " AND tipo IN ($placeholders)";
    $countSql .= " AND tipo IN ($placeholders)";
    $params = array_merge($params, $tipo);
}

// Filtros de marca
if (!empty($_GET['marca']) && is_array($_GET['marca'])) {
    $marca = $_GET['marca'];
    $placeholders = rtrim(str_repeat('?,', count($marca)), ',');
    $sql .= " AND marca IN ($placeholders)";
    $countSql .= " AND marca IN ($placeholders)";
    $params = array_merge($params, $marca);
}

// Filtros de precio
$precios = !empty($_GET['precio']) && is_array($_GET['precio']) ? $_GET['precio'] : [];
if (!empty($precios)) {
    $placeholders = rtrim(str_repeat('?,', count($precios) * 2), ',');
    $sql .= " AND (";
    $countSql .= " AND (";
    $first = true;
    foreach ($precios as $intervalo) {
        list($min, $max) = explode('-', $intervalo);
        if (!$first) {
            $sql .= " OR ";
            $countSql .= " OR ";
        }
        $sql .= " (precio BETWEEN ? AND ?)";
        $countSql .= " (precio BETWEEN ? AND ?)";
        $params[] = $min;
        $params[] = $max;
        $first = false;
    }
    $sql .= ")";
    $countSql .= ")";
}

// Filtros adicionales
if (!empty($_GET['buscadepartamento'])) {
    $sql .= " AND cantidad = ?";
    $countSql .= " AND cantidad = ?";
    $params[] = $_GET['buscadepartamento'];
}
if (!empty($_GET['color'])) {
    $sql .= " AND color = ?";
    $countSql .= " AND color = ?";
    $params[] = $_GET['color'];
}
if (!empty($_GET['buscafechadesde']) && !empty($_GET['buscafechahasta'])) {
    $sql .= " AND fecha BETWEEN ? AND ?";
    $countSql .= " AND fecha BETWEEN ? AND ?";
    $params[] = $_GET['buscafechadesde'];
    $params[] = $_GET['buscafechahasta'];
}
if (!empty($_GET['buscapreciodesde'])) {
    $sql .= " AND precio >= ?";
    $countSql .= " AND precio >= ?";
    $params[] = $_GET['buscapreciodesde'];
}
if (!empty($_GET['buscapreciohasta'])) {
    $sql .= " AND precio <= ?";
    $countSql .= " AND precio <= ?";
    $params[] = $_GET['buscapreciohasta'];
}

// Ordenación
$ordenes = [
    '1' => 'nombre ASC',
    '2' => 'departamento ASC',
    '3' => 'color ASC',
    '4' => 'precio ASC',
    '5' => 'precio DESC',
    '6' => 'fecha_creacion ASC',
    '7' => 'fecha_creacion DESC'
];
if (!empty($_GET['orden']) && isset($ordenes[$_GET['orden']])) {
    $sql .= " ORDER BY " . $ordenes[$_GET['orden']];
} else {
    $sql .= " ORDER BY fecha_creacion DESC";
}

// Aplicar límite y offset para paginación
$sql .= " LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;

// Preparar y ejecutar la consulta para obtener productos
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// Vincular parámetros dinámicamente
$types = str_repeat('s', count($params) - 2) . 'ii';
if ($types) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Almacenar los productos en un array para usarlos en la vista
$productos = [];
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

// Obtener el número total de productos para la paginación
$countStmt = $conn->prepare($countSql);
if ($countStmt === false) {
    die("Count prepare failed: " . $conn->error);
}
$countParams = array_slice($params, 0, -2); // Quitar los últimos dos parámetros (limit y offset)
$countTypes = str_repeat('s', count($countParams));
if ($countTypes) {
    $countStmt->bind_param($countTypes, ...$countParams);
}
$countStmt->execute();
$countResult = $countStmt->get_result();
$total_products = $countResult->fetch_assoc()['total'];
$total_pages = ceil($total_products / $limit);

$stmt->close();
$countStmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
<title>Home</title>
<meta charset="utf-8">
<link rel="icon" href="img/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
<meta name="description" content="Your description">
<meta name="keywords" content="Your keywords">
<meta name="author" content="Your name">
<meta name = "format-detection" content = "telephone=no" />
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--CSS-->
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/responsive.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/camera.css">
<link rel="stylesheet" href="css/estilo.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="<?php echo BASE_URL . 'site\css\productos.css' ; ?>">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="css/footer.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="css/cart-index.css">


<!--JS-->
<script src="js/product.js"></script>
<script src="js/jquery.js"></script>
<script src="js/jquery-migrate-1.1.1.js"></script>
<script src="js/superfish.js"></script>
<script src="js/jquery.mobilemenu.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/camera.js"></script>
<script src="js/jquery.ui.totop.js"></script>
<script src="js/script.js" defer></script>
<script src="js/agregarCarrito.js" defer></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery UI (incluyendo el módulo de slider) -->
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">


<style>
  .custom-button {
    /* Estilos de Tailwind para botón personalizado */
    background-color: #83868a; /* Color de fondo rojo oscuro */
    color:#fff; /* Color del texto en rojo claro */
    border: 0px solid #616161; /* Borde rojo */
    padding: 0.5rem 1rem; /* Espaciado interno */
    border-bottom-width: 4px; /* Grosor del borde inferior */
    font-weight: 500; /* Peso de la fuente */
    border-radius: 0.375rem; /* Radio de borde */
    overflow: hidden; /* Oculta contenido desbordado */
    position: relative; /* Posición relativa para elementos absolutos internos */
    transition-duration: 0.3s; /* Duración de la transición */

  

    /* Efecto de clic */
    &:active {
        opacity: 0.75; /* Reduce la opacidad al hacer clic */
    }

    /* Estilos para el pseudo-elemento de decoración */
    &::before {
        content: ""; /* Contenido vacío para pseudo-elemento */
        background-color: #FF6347; /* Color de fondo del pseudo-elemento */
        box-shadow: 0 0 10px 10px rgba(0, 0, 0, 0.3); /* Sombra del pseudo-elemento */
        position: absolute; /* Posición absoluta para pseudo-elemento */
        width: 80%; /* Ancho del pseudo-elemento */
        height: 5px; /* Altura del pseudo-elemento */
        border-radius: 0.375rem; /* Radio de borde del pseudo-elemento */
        top: -150%; /* Posición inicial superior del pseudo-elemento */
        left: 0; /* Posición inicial izquierda del pseudo-elemento */
        opacity: 0.5; /* Opacidad del pseudo-elemento */
    }

   
}
</style>


<script>
    function agregarCarrito(productId, nombre, imagen, precio) {
        $.ajax({
            type: 'POST',
            url: 'agregar_al_carrito.php',
            data: {
                productId: productId,
                nombre: nombre,
                imagen: imagen,
                precio: precio
            },
            success: function(response) {
                alert('Producto agregado al carrito');
                // Aquí puedes actualizar la UI para reflejar que el producto fue agregado al carrito
            },
            error: function() {
                alert('Error al agregar el producto al carrito');
            }
        });
    }
</script>

<script>
document.querySelector('input[type="reset"]').addEventListener('click', function() {
    // Redirigir a la misma página sin parámetros GET
    window.location.href = window.location.pathname;
});
</script>

<script>
    
    $(document).ready(function(){
        jQuery('.camera_wrap').camera();
        function goToByScroll(id){$('html,body').animate({scrollTop: $("#"+id).offset().top},'slow');}
    });
</script>
<!--[if (gt IE 9)|!(IE)]><!-->
      <script type="text/javascript" src="js/jquery.mobile.customized.min.js"></script>
<!--<![endif]--> 
<!--[if lt IE 8]>
        <div style='text-align:center'><a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="http://www.theie6countdown.com/img/upgrade.jpg"border="0"alt=""/></a></div>  
<![endif]-->
<!--[if lt IE 9]>
  <link rel="stylesheet" href="css/ie.css">
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
<div class="global">
<!--header-->                               

<header>
       <div class="container">
         <div class="navbar navbar_ clearfix">
            <div class="navbar-inner">      
                  <div class="clearfix">
                        <h1 class="brand"><a href="index.php"><img src="img/1_resized.png" alt=""></a></h1>
                        <form id="search" class="search" action="search.php" method="GET" accept-charset="utf-8">
                            <input type="text" onfocus="if(this.value =='' ) this.value=''" onblur="if(this.value=='') this.value=''" value="" name="s">
                            <a href="#" onClick="document.getElementById('search').submit()"><img src="img/magnify.png" alt=""></a>
                        </form>
                        <div class="nav-collapse nav-collapse_ collapse">
                        	<ul class="nav sf-menu clearfix">
                        	  <li class="active"><a href="index.php">Inicio</a></li> 
                              <li><a href="shop.php">Neumáticos</a></li> 
                              <li><a href="index-4.php">Contacto</a></li> 
                           
                            <button data-quantity="0" class="btn-cart" onclick="location.href='carrito.php'">
   <div class="carrito"> <img src="img/cart-removebg-preview.png" alt=""></div>
        <title>carrito de compras</title>
        <path transform="translate(-3.62 -0.85)" d="M28,27.3,26.24,7.51a.75.75,0,0,0-.76-.69h-3.7a6,6,0,0,0-12,0H6.13a.76.76,0,0,0-.76.69L3.62,27.3v.07a4.29,4.29,0,0,0,4.52,4H23.48a4.29,4.29,0,0,0,4.52-4ZM15.81,2.37a4.47,4.47,0,0,1,4.46,4.45H11.35a4.47,4.47,0,0,1,4.46-4.45Zm7.67,27.48H8.13a2.79,2.79,0,0,1-3-2.45L6.83,8.34h3V11a.76.76,0,0,0,1.52,0V8.34h8.92V11a.76.76,0,0,0,1.52,0V8.34h3L26.48,27.4a2.79,2.79,0,0,1-3,2.44Zm0,0"></path>
    </svg>
    <span class="quantity"></span>
</button>

                            </ul>
                          
                        </div>                                                                                                          
                  </div>
             </div>  
         </div>
    </div>   
</header>

<br><br><br><br>

<!--productos-->
<div class="contenedor">
    <div class="fila">
        <div class="columna filtros">
            <h2>Filtros</h2>
            <form method="GET" action="shop.php">
            <div class="grupo-filtros">
            <h4 class="filtro-encabezado">Categorías</h4>
            <ul class="filtro-lista">
                <li><input type="checkbox" name="categorias[]" value="Todos"> Todos</li>
                <li><input type="checkbox" name="categorias[]" value="Neumáticos de Invierno"> Neumáticos de Invierno</li>
                <li><input type="checkbox" name="categorias[]" value="Neumáticos de Verano"> Neumáticos de Verano</li>
                <li><input type="checkbox" name="categorias[]" value="Neumáticos para Todo el Año"> Neumáticos para Todo el Año</li>
                <li><input type="checkbox" name="categorias[]" value="Neumáticos de Alto Rendimiento"> Neumáticos de Alto Rendimiento</li>
                <li><input type="checkbox" name="categorias[]" value="Neumáticos para Camionetas"> Neumáticos para Camionetas</li>
                <li><input type="checkbox" name="categorias[]" value="Neumáticos para SUV"> Neumáticos para SUV</li>
                <li><input type="checkbox" name="categorias[]" value="Neumáticos para Autos de Lujo"> Neumáticos para Autos de Lujo</li>
                <li><input type="checkbox" name="categorias[]" value="Neumáticos para Carreras"> Neumáticos para Carreras</li>
                <li><input type="checkbox" name="categorias[]" value="Neumáticos Ecológicos"> Neumáticos Ecológicos</li>
            </ul>
        </div>
        <div class="grupo-filtros">
            <h4 class="filtro-encabezado">Tamaño</h4>
            <ul class="filtro-lista">
                <li><input type="checkbox" name="tamano[]" value="13"> 13"</li>
                <li><input type="checkbox" name="tamano[]" value="14"> 14"</li>
                <li><input type="checkbox" name="tamano[]" value="15"> 15"</li>
                <li><input type="checkbox" name="tamano[]" value="16"> 16"</li>
                <li><input type="checkbox" name="tamano[]" value="17"> 17"</li>
                <li><input type="checkbox" name="tamano[]" value="18"> 18"</li>
                <li><input type="checkbox" name="tamano[]" value="19"> 19"</li>
                <li><input type="checkbox" name="tamano[]" value="20"> 20"</li>
                <li><input type="checkbox" name="tamano[]" value="21"> 21"</li>
                <li><input type="checkbox" name="tamano[]" value="22"> 22"</li>
                <li><input type="checkbox" name="tamano[]" value="23"> 23"</li>
                <li><input type="checkbox" name="tamano[]" value="24"> 24"</li>
                <li><input type="checkbox" name="tamano[]" value="25"> 25"</li>
                <li><input type="checkbox" name="tamano[]" value="26"> 26"</li>
                <li><input type="checkbox" name="tamano[]" value="27"> 27"</li>
                <li><input type="checkbox" name="tamano[]" value="28"> 28"</li>
                <li><input type="checkbox" name="tamano[]" value="29"> 29"</li>
                <li><input type="checkbox" name="tamano[]" value="30"> 30"</li>
                <li><input type="checkbox" name="tamano[]" value="31"> 31"</li>
                <li><input type="checkbox" name="tamano[]" value="32"> 32"</li>
                <li><input type="checkbox" name="tamano[]" value="33"> 33"</li>
                <li><input type="checkbox" name="tamano[]" value="34"> 34"</li>
                <li><input type="checkbox" name="tamano[]" value="35"> 35"</li>
                <li><input type="checkbox" name="tamano[]" value="36"> 36"</li>
                <li><input type="checkbox" name="tamano[]" value="37"> 37"</li>
                <li><input type="checkbox" name="tamano[]" value="38"> 38"</li>
                <li><input type="checkbox" name="tamano[]" value="39"> 39"</li>
                <li><input type="checkbox" name="tamano[]" value="40"> 40"</li>
            </ul>
        </div>
        <div class="grupo-filtros">
            <h4 class="filtro-encabezado">Tipo</h4>
            <ul class="filtro-lista">
                <li><input type="checkbox" name="tipo[]" value="Radial"> Radial</li>
                <li><input type="checkbox" name="tipo[]" value="Diagonal"> Diagonal</li>
                <li><input type="checkbox" name="tipo[]" value="Tubeless"> Tubeless</li>
                <li><input type="checkbox" name="tipo[]" value="Baldosa"> Baldosa</li>
                <li><input type="checkbox" name="tipo[]" value="Bias Ply"> Bias Ply</li>
                <li><input type="checkbox" name="tipo[]" value="Run Flat"> Run Flat</li>
                <li><input type="checkbox" name="tipo[]" value="All Season"> All Season</li>
                <li><input type="checkbox" name="tipo[]" value="High Performance"> High Performance</li>
                <li><input type="checkbox" name="tipo[]" value="Ultra High Performance"> Ultra High Performance</li>
                <li><input type="checkbox" name="tipo[]" value="Mud Terrain"> Mud Terrain</li>
                <li><input type="checkbox" name="tipo[]" value="All Terrain"> All Terrain</li>
            </ul>
        </div>
                <div class="grupo-filtros">
                    <h4 class="filtro-encabezado">Marca</h4>
                    <ul class="filtro-lista">
                        <?php
                        $marcas = [
                            'Michelin', 'Goodyear', 'Bridgestone', 'Pirelli', 'Continental', 'Hankook', 
                            'Nokian', 'Dunlop', 'Yokohama', 'Toyo', 'Kumho', 'Falken'
                        ];
                        ?>
                        <?php foreach ($marcas as $marca): ?>
                            <li><input type="checkbox" name="marca[]" value="<?php echo htmlspecialchars($marca); ?>"> <?php echo htmlspecialchars($marca); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="grupo-filtros">
    <h4 class="filtro-encabezado">Precio</h4>
    <ul class="filtro-lista">
        <?php
        $intervalos = [
            '0-100' => '0-100',
            '100-200' => '100-200',
            '200-300' => '200-300',
            '400-500' => '400-500'

            // Agrega más intervalos según sea necesario
        ];
        ?>
        <?php foreach ($intervalos as $intervalo => $label): ?>
            <li>
                <input type="checkbox" name="precio[]" value="<?php echo htmlspecialchars($intervalo); ?>"
                    <?php if (in_array($intervalo, $_GET['precio'])) echo 'checked'; ?>>
                <?php echo htmlspecialchars($label); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>        
<input type="submit" value="Filtrar" class="custom-button">
<button type="button" class="custom-button" onclick="resetFilters()">Restablecer Filtros</button>
</form>
<script>
function resetFilters() {
    // Redirigir a la misma página sin parámetros GET
    window.location.href = window.location.pathname;
}
</script>
        </div>
        <!-- Resultados de Productos -->

        <!-- Productos -->

        


        <div class="columna productos">
            <div class="fila mb-4">
                <div class="columna-50">
                    <div class="productot"><h2>Productos</h2></div>
                </div>
                <div class="columna-50 text-right">
                    <!-- Otros elementos de filtrado o selección -->
                </div>
            </div>
            <div class="fila" id="product-container">
                <?php if (!empty($productos)): ?>
                    <?php foreach ($productos as $producto): ?>
                        <div class="columna-33 mb-4">
                            <a href="detalles producto.php?id=<?php echo $producto['id']; ?>">
                                <div class="tarjeta">
                                    <img src="<?php echo $producto['imagen']; ?>" class="imagen-tarjeta" alt="Producto <?php echo $producto['nombre']; ?>">
                                    <div class="cuerpo-tarjeta">
                                        <h5 class="titulo-tarjeta"><?php echo $producto['nombre']; ?></h5>
                                        <p class="texto-tarjeta">$<?php echo $producto['precio']; ?></p> </a>
                                        <button class="btn-carrito"
                                            onclick="agregarCarrito(
                                                '<?php echo $producto['id']; ?>',
                                                '<?php echo $producto['nombre']; ?>',
                                                '<?php echo $producto['imagen']; ?>',
                                                '<?php echo $producto['precio']; ?>'
                                            )">
                                            <span>Agregar a Carrito</span>
                                        </button>
                                    </div>
                                </div>
                           
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay productos disponibles.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!--producto-->



                <!-- Paginación -->
                <div class="pagination">
                    <?php
                    $visible_pages = 5; // Número de páginas visibles en la paginación

                    // Mostrar enlace "Anterior"
                    if ($page > 1) {
                        echo '<a href="shop.php?page=' . ($page - 1) . '">&laquo; Anterior</a>';
                    }

                    // Mostrar páginas según la configuración
                    $start = max(1, $page - floor($visible_pages / 2));
                    $end = min($total_pages, $start + $visible_pages - 1);

                    if ($start > 1) {
                        echo '<a href="shop.php?page=1">1</a>';
                        if ($start > 2) {
                            echo '<span>...</span>';
                        }
                    }

                    for ($i = $start; $i <= $end; $i++) {
                        echo '<a href="shop.php?page=' . $i . '"';
                        if ($i == $page) {
                            echo ' class="active"';
                        }
                        echo '>' . $i . '</a>';
                    }

                    if ($end < $total_pages) {
                        if ($end < $total_pages - 1) {
                            echo '<span>...</span>';
                        }
                        echo '<a href="shop.php?page=' . $total_pages . '">' . $total_pages . '</a>';
                    }

                    // Mostrar enlace "Siguiente"
                    if ($page < $total_pages) {
                        echo '<a href="shop.php?page=' . ($page + 1) . '">Siguiente &raquo;</a>';
                    }
                    ?>
                </div>
          
         
<br><br>

<!--footer-->
<footer>
<div class="container">
        <div class="row">
            <section class="pull-right clearfix">
                <article class="span2 foo-info">
                    <p>9870 St Vincent Place, Glasgow, DC 45 Fr 45.</p>
                </article>
                <article class="span3 foo-info">
                    <p><span>Telephone:</span>+1 800 603 6035<br><br></p>
                </article>
                <article class="span3">
                    <ul>
                        <li><a href="#"><img alt="" src="img/follow_icon1.png"></a></li>
                        <li><a href="#"><img alt="" src="img/follow_icon2.png"></a></li>
                        <li><a href="#"><img alt="" src="img/follow_icon3.png"></a></li>
                        <li><a href="#"><img alt="" src="img/follow_icon4.png"></a></li>
                        <li><a href="#"><img alt="" src="img/follow_icon5.png"></a></li>
                    </ul>
                </article>
            </section>
            <article class="span4 pull-left">
                    <p> Neumático rd &copy; 2024 | Copyright</p>
                </article>
        </div>
        <!-- {%FOOTER_LINK} -->
    </div>   
</footer>
<script src="js/bootstrap.js"></script>
<script src="js/footer.js"></script>



</body>
</html>
