<?php
session_start();
require_once 'C:\xampp\htdocs\neumati\Config\Database.php';

// Verificar que el usuario está autenticado y es un administrador
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit();
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $email = $conn->real_escape_string($_POST['email']);
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashear la contraseña
    $is_admin = 1; // Hacer que este usuario sea administrador

    // Consulta SQL para insertar el nuevo usuario
    $sql = "INSERT INTO login (email, firstname, lastname, password, is_admin) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssi', $email, $firstname, $lastname, $password, $is_admin);

    if ($stmt->execute()) {
        echo "Admin user added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin</title>
    <link rel="stylesheet" href="css/admin_dashboard.css">
</head>
<body>
    <h1>Add Admin User</h1>
    <form action="add_admin.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" required>
        <br>
        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Add Admin</button>
    </form>
</body>
</html>
