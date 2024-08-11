<?php
require_once 'C:\xampp\htdocs\neumati\Config\Config.php';

session_start();
$userId = $_SESSION['user_id'] ?? 0; // Asegúrate de que el usuario esté autenticado

$method = $_GET['method'] ?? '';
if (!$userId || !$method) {
    echo json_encode([]);
    exit;
}

$query = "SELECT * FROM payment_methods WHERE user_id = ? AND method = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('is', $userId, $method);
$stmt->execute();
$result = $stmt->get_result();
$methods = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($methods);
