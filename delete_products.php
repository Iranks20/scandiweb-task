<?php
// Include necessary files and initialize classes
require_once 'config.php';
require_once 'Product.php';
require_once 'Book.php';
require_once 'DVD.php';
require_once 'Furniture.php';

// Delete selected products
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productIds = $_POST['productIds'];

    foreach ($productIds as $productId) {
        $product = Product::getProductById($productId);
        if ($product) {
            $product->delete();
        }
    }

    echo json_encode(['success' => true]);
    exit;
}
