<?php
$file = __DIR__ . '/../Config/Config.php';
require_once 'C:\xampp\htdocs\neumati\Config\Database.php';

if (file_exists($file)) {
    require_once $file;
} else {
    echo "El archivo $file no existe.";
}


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
   <link rel="stylesheet" href="css/sign up.css">

</head>
<body>


<form class="form" action="sign_up_delivery.php" method="POST">
            <p class="title">Register</p>
            <p class="message">Signup now and get full access to our app.</p>
            <div class="flex">
                <label>
                    <input class="input" type="text" name="firstname" placeholder="" required>
                    <span>Firstname</span>
                </label>
                <label>
                    <input class="input" type="text" name="lastname" placeholder="" required>
                    <span>Lastname</span>
                </label>
            </div>
            <label>
                <input class="input" type="email" name="email" placeholder="" required>
                <span>Email</span>
            </label>
            <label>
                <input class="input" type="password" name="password" placeholder="" required>
                <span>Password</span>
            </label>
            <label>
                <input class="input" type="password" name="confirm_password" placeholder="" required>
                <span>Confirm password</span>
            </label>
            <button class="submit" type="submit">Submit</button>
            <p class="signin">Already have an account? <a href="login.php">Signin</a></p>
        </form>
    


</body>
</html>