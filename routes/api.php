<?php

include('../vendor/autoload.php');

use Libs\database\ProductController;
use Libs\database\MySQL;

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$controller = new ProductController(new MySQL());

switch (true) {
    // List all products
    case $uri === '/api/products' && $method === 'GET':
        $controller->getAllProducts();
        break;

    // Get a specific product
    case preg_match('/\/api\/products\/(\d+)/', $uri, $matches) && $method === 'GET':
        $controller->getProductById($matches[1]);
        break;

    // Create a new product
    case $uri === '/api/products' && $method === 'POST':
        $controller->addProduct($data);
        break;

    // Update a product
    case preg_match('/\/api\/products\/(\d+)/', $uri, $matches) && $method === 'PUT':
        $controller->updateProduct($matches[1]);
        break;

    // Delete a product
    case preg_match('/\/api\/products\/(\d+)/', $uri, $matches) && $method === 'DELETE':
        $controller->deleteProduct($matches[1]);
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);
        break;
}


