<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact Us</title>
    <meta charset="UTF-8">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <meta name="description" content="Your description">
    <meta name="keywords" content="Your keywords">
    <meta name="author" content="Your name">
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
    <link rel="stylesheet" href="css/contacto.css">
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
                        <h1 class="brand">
                        <h1 class="brand"><a href="index.php"><img src="img/1_resized.png" alt=""></a></h1>
                        </h1>
                        <div class="nav-collapse nav-collapse_ collapse"></div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="form-wrapper">
        <div class="form-container">
            <div class="contacto">
                <h1>Contact Us</h1>
            </div>
            <form class="form" action="send_email.php" method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="form-submit-btn">Send Message</button>
            </form>
        </div>
    </div>

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
</div>
</body>
</html>
