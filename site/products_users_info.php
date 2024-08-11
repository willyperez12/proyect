<?php
session_start();
include 'config.php';

// Verificar si el usuario está conectado
if (!isset($_SESSION['user_id'])) {
    die("Usuario no autenticado. Inicie sesión para continuar.");
}

// Obtener el user_id de la sesión
$user_id = $_SESSION['user_id'];

// Consultar la base de datos
$sql = "SELECT 
            p.nombre, p.precio, p.descripcion,
            l.email, l.firstname, l.lastname
        FROM productos p
        INNER JOIN transactions t ON p.id = t.product_id
        INNER JOIN login l ON t.user_id = l.id
        WHERE l.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Mostrar los resultados
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Producto: " . htmlspecialchars($row['nombre']) . "<br>";
        echo "Precio: " . htmlspecialchars($row['precio']) . "<br>";
        echo "Descripción: " . htmlspecialchars($row['descripcion']) . "<br>";
        echo "Comprador: " . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['lastname']) . "<br>";
        echo "Email: " . htmlspecialchars($row['email']) . "<br>";
        echo "<hr>";
    }
} else {
    echo "No se encontraron resultados.";
}

$stmt->close();
$conn->close();
?>
