<?php
require_once '../vendor/autoload.php';

use App\Config\Constants;
use App\Config\DbConfig;
use App\Models\PermissionModel;
use App\Repositories\DetailRepository;
use App\Repositories\ImageRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use App\Services\ImageService;
use App\Services\ProductService;
use App\Services\UserService;

session_start();

DbConfig::createUsers();
$partialsDir = __DIR__ . '/partials/';
$where = [
    ['column' => 'products.is_deleted', 'operator' => '=', 'value' => 0]
];

if (isset($_GET['C'])) {
    $idCategory = (int)$_GET['C'];
    $whereCategory = [
        ['column' => 'products.id_products_categories', 'operator' => '=', 'value' => $idCategory]
    ];
    $where = array_merge($where, $whereCategory);
}

$imageRepository = new ImageRepository();
$imageService = new ImageService($imageRepository);

$productRepository = new ProductRepository();
$detailRepository = new DetailRepository();
$productService = new ProductService($productRepository, $detailRepository, $imageService);

$userRepository = new UserRepository();
$userService = new UserService($userRepository);

$products = $productService->get($where,  Constants::PRODUCTS_JOIN);

$userId = $_SESSION['userId'] ?? null;
$_SESSION['canDelete'] = $userId && $userService->can(PermissionModel::DELETE, $userId);
$_SESSION['canEdit'] = $userId && $userService->can(PermissionModel::UPDATE, $userId);
$_SESSION['canCreate'] = $userId && $userService->can(PermissionModel::CREATE, $userId);

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

        <!-- Product grid -->
        <div class="container d-flex justify-content-evenly flex-wrap">

            <?php if (empty($products)): ?>
                <p>No hay productos disponibles en este momento.</p>
            <?php else: ?>
                <?php foreach ($products as $product):  ?>
                        <div class="card mb-4 border-0 " style="width: 14rem; ">
                        <div class="d-flex justify-content-center align-items-center" style="width: 14rem; height: 300px; overflow: hidden;">
                            <img src="<?php echo Constants::IMAGES_DIR . $product->path ?>" class="img-fluid" alt="<?php echo $product->name ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title"><?php echo $product->name ?></h5>
                            <b>$<?php echo $product->price ?></b>
                            <div class="d-flex justify-content-between">
                                <a href="../Public/detail.php?id=<?php echo $product->id ?>" class="btn btn-primary">Details</a>
                                <?php if ($_SESSION['canEdit']): ?>
                                    <a href="../Public/detail.php?id=<?php echo $product->id ?>&edit=true" class="btn btn-warning">Edit</a>
                                <?php endif; ?>
                                <?php if ($_SESSION['canDelete']): ?>
                                    <form action="../App/Controllers/ProductController.php?id=<?php echo $product->id ?>" method="post" onsubmit="return confirm('Are you sure you want to delete this product?');">
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
