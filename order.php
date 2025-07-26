<?php 
include('vendor/autoload.php');

use Helpers\Auth;
use Helpers\HTTP;

$auth = Auth::check();
if (!$auth || $auth->role !== 'user') {
    $_SESSION['error'] = 'You must be logged in as a user to place an order.';
    HTTP::redirect('/login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Order Page</title>
   <link rel="stylesheet" href="css/bootstrap.min.css">
   <script src="js/bootstrap.bundle.min.js" defer></script>
</head>
<body>
   <div class="container">
      <h1 class="my-4">Order Confirmation</h1>
      <?php if ($auth && $auth->role === 'user'): ?>
         <div class="alert alert-success">
            Thank you for your order, <?= htmlspecialchars($auth->name) ?>! Your order has been placed successfully.
         </div>
      <?php else: ?>
         <div class="alert alert-danger">
            You must be logged in as a user to place an order.
         </div>
      <?php endif; ?>
      <a href="index.php" class="btn btn-primary">Back to Products</a>
   </div>
</body>
</html>