<?php
session_start();

$file = __DIR__ . '/../Config/Config.php';
require_once 'C:\xampp\htdocs\neumati\Config\Database.php';
include_once "funciones.php";
$file = __DIR__ . 'C:\xampp\htdocs\neumati\site\obtener_total_carrito.php';


if (!isset($_SESSION['user_id'])) {
    // Redirigir al usuario a la página de inicio de sesión
    header('Location: login.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['productId'];

    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $key => $producto) {
            if ($producto['id'] == $id) {
                unset($_SESSION['carrito'][$key]);
                break;
            }
        }
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
    }
}

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
                       
                        <div class="nav-collapse nav-collapse_ collapse">
                        	
                                      </ul>
                          
                        </div>                                                                                                          
                  </div>
             </div>  
         </div>
    </div>  
    



</header>
<br><br><br><br><br><br>
<div class="container-1">
    <h1>Tu Carrito de Compras</h1>
    <div class="cart">
        <div class="cart-items">
            <?php if (!empty($carrito)): ?>
                <?php foreach ($carrito as $item): ?>
                    <?php if (isset($item['id'], $item['imagen'], $item['nombre'], $item['precio'], $item['cantidad'])): ?>
                        <div class="cart-item" id="product-<?php echo $item['id']; ?>">
                            <img src="<?php echo $item['imagen']; ?>" alt="Producto <?php echo $item['nombre']; ?>">
                            <div class="cart-item-details">
                                <h5><?php echo $item['nombre']; ?></h5>
                                <p class="precio">$<?php echo number_format($item['precio'], 2); ?> x <span class="cantidad"><?php echo $item['cantidad']; ?></span></p>
                            </div>
                            <button class="btn-eliminar" onclick="eliminarDelCarrito('<?php echo $item['id']; ?>')">Eliminar</button>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>El carrito está vacío.</p>
            <?php endif; ?>
        </div>
        <div class="cart-summary">
            <h2>Resumen de la Orden</h2>
            <div class="summary-item">
                <span>Subtotal</span>
                <span class="subtotal">$<?php echo number_format($subtotal, 2); ?></span>
            </div>
            <div class="summary-item total">
                <span>Total</span>
                <span class="total">$<?php echo number_format($total, 2); ?></span>
            </div>
            <a href="checkout.php"><button class="checkout-button">Proceder al Pago</button></a>
            </div>
    </div>
</div>


<br><br><br><br><br><br>
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

