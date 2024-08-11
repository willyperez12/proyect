<?php
session_start();
require_once 'C:\xampp\htdocs\neumati\Config\Database.php';

// Verificar si el usuario es un administrador antes de permitir el acceso
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit();
}

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO login (email, password, firstname, lastname, is_admin) VALUES (?, ?, ?, ?, 1)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $email, $hashedPassword, $firstname, $lastname);

    if ($stmt->execute()) {
        echo "Administrador registrado exitosamente.";
    } else {
        echo "Error al registrar el administrador: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <form action="register_admin.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" required>
        
        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" required>
        
        <button type="submit">Register Admin</button>
    </form>
</body>
</html>
