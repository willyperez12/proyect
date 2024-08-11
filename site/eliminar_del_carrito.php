<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['productId'];

    // Verificar si el carrito existe en la sesión
    if (isset($_SESSION['carrito'])) {
        // Buscar el producto en el carrito y eliminarlo
        foreach ($_SESSION['carrito'] as $key => $producto) {
            if ($producto['id'] == $productId) {
                unset($_SESSION['carrito'][$key]);
                break;
            }
        }

        // Reindexar el array del carrito
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
    }

    echo json_encode(array('status' => 'success'));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Método no permitido'));
}
?>
