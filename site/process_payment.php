<?php
// Archivo de configuración para la base de datos
require_once 'config.php';

// Crear conexión con la base de datos
$mysqli = new mysqli(HOST, USER, PASS, DB);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Obtener datos del formulario
$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$payment_method = $_POST['payment_method'];

// Inicializar variables para los detalles de pago
$card_number = $expiry_date = $cvv = '';

// Obtener detalles de pago si el método seleccionado es tarjeta
if ($payment_method === 'card') {
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];
}

// Preparar la consulta para insertar el pedido
$stmt = $mysqli->prepare("INSERT INTO orders (name, email, address, city, state, zip, payment_method, card_number, expiry_date, cvv) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param('ssssssssss', $name, $email, $address, $city, $state, $zip, $payment_method, $card_number, $expiry_date, $cvv);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo "<p>Order placed successfully!</p>";
} else {
    echo "<p>Error: " . $stmt->error . "</p>";
}

// Cerrar la conexión
$stmt->close();
$mysqli->close();
?>
