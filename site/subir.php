<?php

require_once 'C:\xampp\htdocs\neumati\Config\Database.php';
require_once 'C:\xampp\htdocs\neumati\Config\Config.php';



// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = conectarBD();

    // Obtener datos del formulario
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $id_categoria = $_POST['id_categoria'] ?? 0;
    $tamaño = $_POST['tamaño'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $cantidad = $_POST['cantidad'] ?? 0;

    // Manejar la subida de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validar que el archivo es una imagen
        $check = getimagesize($_FILES["imagen"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
                // Insertar datos en la base de datos
                $sql = "INSERT INTO productos (nombre, descripcion, precio, id_categoria, tamaño, tipo, imagen, cantidad) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssdisssi", $nombre, $descripcion, $precio, $id_categoria, $tamaño, $tipo, $target_file, $cantidad);

                if ($stmt->execute()) {
                    echo "Producto subido exitosamente.";
                } else {
                    echo "Error al subir el producto: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error al subir la imagen.";
            }
        } else {
            echo "El archivo no es una imagen.";
        }
    } else {
        echo "Error al subir el archivo de imagen.";
    }

    $conn->close();
} else {
    echo "El formulario no ha sido enviado correctamente.";
}
?>
