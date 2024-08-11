<?php
require_once 'C:\xampp\htdocs\neumati\Config\Database.php';

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 9;
$offset = ($page - 1) * $limit;

$products = Database::getProducts($offset, $limit);
$total_products = Database::getTotalProducts();
$total_pages = ceil($total_products / $limit);

$response = [
    'products' => $products,
    'total_pages' => $total_pages,
];

header('Content-Type: application/json');
echo json_encode($response);
?>
