<?php
// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "neumático rd";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recuperar detalles del producto
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT * FROM productos WHERE id = $product_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    echo "Producto no encontrado.";
    exit();
}

// Recuperar imágenes del producto
$sql_images = "SELECT * FROM producto_imagenes WHERE producto_id = $product_id";
$result_images = $conn->query($sql_images);

$images = [];
if ($result_images->num_rows > 0) {
    while($row = $result_images->fetch_assoc()) {
        $images[] = $row['imagen'];
    }
}

// Cerrar conexión
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Detalles del Producto</title>
    <meta charset="UTF-8">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <meta name="description" content="Detalles del producto">
    <meta name="keywords" content="productos, detalles">
    <meta name="author" content="Tu Nombre">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSS-->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/camera.css">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="css/producto-index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/detalles producto.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">    
    <!--JS-->
    <script src="js/jquery.js"></script>
    <script src="js/jquery-migrate-1.1.1.js"></script>
    <script src="js/superfish.js"></script>
    <script src="js/jquery.mobilemenu.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/camera.js"></script>
    <script src="js/jquery.ui.totop.js"></script>
    <script src="js/script.js" defer></script>
    
    <style>
        .title4 {
            color: aliceblue;
            font-size: 30px;
        }
    </style>
    <script>
        $(document).ready(function(){
            jQuery('.camera_wrap').camera();
            function goToByScroll(id) {
                $('html, body').animate({ scrollTop: $("#" + id).offset().top }, 'slow');
            }
        });
    </script>
    <!--[if (gt IE 9)|!(IE)]><!-->
    <script type="text/javascript" src="js/jquery.mobile.customized.min.js"></script>
    <!--<![endif]-->
    <!--[if lt IE 8]>
        <div style='text-align:center'>
            <a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode">
                <img src="http://www.theie6countdown.com/img/upgrade.jpg" border="0" alt=""/>
            </a>
        </div>
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
                        <div class="nav-collapse nav-collapse_ collapse"></div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <br><br><br><br><br>
    <!--contenido-->
    <section class="product-details">
        <div class="container">
            <div class="row">
                <!-- Slider de imágenes -->
                <div class="col-md-6">
                    <div id="productCarousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php foreach ($images as $index => $image): ?>
                                <li data-target="#productCarousel" data-slide-to="<?php echo $index; ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>"></li>
                            <?php endforeach; ?>
                        </ol>
                        <div class="carousel-inner">
                            <?php foreach ($images as $index => $image): ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <img src="<?php echo $image; ?>" class="d-block w-100" alt="Imagen <?php echo $index + 1; ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <a class="carousel-control-prev" href="#productCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#productCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>

                <!-- Detalles del producto -->
                <div class="col-md-6">
                    <h2 class="product-title"><?php echo htmlspecialchars($product['nombre']); ?></h2>
                    <p class="product-description"><?php echo htmlspecialchars($product['descripcion']); ?></p>
                    <div class="product-price">$<?php echo number_format($product['precio'], 2); ?></div>
                    <div class="product-quantity">Cantidad: <?php echo htmlspecialchars($product['cantidad']); ?></div>
                    <div class="product-brand">Marca: <?php echo htmlspecialchars($product['marca']); ?></div>
                    <div class="product-type">Tipo: <?php echo htmlspecialchars($product['tipo']); ?></div>
                    <div class="product-size">Tamaño: <?php echo htmlspecialchars($product['tamaño']); ?></div>
                    <div class="product-category">Categoría: <?php echo htmlspecialchars($product['categorias']); ?></div>
                    <button class="btn-carrito" onclick="agregarCarrito()">Agregar al Carrito</button>
                </div>
            </div>
           <br><br><br><br><br>
    </section>
    <!--fin del contenido-->
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
            $(this).stop().animate({'opacity':0.5}, 350, "easeOutSine");
        }, function(){
            $(this).stop().animate({'opacity':1}, 350, "easeOutSine");
        });
        
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
            }, 200);

            $('._accodList').find('._plus, h6').click(function(){
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
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script></script>
</div>
</body>
</html>
