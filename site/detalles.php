<?php
// Conectar a la base de datos

require_once 'C:\xampp\htdocs\neumati\Config\Database.php';
include_once 'C:\xampp\htdocs\neumati\site\funciones.php';
$file = __DIR__ . '/../Config/Config.php';


// Incluir archivo de configuración

// Crear la conexión usando las constantes definidas en config.php
$conn = new mysqli(HOST, USER, PASS, DB);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para obtener un producto por su ID
function obtenerProductoPorId($conn, $product_id) {
    $sql = "SELECT * FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
        return null;
    }
}

// detalles.php
function obtenerImagenesPorProducto($conn, $productoId) {
    $query = "SELECT imagen FROM producto_imagenes WHERE producto_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $productoId);
    $stmt->execute();
    $result = $stmt->get_result();
    $imagenes = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $imagenes;
}


// Obtener el ID del producto seleccionado (puedes modificar esta lógica según tu aplicación)
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Obtener el ID desde la URL

// Obtener los datos del producto
$product = obtenerProductoPorId($conn, $product_id);

// Verificar si se encontró el producto
if (!$product) {
    echo "No se encontró el producto con ID " . $product_id;
    // Puedes manejar esta situación como desees, por ejemplo, redirigiendo o mostrando un mensaje adecuado.
}

?>


