<!DOCTYPE html>
<html lang="en">
<head>
<title>404</title>
<meta charset="utf-8">
<link rel="icon" href="img/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
<meta name="description" content="Your description">
<meta name="keywords" content="Your keywords">
<meta name="author" content="Your name">
<meta name = "format-detection" content = "telephone=no" />
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<!--CSS-->
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/responsive.css">
<link rel="stylesheet" href="css/style.css">
<!--JS-->
<script src="js/jquery.js"></script>
<script src="js/jquery-migrate-1.1.1.js"></script>
<script src="js/superfish.js"></script>
<script src="js/jquery.mobilemenu.js"></script> 
<script src="js/jquery.ui.totop.js"></script> 
<script>
    function goToByScroll(id){$('html,body').animate({scrollTop: $("#"+id).offset().top},'slow');}
</script> 
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
                        <h1 class="brand"><a href="index.html"><img src="img/logo.png" alt=""></a></h1>
                        <form id="search" class="search" action="search.php" method="GET" accept-charset="utf-8">
                            <input type="text" onfocus="if(this.value =='' ) this.value=''" onblur="if(this.value=='') this.value=''" value="" name="s">
                            <a href="#" onClick="document.getElementById('search').submit()"><img src="img/magnify.png" alt=""></a>
                        </form>
                        <div class="nav-collapse nav-collapse_ collapse">
                        	<ul class="nav sf-menu clearfix">
                        	  <li><a href="index.html">Home</a></li> 
                              <li class="sub-menu"><a href="index-1.html">about<span></span></a>
                                <ul class="submenu">
                                    <li><a href="#">history</a></li>
                                    <li><a href="#">news<span></span></a>
                                        <ul class="submenu-1">
                                            <li><a href="#">latest</a></li>
                                            <li><a href="#">archive</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">testimonials</a></li>
                                </ul>
                              </li> 
                              <li><a href="index-2.html">projects</a></li> 
                              <li><a href="index-3.html">blog</a></li> 
                              <li><a href="index-4.html">contacts</a></li>                       
                            </ul>
                        </div>
                                                                                                                                         
                  </div>
             </div>  
         </div>
    </div>
</header> 
 <!--content-->
 <div class="container padBot">
        <div class="row">
            <article class="span5 offset1 error">
                <img src="img/error.png" alt="">
            </article>
            <article class="span6 error-search">
                <h2>sorry!</h2>
                 <div class="row">
                    <article class="span4">
                        <p class="margBot4">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
                        <p>Please try using our search box below to look for information on the internet.</p>
                        <form id="search-404" class="search" action="search.php" method="GET" accept-charset="utf-8">
                        	 <input type="text" onfocus="if(this.value =='' ) this.value=''" onblur="if(this.value=='') this.value=''" value="" name="s">
                             <a href="#" onClick="document.getElementById('search-404').submit()" class="btn btn-primary">Search</a>
                        </form>
                    </article>
                    
                </div>
                
            </article>
        </div>
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
        $(this).stop().animate({opacity:0.5},350, "easeOutSine");		 
            }, function(){
        $(this).stop().animate({opacity:1},350, "easeOutSine");						 
    })
</script>
</body>
</html>