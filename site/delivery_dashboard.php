<?php
require_once 'C:\xampp\htdocs\neumati\Config\Database.php';
require_once 'C:\xampp\htdocs\neumati\Config\Config.php';
include 'delivery_check.php'; // Verifica si el usuario es delivery

// Función para obtener las órdenes según la sección actual
function getOrdersBySection($conn, $section, $deliveryPersonId) {
    $query = "";
    switch ($section) {
        case 'orders':
            // Obtener órdenes que no han sido aceptadas ni entregadas por ningún delivery
            $query = "
                SELECT o.order_id, o.total_amount, o.created_at 
                FROM orders o
                LEFT JOIN delivery d ON o.order_id = d.order_id
                WHERE d.order_id IS NULL OR (d.status IS NULL AND d.delivery_person_id IS NULL) OR
                      (d.status <> 'Accepted' AND d.status <> 'Delivered')
                ORDER BY o.created_at DESC
            ";
            break;
        case 'accepted_orders':
            // Obtener órdenes aceptadas por el delivery actual
            $query = "
                SELECT o.order_id, o.total_amount, o.created_at, d.status 
                FROM orders o
                JOIN delivery d ON o.order_id = d.order_id
                WHERE d.delivery_person_id = ? AND d.status = 'Accepted'
                ORDER BY o.created_at DESC
            ";
            break;
        case 'delivered_orders':
            // Obtener órdenes entregadas por el delivery actual
            $query = "
                SELECT o.order_id, o.total_amount, o.created_at, d.status, d.delivery_date
                FROM orders o
                JOIN delivery d ON o.order_id = d.order_id
                WHERE d.delivery_person_id = ? AND d.status = 'Delivered'
                ORDER BY o.created_at DESC
            ";
            break;
    }
    $stmt = $conn->prepare($query);
    if ($section === 'orders') {
        $stmt->execute();
    } else {
        $stmt->bind_param('i', $deliveryPersonId);
        $stmt->execute();
    }
    return $stmt->get_result();
}

$section = $_GET['section'] ?? 'orders';
$deliveryPersonId = $_SESSION['user_id'];
$orders = getOrdersBySection($conn, $section, $deliveryPersonId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Dashboard</title>
    <style>
        body {
            background-color: #f4f4f4;
            color: #333;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .nav {
            background-color: #1a1a1a;
            padding: 10px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            border-bottom: 1px solid #333;
        }
        .nav a {
            color: #fff;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
        }
        .nav a:hover {
            background-color: #333;
        }
        .container {
            padding: 20px;
        }
        .section {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .section h1 {
            margin-top: 0;
        }
        .section table {
            width: 100%;
            border-collapse: collapse;
        }
        .section th, .section td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .section th {
            background-color: #f4f4f4;
        }
        .section tr:nth-child(even) {
            background-color: #f9f9f9;
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
<div class="nav">
    <a href="index.php">Inicio</a>
    <a href="delivery_dashboard.php?section=orders">Orders</a>
    <a href="delivery_dashboard.php?section=accepted_orders">Accepted Orders</a>
    <a href="delivery_dashboard.php?section=delivered_orders">Delivered Orders</a>
    <a href="logout.php" class="button">Logout</a>
</div>

<div class="container">
    <div class="section">
        <h1><?php echo ucfirst(str_replace('_', ' ', $section)); ?></h1>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Total Amount</th>
                    <th>Created At</th>
                    <?php if ($section == 'delivered_orders'): ?>
                        <th>Delivery Date</th>
                    <?php endif; ?>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $orders->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                        <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                        <?php if ($section == 'delivered_orders'): ?>
                            <td><?php echo htmlspecialchars($order['delivery_date']); ?></td>
                        <?php endif; ?>
                        <td>
                            <a href="view_delivery.php?order_id=<?php echo htmlspecialchars($order['order_id']); ?>" class="button">View Invoice</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
