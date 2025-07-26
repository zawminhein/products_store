<?php 
include('vendor/autoload.php');

use Helpers\Auth;
$auth = Auth::check();
if ($auth->role !== 'admin') {
    header('Location: index.php');
    exit();
}

use Libs\database\MySQL;
use Libs\database\ProductController;

$table = new ProductController(new MySQL());
$product = $table->getProductById($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Edit Products</title>

   <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
   <div class="container">
      <div class="row my-4">
         <div class="col-md-12">
            <h1 class="text-center">Edit Product</h1>
         </div>
      </div>

      <div class="row">
         <div class="col-md-6 offset-md-3">
            <form action="_actions/update.php" method="POST" enctype="multipart/form-data">
               <input type="hidden" name="id" value="<?= $product->id ?>">
               <div class="mb-3">
                     <?php if (isset($product->img) && $product->img): ?>
                        <img src="img/<?= htmlspecialchars($product->img) ?>" alt="<?= htmlspecialchars($product->name) ?>" class="img-fluid mb-3">
                     <?php else: ?>
                        <p class="text-muted">No photo available</p>
                     <?php endif; ?>
                  <input type="file" class="form-control" id="photo" name="photo"
               </div>
               <div class="mb-3">
                  <label for="name" class="form-label">Product Name</label>
                  <input type="text" class="form-control" id="name" name="name" value="<?= $product->name ?>" required>
               </div>
               <div class="mb-3">
                  <label for="price" class="form-label">Price</label>
                  <input type="number" class="form-control" id="price" name="price" value="<?= $product->price ?>" required>
               </div>
               <div class="mb-3">
                  <label for="quantity_available" class="form-label">Quantity Availabe</label>
                  <input type="number" class="form-control" id="quantity_available" name="quantity_available" value="<?= $product->quantity_available ?>" required>
               </div>
               <button type="submit" class="btn btn-primary w-100">Update Product</button>
            </form>

            <button class="btn btn-secondary w-100 mt-3" onclick="window.location.href='admin.php'">Back to Admin Page</button>
         </div>
      </div>
   </div>
</body>
</html>