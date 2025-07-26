<?php

include('../vendor/autoload.php');

use Helpers\Auth;
use Helpers\HTTP;

$auth = Auth::check();
if ($auth->role !== 'admin') {
    header('Location: index.php');
    exit();
}

use Libs\database\MySQL;
use Libs\database\ProductController;

$table = new ProductController(new MySQL());
$data = [
    'name' => $_POST['name'],
    'price' => $_POST['price'],
    'quantity_available' => $_POST['quantity_available'],
    'photo' => $_FILES['photo']['name'] ?? null
];
$tmp = $_FILES['photo']['tmp_name'] ?? null;
$type = $_FILES['photo']['type'] ?? null;
// var_dump($data); // Debugging line to check the data being sent
session_start();

if ($table->addProduct($data)) {
    if (isset($data['photo']) && $data['photo'] !== '') {
        if ($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/jpg') {
            move_uploaded_file($tmp, '../img/' . $data['photo']); // Save the image in the folder
        } else {
            $_SESSION['error'] = 'Invalid image type. Only JPEG and PNG are allowed.';
            HTTP::redirect('../add_product.php');
            exit();
        }
    }

    $_SESSION['success'] = "Product added successfully!";
    HTTP::redirect('../admin.php');
} else {
    $_SESSION['error'] = "Failed to add product.";
    HTTP::redirect('../add_product.php');
}

// if($data['photo'] == '')
// {
//     $table->addProduct($data); // If no photo is uploaded, set it to null
//     $_SESSION['success'] = 'Product added successfully!';
//     HTTP::redirect('../admin.php');
//     exit();
// } else {
//     if($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/jpg') {
//         move_uploaded_file($tmp, '../img/' . $data['photo']); // Save the image in the folder
//         $table->addProduct($data); // Add the product with the image
//         $_SESSION['success'] = 'Product added successfully!';
//         HTTP::redirect('../admin.php');
//     } else {
//         $_SESSION['error'] = 'Invalid image type. Only JPEG, PNG, and GIF are allowed.';
//         HTTP::redirect('../add_product.php');
//     }
// }