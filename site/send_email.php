<?php
require_once 'C:\xampp\htdocs\neumati\Config\Database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger datos del formulario
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    // Validar datos
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Correo electrónico inválido.";
        exit;
    }

    // Insertar mensaje en la base de datos
    $stmt = $conn->prepare("INSERT INTO mensajes (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    if ($stmt->execute()) {
        echo "Mensaje enviado con éxito.";
    } else {
        echo "Error al enviar el mensaje.";
    }
    $stmt->close();
    $conn->close();
} else {
    echo "No se ha enviado ningún formulario.";
}
?>
