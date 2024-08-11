<?php
session_start();

$file = __DIR__ . '/../Config/Config.php';
require_once 'C:\xampp\htdocs\neumati\Config\Database.php';
include_once "funciones.php";
$file = __DIR__ . 'C:\xampp\htdocs\neumati\site\obtener_total_carrito.php';




// Obtener los productos del carrito desde la sesión
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : array();

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$carrito = $_SESSION['carrito'];
$subtotal = 0;
$total = 0;

foreach ($carrito as $item) {
    if (isset($item['precio']) && isset($item['cantidad'])) {
        $subtotal += $item['precio'] * $item['cantidad'];
    }
}

$total = $subtotal; // Puedes ajustar esto si hay impuestos u otros cargos
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
<link rel="stylesheet" href="css/producto-index.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="css/pagina de carrito.css">
<link rel="stylesheet" href="css/producto carrito.css">




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

<style>

.title4{
    color:aliceblue;
    font-size: 30px;
}


</style>

<script>
        function goToByScroll(id) {
            $('html,body').animate({scrollTop: $("#" + id).offset().top}, 'slow');
        }
    </script>
    <!--[if lt IE 8]>
        <div style='text-align:center'><a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="http://www.theie6countdown.com/images/upgrade.jpg" border="0" alt=""/></a></div>
    <![endif]-->
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .wrapper {
            flex: 1;
        }

        footer {
            background-color: #f1f1f1;
            padding: 0px;
            text-align: center;
            width: 100%;
        }

        .pagination {
            text-align: center;
            max-width: 1825px;
            margin-top: 20px;
            display: flex;
            justify-content: center;
            overflow-x: auto;
        }

        .pagination a {
            display: inline-block;
            padding: 5px 10px;
            margin-right: 5px;
            text-decoration: none;
            color: #333;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .pagination a.active {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .product-image {
    width: 150px; /* Ajusta el ancho deseado */
    height: 150px; /* Ajusta la altura deseada */
    object-fit: cover; /* Mantiene la proporción de la imagen y la recorta si es necesario */
    display: block;
    margin-bottom: 10px;
}


        .product-item h3 {
            margin: 0;
            font-size: 18px;
        }
    </style>

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
                        <h1 class="brand"><a href="index.php"><img src="img/logo.png" alt=""></a></h1>
                        <form id="search" class="search" action="search.php" method="GET" accept-charset="utf-8">
                            <input type="text" onfocus="if(this.value =='' ) this.value=''" onblur="if(this.value=='') this.value=''" value="" name="s">
                            <a href="#" onClick="document.getElementById('search').submit()"><img src="img/magnify.png" alt=""></a>
                        </form>
                        <div class="nav-collapse nav-collapse_ collapse">
                            <ul class="nav sf-menu clearfix">
                                <li class="active"><a href="index.php">Inicio</a></li>
                                <li><a href="shop.php">Neumáticos</a></li>
                                <li><a href="index-4.php">Contacto</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    




</header>
<br><br><br><br>

    <div class="wrapper">
        <!-- Content -->
        <div class="contenedor">
            <div class="container padBot">
                <div class="row">
                    <article class="span12">
                        <h2>Search Result:</h2>
                        <div id="search-results">
                            <?php
                            if (isset($_GET['s'])) {
                                // Definir constantes de configuración
                              
                                // Crear conexión a la base de datos
                                $conn = new mysqli(HOST, USER, PASS, DB);

                                // Verificar la conexión
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // Establecer el conjunto de caracteres
                                $conn->set_charset(CHARSET);

                                // Limpiar y escapar el término de búsqueda para evitar inyecciones SQL
                                $search_term = $conn->real_escape_string($_GET['s']);

                                // Configurar paginación
                                $results_per_page = 7; // Número de resultados por página
                                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                $start_from = ($page - 1) * $results_per_page;

                                // Construir y ejecutar la consulta SQL con LIMIT
                                $sql = "SELECT * FROM productos WHERE nombre LIKE '%$search_term%' OR descripcion LIKE '%$search_term%' LIMIT $start_from, $results_per_page";
                                $result = $conn->query($sql);

                                // Verificar si se encontraron resultados
                                if ($result->num_rows > 0) {
                                    // Mostrar los resultados de la búsqueda
                                    while ($row = $result->fetch_assoc()) {
                                        // Enlace al detalle del producto con el ID del producto
                                        echo '<div class="product-item">';
                                        echo '<a href="detalles producto.php?id=' . $row['id'] . '">';
                                        // Mostrar imagen del producto
                                        echo '<img src="' . $row['imagen'] . '" alt="' . htmlspecialchars($row["nombre"]) . '" class="product-image">';
                                        // Mostrar nombre y precio
                                        echo '<h3>' . $row["nombre"] . '</h3>';
                                        echo '</a>';
                                        echo 'Precio: ' . $row["precio"] . '<br><br>';
                                        echo '</div>';
                                    }

                                    // Calcular el número total de páginas
                                    $sql_total = "SELECT COUNT(*) AS total FROM productos WHERE nombre LIKE '%$search_term%' OR descripcion LIKE '%$search_term%'";
                                    $result_total = $conn->query($sql_total);
                                    $total_row = $result_total->fetch_assoc();
                                    $total_results = $total_row['total'];
                                    $total_pages = ceil($total_results / $results_per_page);

                                    // Mostrar enlaces de paginación
                                    echo '<div class="pagination">';
                                    for ($i = 1; $i <= $total_pages; $i++) {
                                        if ($i == $page) {
                                            echo '<a href="search.php?s=' . $search_term . '&page=' . $i . '" class="active">' . $i . '</a>';
                                        } else {
                                            echo '<a href="search.php?s=' . $search_term . '&page=' . $i . '">' . $i . '</a>';
                                        }
                                    }
                                    echo '</div>';
                                } else {
                                    echo "No se encontraron resultados para '" . $search_term . "'";
                                }

                                // Cerrar la conexión
                                $conn->close();
                            }
                            ?>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>



<br><br><br><br>
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

