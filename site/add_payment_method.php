<?php
session_start();
require_once 'C:\xampp\htdocs\neumati\Config\Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id']; // Asegúrate de que el usuario esté autenticado
    $method = $_POST['payment_method'];
    $details = $_POST['details']; // Por ejemplo, los detalles podrían ser el número de tarjeta o una cuenta de PayPal

    // Guardar el nuevo método de pago en la base de datos
    $query = "INSERT INTO payment_methods (user_id, method, account) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iss', $userId, $method, $details);
    $stmt->execute();

    header("Location: checkout.php"); // Redirigir de vuelta a la página de checkout
    exit();
}

$paymentMethod = $_GET['method'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Payment Method</title>
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
    </style>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center bg-background text-foreground">
        <div class="w-full max-w-lg p-8 bg-card rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-6">Add Payment Method: <?php echo htmlspecialchars($paymentMethod); ?></h2>
            <form action="add_payment_method.php" method="post" class="space-y-4">
                <input type="hidden" name="payment_method" value="<?php echo htmlspecialchars($paymentMethod); ?>">
                
                <div>
                    <label for="details" class="block text-sm font-medium">Details</label>
                    <input type="text" id="details" name="details" class="mt-1 block w-full p-2 bg-input border border-border rounded-md" placeholder="Enter payment details" required>
                </div>
                
                <button type="submit" class="w-full bg-primary text-primary-foreground py-2 px-4 rounded-md font-semibold">Add Payment Method</button>
            </form>
        </div>
    </div>
</body>
</html>
