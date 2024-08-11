<?php
session_start();
define('DB_HOST', 'localhost');
define('DB_NAME', 'neumático rd');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error de conexión: ' . $e->getMessage();
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $orderId = $_POST['order_id'];
    $totalAmount = $_POST['total_amount'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $phone = $_POST['phone'];

    // Crear una nueva orden en la base de datos
    $stmt = $pdo->prepare("INSERT INTO orders (order_id, name, email, address, city, state, zip, phone, total_amount, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$orderId, $name, $email, $address, $city, $state, $zip, $phone, $totalAmount]);

    // Insertar los productos en order_items
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($_SESSION['carrito'] as $item) {
        $stmt->execute([$orderId, $item['id'], $item['cantidad'], $item['precio']]);
    }

    // Vaciar el carrito después de la compra
    unset($_SESSION['carrito']);

    // Redirigir al usuario a la página de confirmación o factura
    header("Location: factura.php?order_id=" . urlencode($orderId));
    exit();
}
?>
