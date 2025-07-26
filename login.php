<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container text-center" style="max-width: 600px;">
        <h1 class="my-4 h3">Login</h1>

         <?php if(isset($_SESSION['error'])) : ?>
            <div class="alert alert-danger">
               <?= $_SESSION['error'] ?>
               <?php unset($_SESSION['error']); ?>
            </div>
         <?php endif ?>

        <?php if(isset($_SESSION['success'])) : ?>
            <div class="alert alert-info">
                <?= $_SESSION['success'] ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif ?>

        <form action="_actions/login.php" method="post" class="mb-3">
            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
            <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
            <button class="btn btn-primary w-100">Login</button>
        </form>
        <a href="register.php">Register</a>
    </div>
</body>
</html>