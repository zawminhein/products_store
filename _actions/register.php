<?php

include('../vendor/autoload.php');

use Helpers\HTTP;
use Libs\database\MySQL;
use Libs\database\UserController;

$data = [
      'name' => $_POST['name'],
      'email' => $_POST['email'],
      'password' => $_POST['password'],
   ];

$table = new UserController(new MySQL());
$table->createUser($data);

session_start();
$_SESSION['success'] = "User registered successfully! You can now login.";

HTTP::redirect('/login.php');