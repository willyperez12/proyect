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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura - Admin</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 20px;
            color: #444;
            margin-bottom: 15px;
        }
        p {
            font-size: 16px;
            color: #555;
            margin: 5px 0;
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
            padding: 12px;
            text-align: left;
            vertical-align: middle;
        }
        th {
            background-color: #f7f7f7;
            color: #333;
        }
        td img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
        }
        .button {
            display: inline-block;
            padding: 12px 25px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            color: #ffffff;
            background-color: #007bff;
            border-radius: 5px;
            margin-right: 10px;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .button.admin {
            background-color: #28a745;
        }
        .button.admin:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Factura de Compra - Administrador</h1>
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
                    <td><img src="<?php echo htmlspecialchars($item['imagen']); ?>" alt="<?php echo htmlspecialchars($item['nombre']); ?>"></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="index.php" class="button">Regresar al Inicio</a>
        <a href="admin_dashboard.php" class="button admin">Volver</a>
    </div>
</body>
</html>
