<?php
// Contraseña que quieres encriptar
$password = '123456';

// Encriptar la contraseña
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Mostrar la contraseña encriptada
echo "Contraseña encriptada: " . $hashedPassword;
?>
