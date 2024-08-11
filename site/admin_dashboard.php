<?php
require_once 'C:\xampp\htdocs\neumati\Config\Database.php';
require_once 'C:\xampp\htdocs\neumati\Config\Config.php';
include 'admin_check.php'; // Verifica si el usuario es administrador

// Funciones

// Función para obtener órdenes aceptadas

// Función para obtener órdenes no aceptadas
// Función para obtener órdenes no aceptadas y no entregadas
function getUnacceptedAndNotDeliveredOrders($conn) {
    $query = "SELECT o.order_id, o.total_amount, o.created_at
              FROM orders o
              LEFT JOIN delivery d ON o.order_id = d.order_id
              WHERE (d.status IS NULL OR d.status <> 'Accepted') 
              AND (d.status IS NULL OR d.status <> 'Delivered')
              ORDER BY o.created_at DESC";
    return $conn->query($query);
}




function getDeliveryDetails($conn, $delivery_person_id) {
    $query = "SELECT d.*, o.total_amount, o.created_at 
              FROM delivery d
              JOIN orders o ON d.order_id = o.order_id
              WHERE d.delivery_person_id = ?
              ORDER BY d.delivery_date DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $delivery_person_id);
    $stmt->execute();
    return $stmt->get_result();
}

function getAcceptedOrders($conn) {
    $query = "SELECT o.order_id, o.total_amount, o.created_at
              FROM orders o
              JOIN delivery d ON o.order_id = d.order_id
              WHERE d.status = 'Accepted'
              ORDER BY o.created_at DESC";
    return $conn->query($query);
}


// Cambia la función getOrders para obtener todas las órdenes

function getDeliveryPersons($conn) {
    $query = "SELECT * FROM login WHERE is_admin = 2";
    return $conn->query($query);
}

function getDeliveries($conn) {
    $query = "SELECT * FROM delivery";
    return $conn->query($query);
}

function getOrders($conn) {
    $query = "SELECT order_id, total_amount, created_at FROM orders ORDER BY created_at DESC";
    return $conn->query($query);
}

function getProducts($conn) {
    $query = "SELECT * FROM productos";
    return $conn->query($query);
}

function getMessages($conn) {
    $query = "SELECT * FROM mensajes ORDER BY created_at DESC";
    return $conn->query($query);
}

// Datos de tamaños, tipos, categorías y marcas
$tamanos = [
    '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', 
    '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40'
];

$tipos = [
    'Radial', 'Diagonal', 'Tubeless', 'Baldosa', 'Bias Ply', 'Run Flat', 'All Season', 
    'High Performance', 'Ultra High Performance', 'Mud Terrain', 'All Terrain'
];

$categorias = [
    'Todos', 'Neumáticos de Invierno', 'Neumáticos de Verano', 'Neumáticos para Todo el Año', 
    'Neumáticos de Alto Rendimiento', 'Neumáticos para Camionetas', 'Neumáticos para SUV', 
    'Neumáticos para Autos de Lujo', 'Neumáticos para Carreras', 'Neumáticos Ecológicos'
];

$marcas = [
    'Michelin', 'Goodyear', 'Bridgestone', 'Pirelli', 'Continental', 'Hankook', 'Nokian', 
    'Dunlop', 'Yokohama', 'Toyo', 'Kumho', 'Falken'
];

