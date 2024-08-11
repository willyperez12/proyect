<?php
session_start(); // Iniciar sesión PHP si no está iniciada

// Incluir el archivo de configuración de la conexión
define('HOST', 'localhost');
define('USER', 'root'); // Reemplazar con tu usuario de base de datos
define('PASS', ''); // Reemplazar con tu contraseña de base de datos
define('DB', 'Neumático rd'); // Nombre de la base de datos
define('CHARSET', 'utf8');

// Crear conexión a la base de datos
$conn = new mysqli(HOST, USER, PASS, DB);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Establecer el conjunto de caracteres
$conn->set_charset(CHARSET);

// Verificar si se ha enviado el formulario por método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario y limpiarlos
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Verificar si las contraseñas coinciden
    if ($password !== $confirm_password) {
        header("Location: sign_up.php?error=Passwords do not match");
        exit();
    }

    // Verificar si ya existe un usuario con el mismo email
    $sql = "SELECT * FROM login WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        header("Location: sign_up.php?error=Email already exists");
        exit();
    }

    // Hash de la contraseña antes de guardarla en la base de datos
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertar el nuevo usuario en la base de datos
    $sql = "INSERT INTO login (email, password, firstname, lastname, is_admin) VALUES (?, ?, ?, ?, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $email, $hashed_password, $firstname, $lastname);

    if ($stmt->execute()) {
        $_SESSION['email'] = $email; // Iniciar sesión con el email del nuevo usuario
        header("Location: index.php"); // Redirigir al dashboard o página de inicio
    } else {
        echo "Error: " . $stmt->error; // Mostrar error si la consulta falla
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
} else {
    // Si se intenta acceder a este script directamente sin enviar el formulario, redirigir al formulario de registro
    header("Location: sign_up.php");
}
?>
