<?php
session_start();
define('DB_HOST', 'localhost');
define('DB_NAME', 'neumático rd');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error de conexión: ' . $e->getMessage();
    die();
}

$orderId = $_GET['order_id'] ?? '';

if (!$orderId) {
    echo 'No se ha proporcionado un ID de orden.';
    exit();
}

// Obtener los detalles de la orden
$stmt = $pdo->prepare("SELECT * FROM orders WHERE order_id = :order_id");
$stmt->execute([':order_id' => $orderId]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo 'Orden no encontrada.';
    exit();
}

// Obtener los artículos de la orden
$stmt = $pdo->prepare("SELECT oi.*, p.nombre, p.imagen FROM order_items oi JOIN productos p ON oi.product_id = p.id WHERE oi.order_id = :order_id");
$stmt->execute([':order_id' => $orderId]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Procesar aceptación del pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accept_order'])) {
    $deliveryPersonId = $_SESSION['user_id'];
    $deliveryPersonName = $_SESSION['user_name'];
    
    $stmt = $pdo->prepare("
        INSERT INTO delivery (order_id, delivery_person_id, delivery_person_name, status)
        VALUES (:order_id, :delivery_person_id, :delivery_person_name, 'Accepted')
        ON DUPLICATE KEY UPDATE delivery_person_id = VALUES(delivery_person_id),
                                delivery_person_name = VALUES(delivery_person_name),
                                status = 'Accepted'
    ");
    if ($stmt->execute([
        ':order_id' => $orderId,
        ':delivery_person_id' => $deliveryPersonId,
        ':delivery_person_name' => $deliveryPersonName
    ])) {
        $deliveryStatus = 'Accepted'; // Actualiza el estado para reflejar el cambio
        echo '<p>Pedido aceptado con éxito.</p>';
    } else {
        echo '<p>Error al aceptar el pedido.</p>';
    }
}

// Procesar marcación como entregada
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_delivered'])) {
    $stmt = $pdo->prepare("UPDATE delivery SET status = 'Delivered' WHERE order_id = :order_id AND delivery_person_id = :delivery_person_id");
    if ($stmt->execute([
        ':order_id' => $orderId,
        ':delivery_person_id' => $_SESSION['user_id']
    ])) {
        $deliveryStatus = 'Delivered'; // Actualiza el estado para reflejar el cambio
        echo '<p>Pedido marcado como entregado.</p>';
    } else {
        echo '<p>Error al marcar el pedido como entregado.</p>';
    }
}

// Obtener el estado actual del pedido en la tabla de delivery
$stmt = $pdo->prepare("SELECT status FROM delivery WHERE order_id = :order_id AND delivery_person_id = :delivery_person_id");
$stmt->execute([
    ':order_id' => $orderId,
    ':delivery_person_id' => $_SESSION['user_id']
]);
$delivery = $stmt->fetch(PDO::FETCH_ASSOC);
$deliveryStatus = $delivery['status'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
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
        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($order['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
        <p><strong>Dirección:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
        <p><strong>Ciudad:</strong> <?php echo htmlspecialchars($order['city']); ?></p>
        <p><strong>Estado:</strong> <?php echo htmlspecialchars($order['state']); ?></p>
        <p><strong>Código Postal:</strong> <?php echo htmlspecialchars($order['zip']); ?></p>
        <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
        <p><strong>Total:</strong> $<?php echo number_format($order['total_amount'], 2); ?></p>

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
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($item['imagen']); ?>" alt="<?php echo htmlspecialchars($item['nombre']); ?>" style="max-width: 100px;"></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Formularios para aceptar y marcar la orden como entregada -->
        <?php if (!$deliveryStatus): ?>
        <!-- Si la orden no ha sido aceptada -->
        <form method="POST" action="">
            <input type="hidden" name="accept_order" value="1">
            <input type="submit" value="Aceptar Pedido" class="button">
        </form>
        <?php elseif ($deliveryStatus === 'Accepted'): ?>
        <!-- Si la orden ha sido aceptada pero no entregada -->
        <form method="POST" action="">
            <input type="hidden" name="mark_delivered" value="1">
            <input type="submit" value="Marcar como Entregada" class="button">
        </form>
        <?php elseif ($deliveryStatus === 'Delivered'): ?>
        <!-- Si la orden ha sido entregada -->
        <p><strong>Estado:</strong> Entregado</p>
        <?php else: ?>
            <p><strong>Estado:</strong> <?php echo htmlspecialchars($deliveryStatus); ?></p>
        <?php endif; ?>

        <a href="delivery_dashboard.php" class="button">Dashboard</a>
        <a href="index.php" class="button">Regresar al Inicio</a>
    </div>
</body>
</html>
