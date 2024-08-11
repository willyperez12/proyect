<?php
session_start();
require_once 'C:\xampp\htdocs\neumati\Config\Database.php';
include_once "subir.php";

// Define las opciones para cada campo con todos los datos
$tamanos = [
    '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', 
    '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40'
]; // Puedes agregar más tamaños aquí

$tipos = [
    'Radial', 'Diagonal', 'Tubeless', 'Baldosa', 'Bias Ply', 'Run Flat', 'All Season', 
    'High Performance', 'Ultra High Performance', 'Mud Terrain', 'All Terrain'
]; // Puedes agregar más tipos aquí

$categorias = [
    'Todos', 'Neumáticos de Invierno', 'Neumáticos de Verano', 'Neumáticos para Todo el Año', 
    'Neumáticos de Alto Rendimiento', 'Neumáticos para Camionetas', 'Neumáticos para SUV', 
    'Neumáticos para Autos de Lujo', 'Neumáticos para Carreras', 'Neumáticos Ecológicos'
]; // Puedes agregar más categorías aquí

$marcas = [
    'Michelin', 'Goodyear', 'Bridgestone', 'Pirelli', 'Continental', 'Hankook', 'Nokian', 
    'Dunlop', 'Yokohama', 'Toyo', 'Kumho', 'Falken'
]; // Puedes agregar más marcas aquí
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Subir Producto</title>
    <meta charset="utf-8">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
    <meta name="description" content="Your description">
    <meta name="keywords" content="Your keywords">
    <meta name="author" content="Your name">
    <meta name="format-detection" content="telephone=no" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/camera.css">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="css/producto-index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/pagina de carrito.css">
    <!-- JS -->
    <script src="js/jquery.js"></script>
    <script src="js/jquery-migrate-1.1.1.js"></script>
    <script src="js/superfish.js"></script>
    <script src="js/jquery.mobilemenu.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/camera.js"></script>
    <script src="js/jquery.ui.totop.js"></script>
    <script src="js/script.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .title4 {
            color: aliceblue;
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
                        <h1 class="brand"><a href="index.php"><img src="img/logo.png" alt=""></a></h1>
                        <div class="nav-collapse nav-collapse_ collapse">
                            <!-- Aquí puedes agregar enlaces de navegación si es necesario -->
                        </div>                                                                                                          
                    </div>
                </div>  
            </div>  
        </div>  
    </header>

    <main>
        <h1>Subir Producto</h1>
        <form method="POST" action="subir_producto.php" enctype="multipart/form-data">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required><br>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required></textarea><br>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" required><br>

            <label for="id_categoria">Categoría:</label>
            <select id="id_categoria" name="id_categoria" required>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?php echo htmlspecialchars($categoria); ?>"><?php echo htmlspecialchars($categoria); ?></option>
                <?php endforeach; ?>
            </select><br>

            <label for="tamaño">Tamaño:</label>
            <select id="tamaño" name="tamaño" required>
                <?php foreach ($tamanos as $tamano): ?>
                    <option value="<?php echo htmlspecialchars($tamano); ?>"><?php echo htmlspecialchars($tamano); ?></option>
                <?php endforeach; ?>
            </select><br>

            <label for="tipo">Tipo:</label>
            <select id="tipo" name="tipo" required>
                <?php foreach ($tipos as $tipo): ?>
                    <option value="<?php echo htmlspecialchars($tipo); ?>"><?php echo htmlspecialchars($tipo); ?></option>
                <?php endforeach; ?>
            </select><br>

            <label for="marca">Marca:</label>
            <select id="marca" name="marca" required>
                <?php foreach ($marcas as $marca): ?>
                    <option value="<?php echo htmlspecialchars($marca); ?>"><?php echo htmlspecialchars($marca); ?></option>
                <?php endforeach; ?>
            </select><br>

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen" accept="image/*" required><br>

            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" required><br>

            <input type="submit" value="Subir Producto">
        </form>
    </main>

    <footer>
        <div class="container">
            <div class="row">
                <section class="pull-right clearfix">
                    <article class="span2 foo-info">
                        <p>9870 St Vincent Place, Glasgow, DC 45 Fr 45.</p>
                    </article>
                    <article class="span3 foo-info">
                        <p><span>Telephone:</span>+1 800 603 6035<br><span>FAX:</span>+1 800 889 9898</p>
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
                    <p><img alt="" src="img/footer_logo.png">&copy; 2013 | <a href="index-5.html">Privacy Policy</a></p>
                </article>
            </div>
        </div>   
    </footer>

    <script src="js/bootstrap.js"></script>
    <script>
        $('#search a').hover(function(){
            $(this).stop().animate({'opacity':0.5},350, "easeOutSine");
        }, function(){
            $(this).stop().animate({'opacity':1},350, "easeOutSine"); 
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
            },200);

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

        if($.browser.msie && $.browser.version == 8){ 
            $('._accodList li').css({'margin-bottom':'0'});
        }
    </script>
</div>
</body>
</html>
