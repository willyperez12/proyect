<?php
require_once 'C:\xampp\htdocs\neumati\Config\Database.php';
require_once 'C:\xampp\htdocs\neumati\Config\Config.php';

// Inicializar variables de filtro si no están definidas
$filtros = [
    'buscar' => '',
    'buscadepartamento' => '',
    'color' => '',
    'buscafechadesde' => '',
    'buscafechahasta' => '',
    'buscapreciodesde' => '',
    'buscapreciohasta' => '',
    'categorias' => [],
    'tamano' => [],
    'tipo' => [],
    'precio' => [],
    'orden' => ''
];

foreach ($filtros as $filtro => $valor) {
    if (!isset($_GET[$filtro])) {
        $_GET[$filtro] = $valor;
    }
}

// Configurar paginación
$limit = 9; // Número de productos por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}
$offset = ($page - 1) * $limit;

// Construcción de la consulta SQL dinámica
$sql = "SELECT * FROM productos WHERE 1=1";
$countSql = "SELECT COUNT(*) as total FROM productos WHERE 1=1";
$params = [];

// Filtros de búsqueda
if (!empty($_GET['buscar'])) {
    $aKeyword = explode(" ", $_GET['buscar']);
    $sql .= " AND (nombre LIKE LOWER(?) OR descripcion LIKE LOWER(?))";
    $countSql .= " AND (nombre LIKE LOWER(?) OR descripcion LIKE LOWER(?))";
    $params[] = '%' . $aKeyword[0] . '%';
    $params[] = '%' . $aKeyword[0] . '%';
    for ($i = 1; $i < count($aKeyword); $i++) {
        if (!empty($aKeyword[$i])) {
            $sql .= " OR nombre LIKE LOWER(?) OR descripcion LIKE LOWER(?)";
            $countSql .= " OR nombre LIKE LOWER(?) OR descripcion LIKE LOWER(?)";
            $params[] = '%' . $aKeyword[$i] . '%';
            $params[] = '%' . $aKeyword[$i] . '%';
        }
    }
}

// Filtros de categorías
if (!empty($_GET['categorias']) && is_array($_GET['categorias'])) {
    $categorias = $_GET['categorias'];
    $placeholders = rtrim(str_repeat('?,', count($categorias)), ',');

    if (!in_array('Todos', $categorias)) {
        $sql .= " AND id_categoria IN ($placeholders)";
        $countSql .= " AND id_categoria IN ($placeholders)";
        $params = array_merge($params, $categorias);
    }
}

// Filtros de tamaño
if (!empty($_GET['tamano']) && is_array($_GET['tamano'])) {
    $tamano = $_GET['tamano'];
    $placeholders = rtrim(str_repeat('?,', count($tamano)), ',');
    $sql .= " AND tamaño IN ($placeholders)";
    $countSql .= " AND tamaño IN ($placeholders)";
    $params = array_merge($params, $tamano);
}

// Filtros de tipo
if (!empty($_GET['tipo']) && is_array($_GET['tipo'])) {
    $tipo = $_GET['tipo'];
    $placeholders = rtrim(str_repeat('?,', count($tipo)), ',');
    $sql .= " AND tipo IN ($placeholders)";
    $countSql .= " AND tipo IN ($placeholders)";
    $params = array_merge($params, $tipo);
}

// Filtros de precio
if (!empty($_GET['precio']) && is_array($_GET['precio'])) {
    $precios = $_GET['precio'];
    $placeholders = rtrim(str_repeat('?,', count($precios)), ',');
    $sql .= " AND precio IN ($placeholders)";
    $countSql .= " AND precio IN ($placeholders)";
    $params = array_merge($params, $precios);
}

// Filtros adicionales
if (!empty($_GET['buscadepartamento'])) {
    $sql .= " AND cantidad = ?";
    $countSql .= " AND cantidad = ?";
    $params[] = $_GET['buscadepartamento'];
}
if (!empty($_GET['color'])) {
    $sql .= " AND color = ?";
    $countSql .= " AND color = ?";
    $params[] = $_GET['color'];
}
if (!empty($_GET['buscafechadesde']) && !empty($_GET['buscafechahasta'])) {
    $sql .= " AND fecha BETWEEN ? AND ?";
    $countSql .= " AND fecha BETWEEN ? AND ?";
    $params[] = $_GET['buscafechadesde'];
    $params[] = $_GET['buscafechahasta'];
}
if (!empty($_GET['buscapreciodesde'])) {
    $sql .= " AND precio >= ?";
    $countSql .= " AND precio >= ?";
    $params[] = $_GET['buscapreciodesde'];
}
if (!empty($_GET['buscapreciohasta'])) {
    $sql .= " AND precio <= ?";
    $countSql .= " AND precio <= ?";
    $params[] = $_GET['buscapreciohasta'];
}

// Ordenación
$ordenes = [
    '1' => 'nombre ASC',
    '2' => 'departamento ASC',
    '3' => 'color ASC',
    '4' => 'precio ASC',
    '5' => 'precio DESC',
    '6' => 'fecha ASC',
    '7' => 'fecha DESC'
];
if (!empty($_GET['orden']) && isset($ordenes[$_GET['orden']])) {
    $sql .= " ORDER BY " . $ordenes[$_GET['orden']];
}

// Aplicar límite y offset para paginación
$sql .= " LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;


// Preparar y ejecutar la consulta
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// Vincular parámetros dinámicamente
$types = str_repeat('s', count($params) - 2) . 'ii';
if ($types) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Almacenar los productos en un array para usarlos en la vista
$productos = [];
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

// Obtener el número total de productos para la paginación
$countStmt = $conn->prepare($countSql);
if ($countStmt === false) {
    die("Count prepare failed: " . $conn->error);
}
$countParams = array_slice($params, 0, -2); // Quitar los últimos dos parámetros (limit y offset)
$countTypes = str_repeat('s', count($countParams));
if ($countTypes) {
    $countStmt->bind_param($countTypes, ...$countParams);
}
$countStmt->execute();
$countResult = $countStmt->get_result();
$total_products = $countResult->fetch_assoc()['total'];
$total_pages = ceil($total_products / $limit);

$stmt->close();
$countStmt->close();
$conn->close();
?>
