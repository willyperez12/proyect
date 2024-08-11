<?php
require_once 'C:\xampp\htdocs\neumati\Config\Database.php';
require_once 'C:\xampp\htdocs\neumati\Config\Config.php';

$order_id = $_GET['order_id'] ?? null;
if ($order_id === null) {
    die('No se ha proporcionado un ID de orden.');
}

// Obtener datos de la orden
$query = "SELECT o.*, d.status, d.delivery_date 
          FROM orders o
          JOIN delivery d ON o.order_id = d.order_id
          WHERE o.order_id = ? AND d.status = 'Delivered'";

$stmt = $conn->prepare($query);
$stmt->bind_param('i', $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Orden no encontrada o no ha sido entregada.');
}

$order = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Invoice</title>
    <style>
        body {
            background-color: #f4f4f4;
            color: #333;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
        }
        .invoice {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .invoice h1 {
            margin-top: 0;
        }
        .invoice p {
            margin: 5px 0;
        }
        .button {
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="invoice">
        <h1>Order Invoice</h1>
        <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order['order_id']); ?></p>
        <p><strong>Total Amount:</strong> $<?php echo number_format($order['total_amount'], 2); ?></p>
        <p><strong>Created At:</strong> <?php echo htmlspecialchars($order['created_at']); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
        <p><strong>Delivery Date:</strong> <?php echo htmlspecialchars($order['delivery_date']); ?></p>
        <a href="delivery_dashboard.php?section=delivered_orders" class="button">Back to Dashboard</a>
    </div>
</div>
</body>
</html>
