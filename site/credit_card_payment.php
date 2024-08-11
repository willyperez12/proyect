<?php
session_start();

// Verificar que el total del carrito esté definido
if (!isset($_SESSION['checkout_total'])) {
    echo "Error: Total del carrito no definido.";
    exit();
}

$total = $_SESSION['checkout_total'];

// Configurar detalles del pago con tarjeta de crédito aquí
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credit Card Payment</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <style>
        body {
            background-color: #000; /* Fondo negro */
            color: #fff; /* Texto blanco */
        }
        .bg-card {
            background-color: #1a1a1a; /* Fondo del card más claro */
        }
        .bg-input {
            background-color: #333; /* Fondo de los inputs más oscuro */
        }
        .text-primary {
            color: #00aaff; /* Color para el texto primario */
        }
        .text-muted-foreground {
            color: #ccc; /* Color para el texto secundario */
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center bg-background text-foreground">
        <div class="w-full max-w-lg p-8 bg-card rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-6">Credit Card Payment</h2>
            <p class="mb-4">Total to Pay: $<?php echo number_format($total, 2); ?></p>
            <form action="process_credit_card.php" method="post" class="space-y-4">
                <div>
                    <label for="card-number" class="block text-sm font-medium text-muted-foreground">Card Number</label>
                    <input type="text" id="card-number" name="card_number" class="mt-1 block w-full p-2 bg-input border border-border rounded-md focus:ring-primary focus:border-primary" placeholder="1234 5678 9012 3456" required>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="expiration-date" class="block text-sm font-medium text-muted-foreground">Expiration Date</label>
                        <input type="text" id="expiration-date" name="expiration_date" class="mt-1 block w-full p-2 bg-input border border-border rounded-md focus:ring-primary focus:border-primary" placeholder="MM/YY" required>
                    </div>
                    <div>
                        <label for="cvv" class="block text-sm font-medium text-muted-foreground">CVV</label>
                        <input type="text" id="cvv" name="cvv" class="mt-1 block w-full p-2 bg-input border border-border rounded-md focus:ring-primary focus:border-primary" placeholder="123" required>
                    </div>
                </div>
                <button type="submit" class="w-full bg-primary text-primary-foreground py-2 px-4 rounded-md font-semibold">Pay Now</button>
            </form>
        </div>
    </div>
</body>
</html>
