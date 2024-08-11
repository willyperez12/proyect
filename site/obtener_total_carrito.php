<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $key => $producto) {
            if ($producto['id'] == $id) {
                unset($_SESSION['carrito'][$key]);
                break;
            }
        }
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
    }
}
?>
