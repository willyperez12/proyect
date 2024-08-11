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

// Preparar la consulta SQL
$sql = "SELECT * FROM payment_methods WHERE user_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error al preparar la consulta: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontraron métodos de pago
if ($result->num_rows > 0) {
    // Mostrar los métodos de pago
    while ($row = $result->fetch_assoc()) {
        echo "Método: " . htmlspecialchars($row['method']) . "<br>";
        echo "Tipo de Pago: " . htmlspecialchars($row['payment_type']) . "<br>";
    }
} else {
    echo "No se encontraron métodos de pago.";
}

$stmt->close();
$conn->close();
?>

