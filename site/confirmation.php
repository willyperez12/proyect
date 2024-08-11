<?php
require 'config.php'; // Configuración de la base de datos

$invoice_id = $_GET['invoice_id']; // Obtener el ID de la factura

$query = "SELECT address, city, postal_code, country, payment_method FROM invoices WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $invoice_id);
$stmt->execute();
$result = $stmt->get_result();
$invoice = $result->fetch_assoc();

if (!$invoice) {
    echo "No se encontró la factura.";
    exit();
}

echo "<h1>Factura Generada</h1>";
echo "<p>Dirección: {$invoice['address']}</p>";
echo "<p>Ciudad: {$invoice['city']}</p>";
echo "<p>Código Postal: {$invoice['postal_code']}</p>";
echo "<p>País: {$invoice['country']}</p>";
echo "<p>Método de Pago: {$invoice['payment_method']}</p>";
?>
