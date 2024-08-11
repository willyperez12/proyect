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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Location: paypal_payment.php");
    exit();
}

// Obtener el subtotal y el total del carrito
$carrito = $_SESSION['carrito'] ?? [];
$subtotal = 0;
foreach ($carrito as $item) {
    if (isset($item['precio']) && isset($item['cantidad'])) {
        $subtotal += $item['precio'] * $item['cantidad'];
    }
}
$total = $subtotal;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <style>
        body {
            background-color: #000;
            color: #fff;
        }
        .bg-card {
            background-color: #1a1a1a;
        }
        .bg-input {
            background-color: #333;
            color: #fff;
        }
        .text-primary {
            color: #00aaff;
        }
        .text-muted-foreground {
            color: #ccc;
        }
        .text-card-foreground {
            color: #fff;
        }
    </style>
</head>
<body>
<div class="min-h-screen flex items-center justify-center bg-background text-foreground">
    <div class="w-full max-w-lg p-8 bg-card rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-card-foreground">Checkout</h2>
        <form id="checkout-form" action="paypal_payment.php" method="post" class="space-y-4">
            <div>
                <label for="name" class="block text-muted-foreground">Name</label>
                <input type="text" id="name" name="name" class="bg-input p-2 rounded-md w-full" required>
            </div>
            <div>
                <label for="email" class="block text-muted-foreground">Email</label>
                <input type="email" id="email" name="email" class="bg-input p-2 rounded-md w-full" required>
            </div>
            <div>
                <label for="address" class="block text-muted-foreground">Address</label>
                <input type="text" id="address" name="address" class="bg-input p-2 rounded-md w-full" required>
            </div>
            <div>
                <label for="city" class="block text-muted-foreground">City</label>
                <input type="text" id="city" name="city" class="bg-input p-2 rounded-md w-full" required>
            </div>
            <div>
                <label for="state" class="block text-muted-foreground">State</label>
                <input type="text" id="state" name="state" class="bg-input p-2 rounded-md w-full" required>
            </div>
            <div>
                <label for="zip" class="block text-muted-foreground">ZIP Code</label>
                <input type="text" id="zip" name="zip" class="bg-input p-2 rounded-md w-full" required>
            </div>
            <div>
                <label for="phone" class="block text-muted-foreground">Phone</label>
                <input type="text" id="phone" name="phone" class="bg-input p-2 rounded-md w-full" required>
            </div>
            <div class="flex items-center justify-between mt-4">
                <span class="text-lg font-semibold text-muted-foreground">Total:</span>
                <span id="total-amount" class="text-lg font-semibold text-primary">$<?php echo number_format($total, 2); ?></span>
                <input type="hidden" id="total" name="total_amount" value="<?php echo number_format($total, 2); ?>">
            </div>
            <button type="submit" class="w-full bg-primary text-primary-foreground py-2 px-4 rounded-md font-semibold">Place Order</button>
        </form>
    </div>
</div>
</body>
</html>
