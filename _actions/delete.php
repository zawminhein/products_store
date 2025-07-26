<?php

include('../vendor/autoload.php');

use Helpers\Auth;
use Helpers\HTTP;
use Libs\database\MySQL;
use Libs\database\ProductController;

$auth = Auth::check();
if ($auth->role !== 'admin') {
    header('Location: index.php');
    exit();
}

$table = new ProductController(new MySQL());
$table->deleteProduct($_GET['id']);

session_start();
$_SESSION['success'] = "Product deleted successfully!";

HTTP::redirect('../admin.php');