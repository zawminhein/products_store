<?php 
   include('vendor/autoload.php');

   use Helpers\Auth;
   $auth = Auth::check();
   if ($auth->role !== 'admin') {
      header('Location: index.php');
      exit();
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Create Products</title>

   <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
   <div class="container">

   <?php if(isset($_SESSION['error'])): ?>
      <div class="alert alert-danger">
         <?= $_SESSION['error'] ?>
         <?php unset($_SESSION['error']); ?>
      </div>
   <?php endif; ?>

      <div class="row my-4">
         <div class="col-md-12">
            <h1 class="text-center">Create Product</h1>
         </div>
      </div>

      <div class="row">
         <div class="col-md-6 offset-md-3">
            <form action="_actions/add.php" method="POST" enctype="multipart/form-data">
               <div class="mb-3">
                  <label for="photo" class="form-label">Photo</label>
                  <input type="file" class="form-control" id="photo" name="photo">
               </div>
               <div class="mb-3">
                  <label for="name" class="form-label">Product Name</label>
                  <input type="text" class="form-control" id="name" name="name" required>
               </div>
               <div class="mb-3">
                  <label for="price" class="form-label">Price</label>
                  <input type="number" class="form-control" id="price" name="price" required>
               </div>
               <div class="mb-3">
                  <label for="quantity_available" class="form-label">Quantity Availabe</label>
                  <input type="number" class="form-control" id="quantity_available" name="quantity_available" required>
               </div>
               <button type="submit" class="btn btn-primary w-100">Add Product</button>
            </form>

            <button class="btn btn-secondary w-100 mt-3" onclick="window.location.href='admin.php'">Back to Admin Page</button>
         </div>
      </div>
   </div>
</body>
</html>