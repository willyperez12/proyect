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

// Obtener el carrito de la sesión
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : array();

// Inicializar variables de subtotal y total
$subtotal = 0;
$total = 0;

// Calcular el subtotal y total
foreach ($carrito as $item) {
    if (isset($item['precio']) && isset($item['cantidad'])) {
        $subtotal += $item['precio'] * $item['cantidad'];
    }
}

$total = $subtotal; // Puedes ajustar esto si hay impuestos u otros cargos

// Obtener datos de envío
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$address = $_POST['address'] ?? '';
$city = $_POST['city'] ?? '';
$state = $_POST['state'] ?? '';
$zip = $_POST['zip'] ?? '';
$phone = $_POST['phone'] ?? '';

// Generar un order_id único basado en un número entero
$orderId = time(); // Utilizamos el timestamp actual como un ID único

// Insertar la orden en la base de datos
$stmt = $pdo->prepare("INSERT INTO orders (order_id, name, email, address, city, state, zip, phone, total_amount) VALUES (:order_id, :name, :email, :address, :city, :state, :zip, :phone, :total_amount)");
$stmt->execute([
    ':order_id' => $orderId,
    ':name' => $name,
    ':email' => $email,
    ':address' => $address,
    ':city' => $city,
    ':state' => $state,
    ':zip' => $zip,
    ':phone' => $phone,
    ':total_amount' => $total
]);

// Insertar los productos en order_items
foreach ($carrito as $item) {
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)");
    $stmt->execute([
        ':order_id' => $orderId,
        ':product_id' => $item['id'],
        ':quantity' => $item['cantidad'],
        ':price' => $item['precio']
    ]);
}

// Vaciar el carrito de la sesión
unset($_SESSION['carrito']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayPal Checkout</title>
</head>
<body>
    <div id="smart-button-container">
        <div style="text-align: center;">
            <div id="paypal-button-container"></div>
        </div>
    </div>
    <script src="https://www.paypal.com/sdk/js?client-id=ATkR70piFyZMu6Os2l1By9cJyBd2UrgRHgztpBnFPT6klJ53i8xbFE4QCLwfoJxIOAKmw-bEovnpQL61&currency=USD" data-sdk-integration-source="button-factory"></script>
    <script>
        var cartTotal = <?php echo json_encode(number_format($total, 2, '.', '')); ?>;
        var orderId = <?php echo json_encode($orderId); ?>;

        function initPayPalButton() {
            paypal.Buttons({
                style: {
                    shape: 'rect',
                    color: 'gold',
                    layout: 'vertical',
                    label: 'pay',
                },

                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            description: 'La descripción de tu producto o carrito',
                            amount: {
                                currency_code: 'USD',
                                value: cartTotal
                            }
                        }]
                    });
                },

                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(orderData) {
                        console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

                        fetch('process_checkout.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: new URLSearchParams({
                                order_id: orderId,
                                total_amount: cartTotal,
                                name: '<?php echo $name; ?>',
                                email: '<?php echo $email; ?>',
                                address: '<?php echo $address; ?>',
                                city: '<?php echo $city; ?>',
                                state: '<?php echo $state; ?>',
                                zip: '<?php echo $zip; ?>',
                                phone: '<?php echo $phone; ?>'
                            })
                        }).then(response => response.text())
                          .then(result => {
                              console.log(result);
                              window.location.href = 'factura.php?order_id=' + orderId;
                          }).catch(error => {
                              console.error('Error al procesar el checkout:', error);
                          });
                    });
                },

                onError: function(err) {
                    console.error('Error durante la transacción:', err);
                }
            }).render('#paypal-button-container');
        }
        initPayPalButton();
    </script>
</body>
</html>
