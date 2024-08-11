<?php
session_start(); // Iniciar sesión PHP si no está iniciada

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Redirigir al formulario de login si no hay sesión activa
    exit();
}

// Mostrar el contenido del dashboard una vez iniciada la sesión
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
<link rel="stylesheet" href="css/cart-index.css">
<link rel="stylesheet" href="css/dashboard.css">


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
        window.tailwind.config = {
            darkMode: ['class'],
            theme: {
                extend: {
                    colors: {
                        border: 'hsl(var(--border))',
                        input: 'hsl(var(--input))',
                        ring: 'hsl(var(--ring))',
                        background: 'hsl(var(--background))',
                        foreground: 'hsl(var(--foreground))',
                        primary: {
                            DEFAULT: 'hsl(var(--primary))',
                            foreground: 'hsl(var(--primary-foreground))'
                        },
                        secondary: {
                            DEFAULT: 'hsl(var(--secondary))',
                            foreground: 'hsl(var(--secondary-foreground))'
                        },
                        destructive: {
                            DEFAULT: 'hsl(var(--destructive))',
                            foreground: 'hsl(var(--destructive-foreground))'
                        },
                        muted: {
                            DEFAULT: 'hsl(var(--muted))',
                            foreground: 'hsl(var(--muted-foreground))'
                        },
                        accent: {
                            DEFAULT: 'hsl(var(--accent))',
                            foreground: 'hsl(var(--accent-foreground))'
                        },
                        popover: {
                            DEFAULT: 'hsl(var(--popover))',
                            foreground: 'hsl(var(--popover-foreground))'
                        },
                        card: {
                            DEFAULT: 'hsl(var(--card))',
                            foreground: 'hsl(var(--card-foreground))'
                        },
                    },
                }
            }
        }
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

    <style>
        .account-settings-links a.active {
            @apply bg-blue-500 text-white;
        }
        .account-settings-links a:hover {
            @apply bg-blue-200;
        }
        .account-settings-fileinput {
            display: none;
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
        <div class="dashboard-container">
            <div class="container">
                <div class="navbar navbar_ clearfix">
                    <div class="navbar-inner">
                        <div class="clearfix header-content">
                            <h1 class="brand"><a href="index.php"><img src="img/1_resized.png" alt=""></a></h1>
                            <div class="welcome-message">
                                <h1>Bienvenido al Dashboard</h1>
                              <div class="saludo"><p>¡Hola, <?php echo $_SESSION['email']; ?>!</p></div>
                            </div>
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
        </div>
    </header>



<br><br><br><br>



  








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