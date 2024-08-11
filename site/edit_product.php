<?php
require_once 'C:\xampp\htdocs\neumati\Config\Database.php';
require_once 'C:\xampp\htdocs\neumati\Config\Config.php';
include 'admin_check.php'; // Verifica si el usuario es administrador

// Datos de tamaños, tipos, categorías y marcas
$tamanos = ['13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40'];
$tipos = ['Radial', 'Diagonal', 'Tubeless', 'Baldosa', 'Bias Ply', 'Run Flat', 'All Season', 'High Performance', 'Ultra High Performance', 'Mud Terrain', 'All Terrain'];
$categorias = ['Todos', 'Neumáticos de Invierno', 'Neumáticos de Verano', 'Neumáticos para Todo el Año', 'Neumáticos de Alto Rendimiento', 'Neumáticos para Camionetas', 'Neumáticos para SUV', 'Neumáticos para Autos de Lujo', 'Neumáticos para Carreras', 'Neumáticos Ecológicos'];
$marcas = ['Michelin', 'Goodyear', 'Bridgestone', 'Pirelli', 'Continental', 'Hankook', 'Nokian', 'Dunlop', 'Yokohama', 'Toyo', 'Kumho', 'Falken'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categorias = $_POST['categorias'];
    $tamaño = $_POST['tamaño'];
    $tipo = $_POST['tipo'];
    $marca = $_POST['marca'];
    $cantidad = $_POST['cantidad'];

    // Actualizar el producto
    $stmt = $conn->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, categorias = ?, tamaño = ?, tipo = ?, marca = ?, cantidad = ? WHERE id = ?");
    $stmt->bind_param('ssdsdssss', $nombre, $descripcion, $precio, $categorias, $tamaño, $tipo, $marca, $cantidad, $id);
    $stmt->execute();
    $stmt->close();

    // Procesar las imágenes
    if (isset($_FILES['imagenes']) && $_FILES['imagenes']['error'][0] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $imagenes = $_FILES['imagenes'];

        foreach ($imagenes['name'] as $key => $image_name) {
            if ($imagenes['error'][$key] == UPLOAD_ERR_OK) {
                $target_file = $target_dir . basename($image_name);
                if (move_uploaded_file($imagenes['tmp_name'][$key], $target_file)) {
                    // Insertar nuevas imágenes en la tabla producto_imagenes
                    $stmt = $conn->prepare("INSERT INTO producto_imagenes (producto_id, imagen) VALUES (?, ?)");
                    $stmt->bind_param('is', $id, $target_file);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }
    }

    header("Location: admin_dashboard.php?section=products");
    exit();
}



$product_id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->bind_param('i', $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$product) {
    die('Product not found.');
}

// Obtener las imágenes del producto
$stmt = $conn->prepare("SELECT * FROM producto_imagenes WHERE producto_id = ?");
$stmt->bind_param('i', $product_id);
$stmt->execute();
$imagenes = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="css/admin_dashboard.css">
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .nav {
            background-color: #1a1a1a;
            padding: 10px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            border-bottom: 1px solid #333;
        }
        .nav a {
            color: #fff;
            text-decoration: none;
            padding: 10px;
        }
        .nav a:hover {
            background-color: #333;
            border-radius: 5px;
        }
        .container {
            padding: 20px;
        }
        form {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #333;
            background-color: #222;
            border-radius: 5px;
        }
        form label {
            display: block;
            margin: 5px 0;
        }
        form input, form textarea, form select {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #333;
            border-radius: 5px;
        }
        form input[type="submit"] {
            background-color: #007bff;
            border: none;
            cursor: pointer;
        }
        form input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .image-gallery {
            margin: 20px 0;
        }
        .image-gallery img {
            max-width: 200px;
            margin: 10px;
            border: 1px solid #333;
            border-radius: 5px;
        }
        .image-gallery a {
            color: #ff0000;
            text-decoration: none;
            background-color: #333;
            padding: 5px;
            border-radius: 5px;
        }
        .image-gallery a:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
<div class="nav">
    <a href="index.php">Inicio</a>
    <a href="admin_dashboard.php?section=orders">Orders</a>
    <a href="admin_dashboard.php?section=products">Products</a>
    <a href="admin_dashboard.php?section=add_product">Add Product</a>
    <a href="admin_dashboard.php?section=messages">Messages</a>
    <a href="logout.php" class="button">Logout</a>
</div>

<div class="container">
    <h1>Edit Product</h1>
    <form action="edit_product.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">

        <label for="nombre">Name:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($product['nombre']); ?>" required><br>

        <label for="descripcion">Description:</label>
        <textarea id="descripcion" name="descripcion" required><?php echo htmlspecialchars($product['descripcion']); ?></textarea><br>

        <label for="precio">Price:</label>
        <input type="number" id="precio" name="precio" step="0.01" value="<?php echo htmlspecialchars($product['precio']); ?>" required><br>

        <label for="categorias">Category:</label>
        <select id="categorias" name="categorias" required>
            <?php
            foreach ($categorias as $categoria) {
                $selected = ($product['categorias'] === $categoria) ? 'selected' : '';
                echo '<option value="' . htmlspecialchars($categoria) . '" ' . $selected . '>' . htmlspecialchars($categoria) . '</option>';
            }
            ?>
        </select><br>

        <label for="tamaño">Size:</label>
        <select id="tamaño" name="tamaño" required>
            <?php
            foreach ($tamanos as $tamano) {
                $selected = ($product['tamaño'] === $tamano) ? 'selected' : '';
                echo '<option value="' . htmlspecialchars($tamano) . '" ' . $selected . '>' . htmlspecialchars($tamano) . '</option>';
            }
            ?>
        </select><br>

        <label for="tipo">Type:</label>
        <select id="tipo" name="tipo" required>
            <?php
            foreach ($tipos as $tipo) {
                $selected = ($product['tipo'] === $tipo) ? 'selected' : '';
                echo '<option value="' . htmlspecialchars($tipo) . '" ' . $selected . '>' . htmlspecialchars($tipo) . '</option>';
            }
            ?>
        </select><br>

        <label for="marca">Brand:</label>
        <select id="marca" name="marca" required>
            <?php
            foreach ($marcas as $marca) {
                $selected = ($product['marca'] === $marca) ? 'selected' : '';
                echo '<option value="' . htmlspecialchars($marca) . '" ' . $selected . '>' . htmlspecialchars($marca) . '</option>';
            }
            ?>
        </select><br>

        <label for="imagenes">Images:</label>
        <input type="file" id="imagenes" name="imagenes[]" accept="image/*" multiple><br>

        <label for="cantidad">Quantity:</label>
        <input type="number" id="cantidad" name="cantidad" value="<?php echo htmlspecialchars($product['cantidad']); ?>" required><br>

        <input type="hidden" name="update_product" value="1">
        <input type="submit" value="Update Product">
    </form>

   
    </div>
</div>
</body>
</html>
