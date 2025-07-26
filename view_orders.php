<?php
include('vendor/autoload.php');

use Helpers\Auth;
use Helpers\HTTP;
use Libs\database\OrderController;
use Libs\database\MySQL;
use Libs\database\ProductController;

$table = new OrderController(new MySQL());
$orders = $table->getAllOrders();

$products = new ProductController(new MySQL());
$allProducts = $products->getAllProducts();
$product = $products->getProductById($_GET['id'] ?? null);


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>View Order</title>
   <link rel="stylesheet" href="css/bootstrap.min.css">
   <script src="js/bootstrap.bundle.min.js" defer></script>
</head>
<body>
   <div class="container">
      <h1 class="mt-5">Order Details</h1>
      <?php if (isset($orders) && $orders): ?>
         <div class="card mt-3">
            <div class="card-body">

               <table class="table">
                  <thead>
                     <tr>
                        <th>Username</th>
                        <th>Product</th>
                        <th>Quantity</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($orders as $order): ?>
                        <tr>
                           <td><?= htmlspecialchars($order->username) ?></td>
                           <td>
                              <?php if ($order->product_id): ?>
                                 <?php $product = $products->getProductById($order->product_id); ?>
                                 <?= htmlspecialchars($product->name) ?>
                              <?php else: ?>
                                 N/A
                              <?php endif; ?>
                           </td>
                           <td><?= htmlspecialchars($order->qty) ?></td>
                        </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>
            </div>
         </div>
      <?php else: ?>
         <div class="alert alert-warning mt-3">
            No order details found.
         </div>
      <?php endif; ?>

      <button class="btn btn-primary mt-3" onclick="window.location.href='admin.php'">Back to Products</button>
   </div>
</body>
</html>