<?php

include('../vendor/autoload.php');

use Helpers\HTTP;
use Libs\database\MySQL;
use Libs\database\UserController;

$data = [
    'email' => $_POST['email'],
    'password' => $_POST['password'],
];

// var_dump($data); // Debugging line to check the data being sent

$table = new UserController(new MySQL());
try {
    $user = $table->loginUser($data);
    
    if ($user) {
        session_start();
        $_SESSION['user'] = $user;
        HTTP::redirect('/index.php');
    } else {
        session_start();
        $_SESSION['error'] = "Invalid email or password.";
        HTTP::redirect('/login.php');
    }
} catch (Exception $e) {
    session_start();
    $_SESSION['error'] = $e->getMessage();
    HTTP::redirect('/login.php');
}
