<?php 

include('vendor/autoload.php');

use Libs\database\MySQL;
use Libs\database\ProductController;
use Helpers\Auth;

$auth = Auth::check();


$products = new ProductController(new MySQL());
$allProducts = $products->getAllProducts();
// var_dump($allProducts); // For debugging, remove in production
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products Stroe</title>

   <link rel="stylesheet" href="css/bootstrap.min.css">
   <script src="js/bootstrap.bundle.min.js" defer></script>
</head>
<body>

   <?php if (isset($_GET['auth']) && $_GET['auth'] === 'fail'): ?>
      <div class="container mt-3">
         <div class="alert alert-danger text-center">
            You do not have permission to access the admin page. Please login as an admin.
         </div>
      </div>
   <?php endif; ?>

   <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
         <?php if ($auth): ?>
            <div class="dropdown">
               <a class="navbar-brand dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <?= htmlspecialchars($auth->name) ?>
                  <span class="text-muted">(<?= htmlspecialchars($auth->role) ?>)</span>
               </a>
               <ul class="dropdown-menu" aria-labelledby="userDropdown">
                  <li><a class="dropdown-item" href="_actions/logout.php">Logout</a></li>
               </ul>
            </div>
         <?php else: ?>
            <a class="navbar-brand" href="index.php">Products Store</a>
         <?php endif; ?>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
               <li class="nav-item active">
                  <a class="nav-link" href="admin.php">Admin Pannel</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="index.php">Products</a>
               </li>
               <?php if (!$auth): ?>
                  <li class="nav-item">
                     <a class="nav-link" href="login.php">Login</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="register.php">Register</a>
                  </li>
               <?php endif; ?>
            </ul>
         </div>
      </div>
   </nav>

   <div class="container">
      <div class="row my-4">
         <div class="col-md-12">
            <h1 class="text-center">Welcome to Our Products Store</h1>
         </div>
      </div>

      <div class="row">
         <?php foreach ($allProducts as $product): ?>
            <div class="col-md-4 mb-4 d-flex align-items-stretch">
               <div class="card h-100 shadow-sm w-100">
                  <?php if (empty($product->img)) : ?>
                     <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 220px; background-color: #f8f9fa;">
                        <span class="text-muted">No Image Available</span>
                     </div>
                  <?php else : ?>
                  <img src="img/<?= $product->img ?>" class="card-img-top img-fluid" style="height:220px;object-fit:cover;">
                  <?php endif; ?>
                  <div class="card-body d-flex flex-column">
                     <h5 class="card-title"><?= $product->name ?></h5>
                     <h6 class="card-subtitle mb-2 text-muted">Price: <?= $product->price ?> USD</h6>
                     <p class="card-text flex-grow-1">Quantity Available: <?= $product->quantity_available ?></p>
                     <?php if (($auth && isset($auth->role) && $auth->role === 'user') || !$auth): ?>
                     <a href="_actions/add-order.php?id=<?= $product->id ?>" class="btn btn-primary mt-auto">Order Now</a>
                     <?php elseif ($auth->role === 'admin'): ?>
                     <div class="d-flex gap-2 mt-3">
                        <a href="edit_product.php?id=<?= $product->id ?>" class="btn btn-sm btn-primary w-50">Edit</a>
                        <a href="_actions/delete.php?id=<?= $product->id ?>" class="btn btn-sm btn-danger w-50">Delete</a>
                     </div>
                     <?php endif; ?>
                  </div>
               </div>
            </div>
         <?php endforeach; ?>
      </div>

      <footer class="text-center mt-5">
         <p>&copy; 2025 Products Store. All rights reserved.</p>
      </footer>
   </div>
</body>
</html>