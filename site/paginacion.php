<?php
require_once 'C:\xampp\htdocs\neumati\Config\Config.php';
require_once 'C:\xampp\htdocs\neumati\Config\Database.php';

$limit = 9;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$productos = Database::getProducts($offset, $limit);
$total_products = Database::getTotalProducts();
$total_pages = ceil($total_products / $limit);

?>

