<?php
session_start();
$file = __DIR__ . '/../Config/Config.php';
require_once 'C:\xampp\htdocs\neumati\Config\Database.php'; // Asegúrate de que esta ruta sea correcta

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['payment_method'])) {
        $payment_method = $_POST['payment_method'];
        switch ($payment_method) {
            case 'credit-card':
                header('Location: add_google_pay.php');
                break;
            case 'apple-pay':
                header('Location: apple_pay_details.php');
                break;
            case 'paypal':
                header('Location: paypal_details.php');
                break;
            case 'google-pay':
                header('Location: google_pay_details.php');
                break;
            default:
                echo "Método de pago no reconocido.";
                break;
        }
        exit();
    } else {
        echo "No se ha seleccionado ningún método de pago.";
    }
}
?>
