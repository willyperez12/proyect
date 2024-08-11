<?php
require_once 'C:\xampp\htdocs\neumati\Config\Database.php';
require_once 'C:\xampp\htdocs\neumati\Config\Config.php';

// Verificar que el usuario está autenticado y es un repartidor
include 'delivery_check.php'; // Verifica si el usuario es un repartidor

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accept_order'])) {
    $order_id = intval($_POST['order_id']);
    $delivery_person_id = intval($_SESSION['user_id']); // ID del repartidor desde la sesión

    // Actualizar el estado de la orden
    $stmt = $conn->prepare("UPDATE orders SET status = 'accepted', delivery_person_id = ? WHERE order_id = ?");
    $stmt->bind_param('ii', $delivery_person_id, $order_id);
    $stmt->execute();
    $stmt->close();

    // Redirigir a la página de administración
    header("Location: admin_dashboard.php?section=orders");
    exit();
}
?>
