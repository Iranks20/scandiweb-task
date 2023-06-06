<?php

require_once 'Product.php';
require_once 'Book.php';
require_once 'DVD.php';
require_once 'Furniture.php';

$host = 'localhost';
$dbname = 'scandiweb';
$username = 'root';
$password = '';

try {
    $connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Set the database connection for the Product class
Product::setConnection($connection);
