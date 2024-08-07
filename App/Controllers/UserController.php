<?php
require '../../vendor/autoload.php';

use App\Controllers\Router;
use App\Services\AuthService;

session_start();

$authService = new AuthService();

$router = new Router();

$router->login(function () use ($authService) {
    $userId = $authService::login($_POST['username'], $_POST['password']);
            if ($userId) {
                $_SESSION['userId'] = $userId;

            }

            $_SESSION['error'] = "Invalid username or password.";
});

$router->logout(function () use ($authService) {
    session_unset();
        session_destroy();
});

header('location: ../../Public/index.php');
exit;

//if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])  ){
//    if ($_POST['action'] === 'login') {
//            $userId = $authService::login($_POST['username'], $_POST['password']);
//            if ($userId) {
//                $_SESSION['userId'] = $userId;
//                header('location: ../../Public/index.php');
//                exit;
//            }
//
//            $_SESSION['error'] = "Invalid username or password.";
//            header('location: ../../Public/index.php');
//            exit;
//    }
//
//    if ($_POST['action'] === 'logout') {
//        session_unset();
//        session_destroy();
//        header('Location: ../../Public/index.php');
//        exit;
//    }
//}