if (isset($_GET['delete_product'])) {
    $product_id = intval($_GET['delete_product']);
    $conn->query("DELETE FROM productos WHERE id = $product_id");
    header("Location: admin_dashboard.php?section=products");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categorias = $_POST['categorias'];
    $tamaño = $_POST['tamaño'];
    $tipo = $_POST['tipo'];
    $marca = $_POST['marca'];
    $cantidad = $_POST['cantidad'];

    // Insertar el producto
    $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, precio, categorias, tamaño, tipo, marca, cantidad) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssdsdsss', $nombre, $descripcion, $precio, $categorias, $tamaño, $tipo, $marca, $cantidad);
    $stmt->execute();
    $producto_id = $stmt->insert_id; // Obtener el ID del producto recién insertado
    $stmt->close();

    // Procesar las imágenes
    $imagen_principal = 'images/default.jpg'; // Imagen por defecto si no se carga ninguna
    if (isset($_FILES['imagenes']) && $_FILES['imagenes']['error'][0] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $imagenes = $_FILES['imagenes'];
        
        foreach ($imagenes['name'] as $key => $image_name) {
            if ($imagenes['error'][$key] == UPLOAD_ERR_OK) {
                $target_file = $target_dir . basename($image_name);
                if (move_uploaded_file($imagenes['tmp_name'][$key], $target_file)) {
                    // Guardar la primera imagen como principal
                    if ($key == 0) {
                        $imagen_principal = $target_file;
                        $stmt = $conn->prepare("UPDATE productos SET imagen = ? WHERE id = ?");
                        $stmt->bind_param('si', $imagen_principal, $producto_id);
                        $stmt->execute();
                        $stmt->close();
                    }

                    // Insertar otras imágenes en la tabla producto_imagenes
                    $stmt = $conn->prepare("INSERT INTO producto_imagenes (producto_id, imagen) VALUES (?, ?)");
                    $stmt->bind_param('is', $producto_id, $target_file);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }
    }

    header("Location: admin_dashboard.php?section=products");
    exit();
}

$orders = getOrders($conn);
$products = getProducts($conn);
$messages = getMessages($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
     
        .main-content {
            margin-left: 10px;
            margin-right: 10px;
            padding: 5px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            padding: 10px;
            border: 1px solid #333;
        }
        .table th {
            background-color: #1a1a1a;
        }
        .table tr:nth-child(even) {
            background-color: #333;
        }
        .button {
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .button:hover {
            background-color: #0056b3;
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
    </style>
</head>
<body>
<div class="nav">
    <a href="index.php">Inicio</a>
    <a href="admin_dashboard.php?section=orders">Orders</a>
    <a href="admin_dashboard.php?section=delivery_persons">Delivery Persons</a>
    <a href="admin_dashboard.php?section=products">Products</a>
    <a href="admin_dashboard.php?section=add_product">Add Product</a>
    <a href="admin_dashboard.php?section=messages">Messages</a>
    <a href="logout.php" class="button">Logout</a>
</div>

<div class="main-content">
    <?php
    $section = $_GET['section'] ?? 'orders';
    switch ($section) {
         // Código para mostrar la sección de órdenes no aceptadas
// Código para mostrar la sección de órdenes no aceptadas y no entregadas
case 'orders':
    echo '<h1>Orders</h1>';
    $unacceptedAndNotDeliveredOrders = getUnacceptedAndNotDeliveredOrders($conn);
    echo '<table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Total Amount</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>';
    while ($order = $unacceptedAndNotDeliveredOrders->fetch_assoc()) {
        echo '<tr>
            <td>' . htmlspecialchars($order['order_id']) . '</td>
            <td>$' . number_format($order['total_amount'], 2) . '</td>
            <td>' . htmlspecialchars($order['created_at']) . '</td>
            <td>
                <a href="view_invoice.php?order_id=' . htmlspecialchars($order['order_id']) . '" class="button">View Invoice</a>
            </td>
        </tr>';
    }
    echo '</tbody></table>';
    break;


    case 'delivery_persons':
        echo '<h1>Delivery Persons</h1>';
        $deliveryPersons = getDeliveryPersons($conn);
        echo '<table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>';
        while ($person = $deliveryPersons->fetch_assoc()) {
            echo '<tr>
                <td>' . htmlspecialchars($person['id']) . '</td>
                <td>' . htmlspecialchars($person['firstname']) . '</td>
                <td>' . htmlspecialchars($person['email']) . '</td>
                <td>
                    <a href="view_delivery_details.php?delivery_person_id=' . htmlspecialchars($person['id']) . '" class="button">View Details</a>
                </td>
            </tr>';
        }
        echo '</tbody></table>';
        break;
        
        case 'products':
            echo '<h1>Products</h1>';
            echo '<table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Size</th>
                        <th>Type</th>
                        <th>Brand</th>
                        <th>Image</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                        <th>Actions</th>

                    </tr>
                </thead>
                <tbody>';
            while ($product = $products->fetch_assoc()) {
                echo '<tr>
                    <td>' . htmlspecialchars($product['id']) . '</td>
                    <td>' . htmlspecialchars($product['nombre']) . '</td>
                    <td>' . htmlspecialchars($product['descripcion']) . '</td>
                    <td>$' . number_format($product['precio'], 2) . '</td>
                    <td>' . htmlspecialchars($product['categorias']) . '</td>
                    <td>' . htmlspecialchars($product['tamaño']) . '</td>
                    <td>' . htmlspecialchars($product['tipo']) . '</td>
                    <td>' . htmlspecialchars($product['marca']) . '</td>
                    <td><img src="' . htmlspecialchars($product['imagen']) . '" alt="' . htmlspecialchars($product['nombre']) . '" width="100"></td>
                    <td>' . htmlspecialchars($product['cantidad']) . '</td>
                     <td>
                        <a href="edit_product.php?id=' . htmlspecialchars($product['id']) . '" class="button">Edit</a>
                    </td>
                    <td>
                        <a href="admin_dashboard.php?delete_product=' . htmlspecialchars($product['id']) . '" class="button" onclick="return confirm(\'Are you sure?\')">Delete</a>
                    </td>
                </tr>';
            }
            echo '</tbody></table>';
            break;

        case 'add_product':
            echo '<h1>Add Product</h1>';
            echo '<form action="admin_dashboard.php" method="post" enctype="multipart/form-data">
                <label for="nombre">Name:</label>
                <input type="text" id="nombre" name="nombre" required><br>

                <label for="descripcion">Description:</label>
                <textarea id="descripcion" name="descripcion" required></textarea><br>

                <label for="precio">Price:</label>
                <input type="number" id="precio" name="precio" step="0.01" required><br>

                <label for="id_categorias">Category:</label>
                <select id="categorias" name="categorias" required>';
            foreach ($categorias as $categoria) {
                echo '<option value="' . htmlspecialchars($categoria) . '">' . htmlspecialchars($categoria) . '</option>';
            }
            echo '</select><br>

                <label for="tamaño">Size:</label>
                <select id="tamaño" name="tamaño" required>';
            foreach ($tamanos as $tamano) {
                echo '<option value="' . htmlspecialchars($tamano) . '">' . htmlspecialchars($tamano) . '</option>';
            }
            echo '</select><br>

                <label for="tipo">Type:</label>
                <select id="tipo" name="tipo" required>';
            foreach ($tipos as $tipo) {
                echo '<option value="' . htmlspecialchars($tipo) . '">' . htmlspecialchars($tipo) . '</option>';
            }
            echo '</select><br>

                <label for="marca">Brand:</label>
                <select id="marca" name="marca" required>';
            foreach ($marcas as $marca) {
                echo '<option value="' . htmlspecialchars($marca) . '">' . htmlspecialchars($marca) . '</option>';
            }
            echo '</select><br>

                <label for="imagenes">Images:</label>
                <input type="file" id="imagenes" name="imagenes[]" accept="image/*" multiple><br>

                <label for="cantidad">Quantity:</label>
                <input type="number" id="cantidad" name="cantidad" required><br>

                <input type="hidden" name="add_product" value="1">
                <input type="submit" value="Add Product">
            </form>';
            break;

        case 'messages':
            echo '<h1>Messages</h1>';
            echo '<table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
            while ($message = $messages->fetch_assoc()) {
                echo '<tr>
                    <td>' . htmlspecialchars($message['id']) . '</td>
                    <td>' . htmlspecialchars($message['name']) . '</td>
                    <td>' . htmlspecialchars($message['email']) . '</td>
                    <td>' . htmlspecialchars($message['message']) . '</td>
                    <td>' . htmlspecialchars($message['created_at']) . '</td>
                    <td>
                        <a href="admin_dashboard.php?delete_message=' . htmlspecialchars($message['id']) . '" class="button" onclick="return confirm(\'Are you sure?\')">Delete</a>
                    </td>
                </tr>';
            }
            echo '</tbody></table>';
            break;

        default:
            echo '<h1>Welcome to the Admin Dashboard</h1>';
            echo '<p>Select an option from the menu.</p>';
            break;
    }
    ?>
</div>
</body>
</html>
