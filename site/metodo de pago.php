<?php
$file = __DIR__ . '/../Config/Config.php';
require_once 'C:\xampp\htdocs\neumati\Config\Database.php';

session_start(); // Iniciar la sesión si no está ya iniciada

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['payment_method'])) {
      $payment_method = $_POST['payment_method'];

      // Inserción del método de pago en la base de datos
      $stmt = $conn->prepare("INSERT INTO payment_methods (method) VALUES (?)");
      $stmt->bind_param("s", $payment_method);

      if ($stmt->execute()) {
          echo "Método de pago agregado correctamente.";
      } else {
          echo "Error: " . $stmt->error;
      }

      $stmt->close();
  }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
<title>Home</title>
<meta charset="utf-8">
<link rel="icon" href="img/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
<meta name="description" content="Your description">
<meta name="keywords" content="Your keywords">
<meta name="author" content="Your name">
<meta name = "format-detection" content = "telephone=no" />
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/metodo de pago.css">

   <script>
           document.addEventListener('DOMContentLoaded', function() {
            const labels = document.querySelectorAll('.category label');
            labels.forEach(label => {
                label.addEventListener('click', function() {
                    const paymentMethod = label.querySelector('input[name="payment_method"]').value;
                    let url = '';

                    switch (paymentMethod) {
                        case 'credit-card':
                            url = 'add_credit_card.php';
                            break;
                        case 'apple-pay':
                            url = 'add_apple_pay.php';
                            break;
                        case 'paypal':
                            url = 'add_paypal.php';
                            break;
                        case 'google-pay':
                            url = 'add_google_pay.php';
                            break;
                        default:
                            alert('Please select a payment method.');
                            return;
                    }

                    window.location.href = url;
                });
            });
        });
    </script>

</head>
<body>


  <!-- Modal or section for selecting a payment method -->
  <div class="container">
        <div class="title">
            <h4>Select a <span>Payment</span> method</h4>
        </div>

        <form action="javascript:void(0);" method="post">
            <div class="category">
                <label for="visa" class="visaMethod">
                    <div class="imgName">
                        <div class="imgContainer visa">
                            <img src="img/pngwing.com (2).png" alt="Credit Card">
                        </div>
                        <span class="name">Credit card</span>
                    </div>
                    <input type="radio" id="visa" name="payment_method" value="credit-card" style="display: none;">
                </label>

                <label for="mastercard" class="mastercardMethod">
                    <div class="imgName">
                        <div class="imgContainer mastercard">
                            <img src="img/pngwing.com (3).png" alt="Apple Pay">
                        </div>
                        <span class="name">Apple pay</span>
                    </div>
                    <input type="radio" id="mastercard" name="payment_method" value="apple-pay" style="display: none;">
                </label>

                <label for="paypal" class="paypalMethod">
                    <div class="imgName">
                        <div class="imgContainer paypal">
                            <img src="https://i.ibb.co/KVF3mr1/paypal.png" alt="PayPal">
                        </div>
                        <span class="name">Paypal</span>
                    </div>
                    <input type="radio" id="paypal" name="payment_method" value="paypal" style="display: none;">
                </label>

                <label for="AMEX" class="amexMethod">
                    <div class="imgName">
                        <div class="imgContainer AMEX">
                            <img src="img/pngwing.com.png" alt="Google Pay">
                        </div>
                        <span class="name">Google pay</span>
                    </div>
                    <input type="radio" id="AMEX" name="payment_method" value="google-pay" style="display: none;">
                </label>
            </div>
        </form>
    </div>




</body>
</html>