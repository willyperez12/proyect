<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $imagen = $_POST['imagen'];
    $cantidad = $_POST['cantidad'];

    // Verificar si el carrito ya existe en la sesión
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Verificar si el producto ya está en el carrito
    $producto_encontrado = false;
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['id'] == $id) {
            // Incrementar la cantidad si el producto ya está en el carrito
            $item['cantidad'] += $cantidad;
            $producto_encontrado = true;
            break;
        }
    }

    // Si el producto no está en el carrito, agregarlo como nuevo
    if (!$producto_encontrado) {
        $_SESSION['carrito'][] = [
            'id' => $id,
            'nombre' => $nombre,
            'precio' => $precio,
            'imagen' => $imagen,
            'cantidad' => $cantidad
        ];
    }

    // Responder con éxito
    echo json_encode(['status' => 'success']);
} else {
    // Responder con error si no es una solicitud POST
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}


?>




