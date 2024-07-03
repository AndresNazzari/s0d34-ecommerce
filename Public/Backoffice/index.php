<?php
require_once '../../vendor/autoload.php';

use App\Config\Constants;
use App\Repositories\ProductRepository;
use App\Services\ProductService;

$partialsDir = __DIR__ . '/partials/';

$productRepository = new ProductRepository();
$productService = new ProductService($productRepository);

$products = $productService->get([],  Constants::PRODUCTS_JOIN);

?>
<!DOCTYPE html>
<html lang="en">
    <!-- HEAD -->
    <?php include '../../Public/Partials/head.php' ?>

    <body>
        <!-- Product grid -->
        <?php ?>
        <div class="container d-flex justify-content-evenly flex-wrap">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">Category</th>
                </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php if (empty($products)): ?>
                        <p>No hay productos disponibles en este momento.</p>
                    <?php else: ?>
                        <?php foreach ($products as $product):  ?>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="Js/scripts.js"></script>
    </body>
</html>


<?php

?>