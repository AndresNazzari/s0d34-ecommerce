<?php
require '../../vendor/autoload.php';

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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) ) {
    if (isset($_GET['id']) && $_POST['action'] === 'delete'){
        $id = (int) $_GET['id'];
        $data = ['is_deleted' => 1];

        $productService->softDelete($id, $data);
    }

    if ($_POST['action'] === 'update'){
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
    }

    header('location: ../../Public/index.php');
    exit;
}
