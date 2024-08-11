<?php
session_start();

// Verifica si el usuario está autenticado y es un repartidor
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 2) {
    header("Location: login.php"); // Redirigir al login si no es repartidor
    exit();
}
?>
