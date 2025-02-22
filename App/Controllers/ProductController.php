<?php
require '../../vendor/autoload.php';

use App\Controllers\Router;
use App\Repositories\DetailRepository;
use App\Repositories\ImageRepository;
use App\Repositories\ProductRepository;
use App\Services\ImageService;
use App\Services\ProductService;

$productRepository = new ProductRepository();
$detailRepository = new DetailRepository();
$imageRepository = new ImageRepository();
$imageService = new ImageService($imageRepository);

$productService = new ProductService($productRepository, $detailRepository, $imageService);

$router = new Router();

$router->create(function () use ($productService) {
    $data = [
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'price' => $_POST['price'],
        'id_products_categories' => $_POST['category'],
        'image' => $_FILES['image']
    ];

    $productService->create($data);
});


$router->update(function () use ($productService) {
    $id = (int) $_POST['productId'];
    $data = [
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'price' => $_POST['price'],
        'id_products_categories' => $_POST['category'],
    ];

    // Manejar la carga de la imagen
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $data['image'] = $_FILES['image'];
    } else {
        $data['image'] = null;
    }

    $productService->update($id, $data);
});

$router->delete(function () use ($productService) {
    $id = (int) $_GET['id'];
    $data = ['is_deleted' => 1];

    $productService->softDelete($id, $data);
});

header('Location: ../../Public/index.php');
exit;


//if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) ) {
//    if ($_POST['action'] === 'create') {
//        $data = [
//            'name' => $_POST['name'],
//            'description' => $_POST['description'],
//            'price' => $_POST['price'],
//            'id_products_categories' => $_POST['category'],
//            'image' => $_FILES['image']
//        ];
//
//        $productService->create($data);
//        header('Location: ../../Public/index.php');
//        exit;
//    }
//
//    if ($_POST['action'] === 'update'){
//        $id = (int) $_POST['productId'];
//        $data = [
//            'name' => $_POST['name'],
//            'description' => $_POST['description'],
//            'price' => $_POST['price'],
//            'id_products_categories' => $_POST['category'],
//        ];
//
//        // Manejar la carga de la imagen
//        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
//            $data['image'] = $_FILES['image'];
//        } else {
//            $data['image'] = null;
//        }
//
//        $productService->update($id, $data);
//    }
//
//    if (isset($_GET['id']) && $_POST['action'] === 'delete'){
//        $id = (int) $_GET['id'];
//        $data = ['is_deleted' => 1];
//
//        $productService->softDelete($id, $data);
//    }
//
//    header('location: ../../Public/index.php');
//    exit;
//}
