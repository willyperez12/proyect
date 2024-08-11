<?php
require 'config.php';

$stmt = $pdo->query('SELECT * FROM products');
$products = $stmt->fetchAll();

echo json_encode($products);
?>
