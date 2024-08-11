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
    // Obtener datos del formulario
    $orderId = $_POST['order_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $address = $_POST['address'] ?? '';
    $city = $_POST['city'] ?? '';
    $state = $_POST['state'] ?? '';
    $zip = $_POST['zip'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $total_amount = $_POST['total_amount'] ?? '';

    // Verificar si el orderId es válido y existe en la base de datos
    if (!$orderId || !$name || !$email || !$address || !$city || !$state || !$zip || !$phone || !$total_amount) {
        echo 'Datos incompletos.';
        exit();
    }

    // Obtener el carrito de la sesión
    $carrito = $_SESSION['carrito'] ?? [];

    // Insertar la orden en la base de datos
    $stmt = $pdo->prepare("INSERT INTO orders (order_id, name, email, address, city, state, zip, phone, total_amount) VALUES (:order_id, :name, :email, :address, :city, :state, :zip, :phone, :total_amount)");
    $stmt->execute([
        ':order_id' => $orderId,
        ':name' => $name,
        ':email' => $email,
        ':address' => $address,
        ':city' => $city,
        ':state' => $state,
        ':zip' => $zip,
        ':phone' => $phone,
        ':total_amount' => $total_amount
    ]);

    // Insertar los productos en order_items
    foreach ($carrito as $item) {
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)");
        $stmt->execute([
            ':order_id' => $orderId,
            ':product_id' => $item['id'],
            ':quantity' => $item['cantidad'],
            ':price' => $item['precio']
        ]);
    }

    // Vaciar el carrito de la sesión
    unset($_SESSION['carrito']);

    echo 'success';
} else {
    echo 'Invalid request method.';
}
?>
