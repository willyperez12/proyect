<?php
session_start(); // Iniciar sesión PHP


$file = __DIR__ . '/../Config/Config.php';
require_once 'C:\xampp\htdocs\neumati\Config\Database.php';



if (file_exists($file)) {
    require_once $file;
} else {
    echo "El archivo $file no existe.";
}

$limit = 6; // Número de productos por página
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$productos = Database::getProducts($offset, $limit);

// Verificar si el usuario ha iniciado sesión
// Verificar si el usuario ha iniciado sesión
$loggedIn = isset($_SESSION['email']);
$nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : '';


$limit = 9;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Ordenación por defecto
$orden = !empty($_GET['orden']) ? (int)$_GET['orden'] : 7; // Ordenar por fecha_creacion DESC por defecto

// Construcción de la consulta SQL dinámica
$sql = "SELECT * FROM productos WHERE 1=1";
$params = [];

// Filtros y ordenación (usualmente se aplica en la misma forma que para la lista de productos)
// Puedes agregar aquí cualquier lógica de filtro si es necesario

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
if (isset($ordenes[$orden])) {
    $sql .= " ORDER BY " . $ordenes[$orden];
}

// Aplicar límite y offset para paginación
$sql .= " LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;

// Preparar y ejecutar la consulta para obtener productos
$conn = conectarBD(); // Asegúrate de que esta función esté correctamente definida en tu archivo Database.php
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

$stmt->close();
$conn->close();

?>


<!DOCTYPE html>
<html lang="en">
<head>
<title>Inicio</title>
<meta charset="utf-8">
<link rel="icon" href="img/android-chrome-192x192.png" type="image/x-icon">
<link rel="shortcut icon" href="img/android-chrome-192x192.png" type="image/x-icon" />
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
<link rel="stylesheet" href="css/producto-index.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="css/cart-index.css">


<!--JS-->
<script src="js/jquery.js"></script>
<script src="js/jquery-migrate-1.1.1.js"></script>
<script src="js/superfish.js"></script>
<script src="js/jquery.mobilemenu.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/camera.js"></script>
<script src="js/jquery.ui.totop.js"></script>
<script src="js/script.js" defer></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="js/agregarCarrito.js" defer></script>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownToggle = document.querySelector('.dropdown-toggle');
            const dropdownMenu = document.querySelector('.dropdown-menu');
            
            dropdownToggle.addEventListener('click', function(e) {
                e.preventDefault();
                dropdownMenu.classList.toggle('show');
            });

            document.addEventListener('click', function(e) {
                if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.remove('show');
                }
            });
        });
    </script>

<style>

