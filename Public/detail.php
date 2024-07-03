<?php
require_once '../vendor/autoload.php';

use App\Config\Constants;
use App\Repositories\CategoryRepository;
use App\Repositories\DetailRepository;
use App\Repositories\ImageRepository;
use App\Repositories\ProductRepository;
use App\Services\AuthService;
use App\Services\CategoryService;
use App\Services\ImageService;
use App\Services\ProductService;
session_start();

$partialsDir = __DIR__ . '/partials/';

$editMode = isset($_GET['edit']) && $_GET['edit'] === 'true';

if ($editMode) {
    $id = $_GET['id'] ?? 0;
    AuthService::verify("detail.php?id=$id");
}

if (isset($_GET['create']) && $_GET['create'] === 'true') {
    AuthService::verify("index.php");
    $createMode = true;
} else {
    $createMode = false;
}

$where = [
    ['column' => 'products.is_deleted', 'operator' => '=', 'value' => 0]
];

if (!$createMode && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $whereId = [
        ['column' => 'products.id', 'operator' => '=', 'value' => $id]
    ];
    $where = array_merge($where, $whereId);
}

$categoryRepository = new CategoryRepository();
$categoryService = new CategoryService($categoryRepository);
$categories = $categoryService->get();

$imageRepository = new ImageRepository();
$imageService = new ImageService($imageRepository);

$productRepository = new ProductRepository();
$detailRepository = new DetailRepository();
$productService = new ProductService($productRepository, $detailRepository, $imageService);

$products = $createMode ? [] : $productService->get($where,  Constants::PRODUCTS_JOIN);

?>
<!DOCTYPE html>
<html lang="en">
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

        <!-- Product grid -->
        <?php ?>
        <div class="container d-flex justify-content-evenly flex-wrap">

            <?php if ($createMode): ?>
                <div class="card mb-4 border-0 w-75">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <form action="../App/Controllers/ProductController.php" method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to create this product?');">
                            <input type="hidden" name="action" value="create">
                            <div class="mb-3">
                                <label for="productName" class="form-label">Title</label>
                                <input type="text" class="form-control" id="productName" name="name" value="">
                            </div>
                            <div class="mb-3">
                                <label for="productPrice" class="form-label">Price</label>
                                <input type="text" class="form-control" id="productPrice" name="price" value="">
                            </div>
                            <div class="mb-3">
                                <label for="productDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="productDescription" name="description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="productCategory" class="form-label">Category</label>
                                <select class="form-control" id="productCategory" name="category">
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo $category->id ?>"><?php echo $category->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="productImage" class="form-label">Image</label>
                                <input type="file" class="form-control" id="productImage" name="image">
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="index.php" class="btn btn-primary">Volver</a>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php elseif (empty($products)): ?>
                <p>No hay productos disponibles en este momento.</p>
            <?php else: ?>
                <?php foreach ($products as $product):  ?>
                    <div class="card mb-4 border-0 w-75 " >
                        <div class="d-flex justify-content-center align-items-center" style="width: 14rem; height: 300px; overflow: hidden;">
                            <img src="<?php echo Constants::IMAGES_DIR . $product->path ?>" class="img-fluid" alt="<?php echo $product->name ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between">
                            <?php if ($editMode): ?>
                                <form action="../App/Controllers/ProductController.php" method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to update this product?');">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="productId" value="<?php echo $product->id ?>">
                                    <div class="mb-3">
                                        <label for="productImage" class="form-label">Image</label>
                                        <input type="file" class="form-control" id="productImage" name="image">
                                    </div>
                                    <div class="mb-3">
                                        <label for="productName" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="productName" name="name" value="<?php echo $product->name ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="productPrice" class="form-label">Price</label>
                                        <input type="text" class="form-control" id="productPrice" name="price" value="<?php echo $product->price ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="productDescription" class="form-label">Description</label>
                                        <textarea class="form-control" id="productDescription" name="description"><?php echo $product->description ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="productCategory" class="form-label">Category</label>
                                         <select class="form-control" id="productCategory" name="category">
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?php echo $category->id ?>" <?php if ($category->id == $product->id_products_categories) echo 'selected'; ?>>
                                                    <?php echo $category->name ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <a href="detail.php?id=<?php echo $product->id ?>" class="btn btn-primary">Volver</a>
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </div>
                                </form>
                            <?php else: ?>

                                <h5 class="card-title"><?php echo $product->name ?></h5>
                                <b>$<?php echo $product->price ?></b>
                                <p class="card-text"><?php echo $product->description ?></p>
                                <div class="d-flex justify-content-between">
                                    <a href="index.php" class="btn btn-primary">Volver</a>
                                    <?php if ($_SESSION['canEdit']): ?>
                                        <a href="detail.php?id=<?php echo $product->id ?>&edit=true" class="btn btn-warning">Edit</a>
                                    <?php endif; ?>
                                    <?php if ($_SESSION['canDelete']): ?>
                                        <form action="../App/Controllers/ProductController.php?id=<?php echo $product->id ?>" method="post" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="productId" value="<?php echo $product->id ?>">
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
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
