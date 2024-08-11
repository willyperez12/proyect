<?php
session_start();

// Verificar si el usuario está autenticado y es administrador con valor 1 en is_admin
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 0) {
    header("Location: login.php"); // Redirigir al formulario de login si no está autenticado como administrador con valor 1
    exit();
}
?>
