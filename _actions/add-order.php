<?php

include('../vendor/autoload.php');

use Libs\database\MySQL;
use Libs\database\OrderController;
use Helpers\HTTP;
use Helpers\Auth;

$auth = Auth::check();
if (!$auth) {
    $_SESSION['error'] = 'You must be logged in to place an order.';
    HTTP::redirect('/login.php');
    exit();
}

$table = new OrderController(new MySQL());
$productId = $_GET['id'] ?? null;

$data = [
   'username' => $auth->name ?? null,
   'product_id' => $productId ?? null,
   'qty' => 1 ?? null,
];

// var_dump($data); // For debugging, remove in production

$table->createOrder($data);
session_start();
$_SESSION['success'] = 'Order placed successfully!';
HTTP::redirect('/order.php?order=success');