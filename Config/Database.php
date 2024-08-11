<?php
require_once 'C:\xampp\htdocs\neumati\Config\Config.php';
require_once 'C:\xampp\htdocs\neumati\Config\Database.php'; // Asegúrate de ajustar la ruta según tu estructura de proyecto


class Database {
    private static $conn;

    
    // Método para obtener la conexión a la base de datos
    private static function connect() {
        self::$conn = new mysqli(HOST, USER, PASS, DB);
        if (self::$conn->connect_error) {
            die("Connection failed: " . self::$conn->connect_error);
        }
    }

    // Método para cerrar la conexión a la base de datos
    private static function close() {
        if (self::$conn) {
            self::$conn->close();
        }
    }

     // Método para obtener productos con paginación
     public static function getProducts($offset, $limit) {
        self::connect();

        $stmt = self::$conn->prepare("SELECT * FROM productos LIMIT ?, ?");
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        $stmt->close();
        self::close();
        return $products;
    }

    // Método para obtener el total de productos
    public static function getTotalProducts() {
        self::connect();

        $stmt = self::$conn->prepare("SELECT COUNT(*) as total FROM productos");
        $stmt->execute();
        $result = $stmt->get_result();
        $total = 0;

        if ($row = $result->fetch_assoc()) {
            $total = $row['total'];
        }

        $stmt->close();
        self::close();
        return $total;
    }
}



// Obtén la conexión a la base de datos
$conn = conectarBD();

// Verifica si la conexión se ha establecido correctamente
if (!$conn) {
    die('No se pudo conectar a la base de datos.');
}

// Código para preparar y ejecutar la consulta
$sql = "SELECT * FROM productos WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $id = 1; // Ejemplo de ID, reemplázalo con el valor adecuado
    $stmt->bind_param('i', $id); // 'i' indica que el parámetro es un entero
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        // Procesa los resultados aquí
    }

    $stmt->close();
} else {
    echo "Error en la preparación de la consulta: " . $conn->error;
}

// Cierra la conexión cuando hayas terminado

?>




