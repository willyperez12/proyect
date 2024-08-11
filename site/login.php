<?php
$file = __DIR__ . '/../Config/Config.php';
require_once 'C:\xampp\htdocs\neumati\Config\Database.php';
$file = __DIR__ . 'site\login1.php';


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
   <link rel="stylesheet" href="css/login.css">

</head>
<body>


<form class="form" action="login1.php" method="POST">
            <span class="input-span">
                <label for="email" class="label">Email</label>
                <input type="email" name="email" id="email" required>
            </span>
            <span class="input-span">
                <label for="password" class="label">Password</label>
                <input type="password" name="password" id="password" required>
            </span>
            <span class="span"><a href="#">Forgot password?</a></span>
            <input class="submit" type="submit" value="Login">
            <span class="span">Don't have an account? <a href="sign up.php">Sign up</a></span>
        </form>
    


</body>
</html>