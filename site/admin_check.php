<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    // Redirige al inicio de sesión si no está autenticado o no es administrador
    header('Location: login.php');
    exit();
}
?>
