<?php
session_start();

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$carrito = $_SESSION['carrito'];
$subtotal = 0;
$total = 0;

foreach ($carrito as $item) {
    if (isset($item['precio']) && isset($item['cantidad'])) {
        $subtotal += $item['precio'] * $item['cantidad'];
    }
}

$total = $subtotal; // Puedes ajustar esto si hay impuestos u otros cargos
?>