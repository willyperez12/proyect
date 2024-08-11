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
    $method = 'apple-pay';
    $payment_type = 'apple-pay';

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
    <title>Agregar Apple Pay</title>
</head>
<body>
    <h1>Agregar Detalles de Apple Pay</h1>
    <form action="add_apple_pay.php" method="post">
        <label for="apple_id">Apple ID:</label>
        <input type="text" id="apple_id" name="apple_id" required><br>
        <button type="submit">Guardar</button>
    </form>
</body>
</html>
