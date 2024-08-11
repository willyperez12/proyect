<?php
session_start();
require_once 'C:\xampp\htdocs\neumati\Config\Database.php';

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // Consulta SQL para verificar las credenciales del administrador
    $sql = "SELECT * FROM admin_users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_id'] = $row['id']; // Guardar el admin_id en la sesión
            $_SESSION['admin_username'] = $username; // Guardar el nombre de usuario en la sesión
            header("Location: admin_dashboard.php"); // Redirigir al panel de administración
            exit();
        } else {
            header("Location: admin_login.php?error=1"); // Contraseña incorrecta
            exit();
        }
    } else {
        header("Location: admin_login.php?error=1"); // Usuario no encontrado
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: admin_login.php"); // Redirigir si el script se accede directamente
    exit();
}
?>
