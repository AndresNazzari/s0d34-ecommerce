<?php
require_once '../vendor/autoload.php';

use App\Config\Constants;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
session_start();

$partialsDir = __DIR__ . '/partials/';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $where = [
        ['column' => 'products.id', 'operator' => '=', 'value' => $id]
    ];
} else {
    $where = [];
}

$productRepository = new ProductRepository();
$productService = new ProductService($productRepository);

$products = $productService->get($where,  Constants::PRODUCTS_JOIN);

?>
    <!DOCTYPE html>
    <html lang="en">
    <!-- -->

    <!-- HEAD -->
    <?php include $partialsDir . 'head.php' ?>

    <body>
    <!-- Sidebar/menu -->
    <?php include $partialsDir . 'sidebar.php' ?>

    <!-- Top menu on small screens -->
    <?php include $partialsDir . 'header.php' ?>

    <!-- Overlay effect when opening sidebar on small screens -->
    <?php include $partialsDir . 'overlay.php' ?>

    <!-- !PAGE CONTENT! -->
    <div class="w3-main" style="margin-left:250px">

        <!-- Push down content on small screens -->
        <div class="w3-hide-large" style="margin-top:83px"></div>

        <!-- Top header -->
        <?php include $partialsDir . 'contentHeader.php' ?>

        <!-- Image header -->
        <?php
        if (!isset($_GET['id'])){
            include $partialsDir . 'hero.php';
        }
        ?>

        <!-- Product grid -->
        <?php ?>
        <div class="container d-flex justify-content-evenly flex-wrap">

            <?php if (empty($products)): ?>
                <p>No hay productos disponibles en este momento.</p>
            <?php else: ?>
                <?php foreach ($products as $product):  ?>
                    <div class="card mb-4 border-0 w-75 " >
                        <div class="d-flex justify-content-center align-items-center" style="width: 14rem; height: 300px; overflow: hidden;">
                            <img src="<?php echo Constants::IMAGES_DIR . $product->path ?>" class="img-fluid" alt="<?php echo $product->name ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title"><?php echo $product->name ?></h5>
                            <b>$<?php echo $product->price ?></b>
                            <p class="card-text"><?php echo $product->description ?></p>
                            <div class="d-flex justify-content-between">
                                <a href="index.php" class="btn btn-primary">Volver</a>
                                <?php if ($_SESSION['canEdit']): ?>
                                    <a href="../Public/edit.php?id=<?php echo $product->id ?>" class="btn btn-warning">Edit</a>
                                <?php endif; ?>
                                <?php if ($_SESSION['canDelete']): ?>
                                    <form action="../App/Controllers/ProductController.php" method="post" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="productId" value="<?php echo $product->id ?>">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>


        <!-- Footer -->
        <?php include $partialsDir . 'footer.php' ?>

        <!-- Credits -->
        <?php include $partialsDir . 'credits.php' ?>


        <!-- End page content -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="Js/scripts.js"></script>
    </body>
    </html>


<?php

?>