.title4{
    color:aliceblue;
    font-size: 30px;
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
    
    $(document).ready(function(){
    jQuery('.camera_wrap').camera({
        height: '50%',
        loader: 'none',
        pagination: false,
        thumbnails: false,
        playPause: false,
        navigation: true,
        pauseOnClick: false,
        autoAdvance: true,
        transPeriod: 0, // Elimina la transición
        time: 3000, // Tiempo entre cada imagen
        minHeight: '400px',
        fx: 'fade', // Usa un efecto que no tenga transición si 'fade' causa problemas
        onEnd: function() {
            $('.cameraContent').removeClass('hide'); // Asegúrate de que las imágenes se muestren completamente
        }
    });
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
                        <input type="text" onfocus="if(this.value =='') this.value=''" onblur="if(this.value=='') this.value=''" value="" name="s">
                        <a href="#" onClick="document.getElementById('search').submit()"><img src="img/magnify.png" alt=""></a>
                    </form>
                    <div class="nav-collapse nav-collapse_ collapse">
                        <ul class="nav sf-menu clearfix">
                            <li class="active"><a href="index.php">Inicio</a></li>
                            <li><a href="shop.php">Neumáticos</a></li>
                            <li><a href="index-4.php">Contacto</a></li>
                            <?php if (isset($_SESSION['user_id'])): ?>
    <li class="sub-menu">
        <a href="dashboard.php" class="submenu" data-toggle="dropdown">Hola, <?php echo htmlspecialchars($_SESSION['firstname']); ?> </a>
        <ul class="submenu-1">
            <?php if ($_SESSION['is_admin'] == 1): ?>
                <!-- Admin Dashboard -->
                <li><a href="admin_dashboard.php">Dashboard Admin</a></li>
            <?php elseif ($_SESSION['is_admin'] == 2): ?>
                <!-- Delivery Dashboard -->
                <li><a href="delivery_dashboard.php">Dashboard Delivery</a></li>
            <?php else: ?>
                <!-- General User Dashboard -->
                <li><a href="dashboard.php">Dashboard</a></li>
            <?php endif; ?>
            <li><a href="logout.php">Cerrar sesión</a></li>
        </ul>
    </li>
<?php else: ?>
    <li><a href="login.php">Login</a></li>
<?php endif; ?>

                            <button data-quantity="" class="btn-cart" onclick="location.href='carrito.php'">
                                <div class="carrito"><img src="img/cart-removebg-preview.png" alt=""></div>
                                <title>carrito de compras</title>
                                <path transform="translate(-3.62 -0.85)" d="M28,27.3,26.24,7.51a.75.75,0,0,0-.76-.69h-3.7a6,6,0,0,0-12,0H6.13a.76.76,0,0,0-.76.69L3.62,27.3v.07a4.29,4.29,0,0,0,4.52,4H23.48a4.29,4.29,0,0,0,4.52-4ZM15.81,2.37a4.47,4.47,0,0,1,4.46,4.45H11.35a4.47,4.47,0,0,1,4.46-4.45Zm7.67,27.48H8.13a2.79,2.79,0,0,1-3-2.45L6.83,8.34h3V11a.76.76,0,0,0,1.52,0V8.34h8.92V11a.76.76,0,0,0,1.52,0V8.34h3L26.48,27.4a2.79,2.79,0,0,1-3,2.44Zm0,0"></path>
                                <span class="quantity"></span>
                            </button>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


<section class="gall">
    <div class="pattern" data-src="<?php echo $producto['imagen']; ?>"></div>
    <div class="container">
        <div class="row">
            <article class="span12 slider">
                <div class="camera_wrap">
                    <?php foreach ($productos as $producto): ?>
                       <div data-src="<?php echo $producto['imagen']; ?>"> 
                            <div class="camera-caption">
                                <p class="title1"><?php echo $producto['nombre']; ?> </p>
                                <p class="title4"><?php echo $producto['descripcion']; ?></p>
                                <p class="title3">$<?php echo $producto['precio']; ?></p></a>
                                <a href="#" class="btn btn-info margRight" 
                                   onclick="event.preventDefault(); agregarCarrito(
                                        <?php echo $producto['id']; ?>, 
                                        '<?php echo addslashes($producto['nombre']); ?>', 
                                        '<?php echo addslashes($producto['imagen']); ?>', 
                                        <?php echo $producto['precio']; ?>
                                   )">Agregar</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </article>
        </div>
    </div>
</section>




<br><br><br><br>

<!-- Productos -->
<div class="texto-producto">
    <h1>PRODUCTOS</h1>
</div>

<div class="contenedor">
    <div class="fila">
        <!-- Productos -->
        <div class="columna productos">
            <div class="fila mb-4">
                <?php foreach ($productos as $producto): ?>
                    <div class="columna-33 mb-4">
                    <a href="detalles producto.php?id=<?php echo $producto['id']; ?>">
                    <div class="tarjeta">
                                <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" class="imagen-tarjeta" alt="Producto <?php echo htmlspecialchars($producto['nombre']); ?>">
                                <div class="cuerpo-tarjeta">
                                    <h5 class="titulo-tarjeta"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                                    <p class="texto-tarjeta">$<?php echo number_format($producto['precio'], 2); ?></p>
                                    <button class="btn-carrito" 
                                        onclick="event.preventDefault(); agregarCarrito(
                                            <?php echo $producto['id']; ?>, 
                                            '<?php echo addslashes($producto['nombre']); ?>', 
                                            '<?php echo addslashes($producto['imagen']); ?>', 
                                            <?php echo $producto['precio']; ?>
                                        )">
                                        <span>Agregar a Carrito</span>
                                    </button>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>





<!-- Productos -->

<!--producto-->
<br><br>
    <!--content-->
   
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
<script>
    $('#search a').hover(function(){
        $(this).stop().animate({'opacity':0.5},350, "easeOutSine");
        }, function(){
            $(this).stop().animate({'opacity':1},350, "easeOutSine"); 				 
    })
    $(window).load(function(){
        var curAccord = 0;
        var oldAccord = 0;

        $('._accodList').find('p').slideUp(1);
        $('._accodList').find('._plus').addClass('btnBg1');
        $('._accodList').find('h6').addClass('color1');

        setTimeout(function(){
            $('._accodList > li').eq(0).find('._plus').removeClass('btnBg1');
            $('._accodList > li').eq(0).find('._plus').addClass('btnBg2');
            $('._accodList > li').eq(0).find('p').slideDown();
            $('._accodList > li').eq(0).find('h6').addClass('color2');
        },200)

        $('._accodList').find('._plus, h6').click(
            function(){
                if(curAccord !== $(this).parent().index()){
                    oldAccord = curAccord;
                    curAccord = $(this).parent().index(); 
                    
                    $('._accodList > li').eq(curAccord).find('._plus').removeClass('btnBg1');
                    $('._accodList > li').eq(curAccord).find('._plus').addClass('btnBg2');
                    $('._accodList > li').eq(curAccord).find('h6').removeClass('color1');
                    $('._accodList > li').eq(curAccord).find('h6').addClass('color2');
                    $('._accodList > li').eq(curAccord).find('p').slideDown();
                    
                    $('._accodList > li').eq(oldAccord).find('._plus').removeClass('btnBg2');
                    $('._accodList > li').eq(oldAccord).find('._plus').addClass('btnBg1');
                    $('._accodList > li').eq(oldAccord).find('h6').removeClass('color2');
                    $('._accodList > li').eq(oldAccord).find('h6').addClass('color1');
                    $('._accodList > li').eq(oldAccord).find('p').slideUp();
                }

            }
        )
    }) 
</script>
<script>
    $('#search a').hover(function(){
        $(this).stop().animate({opacity:0.5},350, "easeOutSine");		 
            }, function(){
        $(this).stop().animate({opacity:1},350, "easeOutSine");						 
    })
</script>
<script>
     if($.browser.msie && $.browser.version == 8){ 
            $('._accodList li').css({'margin-bottom':'0'});
        }
</script>
</body>
</html>