<?php
require_once 'C:\xampp\htdocs\neumati\Config\Config.php'; // Ajusta la ruta según tu estructura de proyecto

// Función para obtener la conexión a la base de datos
function getConnection() {
    static $conn;

    if (!$conn) {
        $servername = HOST; // Definido en Config.php
        $username = USER;   // Definido en Config.php
        $password = PASS;   // Definido en Config.php
        $dbname = DB;       // Definido en Config.php

        // Crear conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    }

    return $conn;
}

// Procesar el formulario de cambio de contraseña
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current-password'];
    $newPassword = $_POST['new-password'];

    // Validar contraseñas
    if (strlen($newPassword) < 8) {
        die("La nueva contraseña debe tener al menos 8 caracteres.");
    }

    // Obtener la conexión
    $conn = getConnection();

    // Aquí debes agregar la lógica para verificar la contraseña actual y actualizarla
    // Ejemplo:
    // 1. Verificar la contraseña actual
    // 2. Actualizar la contraseña en la base de datos para el usuario actual

    // Ejemplo de actualización
    $userId = 1; // Reemplaza con el ID del usuario actual

    // Obtener la contraseña actual del usuario
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();

    // Verificar la contraseña actual
    if (!password_verify($currentPassword, $hashedPassword)) {
        die("La contraseña actual es incorrecta.");
    }

    // Hash de la nueva contraseña
    $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    // Actualizar la contraseña
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $newHashedPassword, $userId);

    if ($stmt->execute()) {
        echo "Contraseña actualizada con éxito.";
    } else {
        echo "Error al actualizar la contraseña: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Contraseña</title>
</head>
<body>
    <div class="contenedor">
        <h1>Dashboard de Usuario</h1>
        <div class="form-container">
            <form id="password-form" method="post" action="">
                <h2>Cambiar Contraseña</h2>
                <label for="current-password">Contraseña Actual:</label>
                <input type="password" id="current-password" name="current-password" required>
                <label for="new-password">Nueva Contraseña:</label>
                <input type="password" id="new-password" name="new-password" required>
                <button type="submit">Actualizar Contraseña</button>
            </form>
        </div>
    </div>
</body>
</html>
