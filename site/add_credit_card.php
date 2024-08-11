<?php
session_start();
$file = __DIR__ . '/../Config/Config.php';
require_once 'C:\xampp\htdocs\neumati\Config\Database.php'; // Asegúrate de que esta ruta sea correcta


// Verificar si el usuario está conectado
if (!isset($_SESSION['user_id'])) {
    die("Usuario no autenticado. Inicie sesión para continuar.");
}

// Obtener el user_id de la sesión
$user_id = $_SESSION['user_id'];

// Verificar que user_id no esté vacío
if (empty($user_id)) {
    die("ID de usuario no válido.");
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];
    $method = 'credit-card';
    $payment_type = 'credit-card';

    // Preparar la consulta SQL
    $sql = "INSERT INTO payment_methods (method, payment_type, user_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("ssi", $method, $payment_type, $user_id);

    if ($stmt->execute()) {
        echo "Método de pago agregado correctamente.";
    } else {
        echo "Error al agregar el método de pago: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    die("Acceso no permitido.");
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Tarjeta de Crédito</title>
</head>
<body>
    <h1>Agregar Detalles de Tarjeta de Crédito</h1>
    <form action="add_credit_card.php" method="post">
        <label for="card_number">Número de Tarjeta:</label>
        <input type="text" id="card_number" name="card_number" required><br>
        <label for="expiry_date">Fecha de Expiración:</label>
        <input type="text" id="expiry_date" name="expiry_date" required><br>
        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv" required><br>
        <button type="submit">Guardar</button>
    </form>
</body>
</html>
