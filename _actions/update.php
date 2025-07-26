<?php

include('../vendor/autoload.php');

use Libs\database\MySQL;
use Libs\database\ProductController;
use Helpers\HTTP;

$data = [
    'id' => $_POST['id'],
    'name' => $_POST['name'],
    'price' => $_POST['price'],
    'quantity_available' => $_POST['quantity_available'],
    'photo' => $_FILES['photo']['name'] ?? null
];

session_start();

// var_dump($data);

$table = new ProductController(new MySQL());
$product = $table->getProductById($data['id']);
if ($table->updateProduct($data)) {
   if($data['photo'] == '')
   {
      $data['photo'] = $product->img;
   }
   if (isset($data['photo'])) {
       move_uploaded_file($_FILES['photo']['tmp_name'], '../img/'.$data['photo']);
      //  $product->img = $data['photo'];
   }

   $_SESSION['success'] = "Product updated successfully!";
   HTTP::redirect('../admin.php');
} else {
   $_SESSION['error'] = "Failed to update product.";
   HTTP::redirect('../edit_product.php?id=' . $data['id']);
}
