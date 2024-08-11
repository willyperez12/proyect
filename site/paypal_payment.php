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
$carrito = $_SESSION['carrito'] ?? [];

// Inicializar variables de subtotal y total
$subtotal = 0;
foreach ($carrito as $item) {
    if (isset($item['precio']) && isset($item['cantidad'])) {
        $subtotal += $item['precio'] * $item['cantidad'];
    }
}
$total = $subtotal;

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
        var name = <?php echo json_encode($name); ?>;
        var email = <?php echo json_encode($email); ?>;
        var address = <?php echo json_encode($address); ?>;
        var city = <?php echo json_encode($city); ?>;
        var state = <?php echo json_encode($state); ?>;
        var zip = <?php echo json_encode($zip); ?>;
        var phone = <?php echo json_encode($phone); ?>;

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

                        // Enviar los datos a process_checkout.php
                        fetch('process_checkout.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: new URLSearchParams({
                                order_id: orderId,
                                total_amount: cartTotal,
                                name: name,
                                email: email,
                                address: address,
                                city: city,
                                state: state,
                                zip: zip,
                                phone: phone
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
