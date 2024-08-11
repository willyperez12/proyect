<?php
require_once 'C:\xampp\htdocs\neumati\Config\Database.php';
require_once 'C:\xampp\htdocs\neumati\Config\Config.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

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


return $conn;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newEmail = $_POST['email'];
    $userId = $_SESSION['user_id']; // Asegúrate de que el ID del usuario esté en la sesión

    try {
        // Actualizar el correo electrónico en la base de datos
        $query = "UPDATE users SET email = :email WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $newEmail);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();

        // Actualizar el correo electrónico en la sesión
        $_SESSION['email'] = $newEmail;

        // Devolver la nueva dirección de correo electrónico en formato JSON
        echo json_encode(['email' => $newEmail]);
    } catch (PDOException $e) {
        // Manejar el error
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>
