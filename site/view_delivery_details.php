<?php
require_once 'C:\xampp\htdocs\neumati\Config\Database.php';
require_once 'C:\xampp\htdocs\neumati\Config\Config.php';
include 'admin_check.php'; // Verifica si el usuario es administrador

function getDeliveryDetails($conn, $delivery_person_id) {
    $query = "SELECT d.order_id, o.total_amount, o.name, o.email, o.address, o.city, o.state, o.zip, o.phone
              FROM delivery d
              JOIN orders o ON d.order_id = o.order_id
              WHERE d.delivery_person_id = ?
              ORDER BY d.delivery_date DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $delivery_person_id);
    $stmt->execute();
    return $stmt->get_result();
}

function getOrderItems($conn, $order_id) {
    $query = "SELECT nombre AS product_name, imagen, oi.quantity, oi.price
              FROM order_items oi
              JOIN productos p ON oi.product_id = p.id
              JOIN order_items pi ON p.id = pi.product_id
              WHERE oi.order_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    return $stmt->get_result();
}

if (!isset($_GET['delivery_person_id']) || empty($_GET['delivery_person_id'])) {
    echo '<p>No se ha proporcionado un ID de repartidor.</p>';
    exit();
}

$delivery_person_id = intval($_GET['delivery_person_id']);
$deliveries = getDeliveryDetails($conn, $delivery_person_id);

if ($deliveries->num_rows === 0) {
    echo '<p>No se encontraron órdenes para este repartidor.</p>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Factura de Compra</h1>
        <?php while ($delivery = $deliveries->fetch_assoc()): ?>
            <?php
            $order_id = $delivery['order_id'];
            $orderItems = getOrderItems($conn, $order_id);
            ?>
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($delivery['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($delivery['email']); ?></p>
            <p><strong>Dirección:</strong> <?php echo htmlspecialchars($delivery['address']); ?></p>
            <p><strong>Ciudad:</strong> <?php echo htmlspecialchars($delivery['city']); ?></p>
            <p><strong>Estado:</strong> <?php echo htmlspecialchars($delivery['state']); ?></p>
            <p><strong>Código Postal:</strong> <?php echo htmlspecialchars($delivery['zip']); ?></p>
            <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($delivery['phone']); ?></p>
            <p><strong>Total:</strong> $<?php echo number_format($delivery['total_amount'], 2); ?></p>

            <h2>Detalles de la Orden</h2>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Imagen</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = $orderItems->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($item['imagen']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" style="max-width: 100px;"></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endwhile; ?>

        <a href="admin_dashboard.php?section=delivery_persons" class="button">Dashboard</a>
    </div>
</body>
</html>
