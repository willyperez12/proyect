<?php
require_once 'C:\xampp\htdocs\neumati\Config\Database.php';
require_once 'C:\xampp\htdocs\neumati\Config\Config.php';
include 'delivery_check.php'; // Verifica si el usuario es delivery

if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    die('No se ha proporcionado un ID de orden.');
}

$order_id = $_GET['order_id'];
$deliveryPersonId = $_SESSION['user_id'];

// Marcar la orden como entregada
$query = "UPDATE delivery SET status = 'Delivered', delivery_date = NOW() WHERE order_id = ? AND delivery_person_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $order_id, $deliveryPersonId);

if ($stmt->execute()) {
    header('Location: delivery_dashboard.php?section=accepted_orders');
} else {
    echo 'Error al marcar la orden como entregada.';
}
?>
