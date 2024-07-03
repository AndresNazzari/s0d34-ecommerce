<?php
use App\Services\CategoryService;
use App\Repositories\CategoryRepository;

$categoryRepository = new CategoryRepository();
$categoryService = new CategoryService($categoryRepository);
$categories = $categoryService->get();

$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);

?>

<nav class="w3-sidebar w3-bar-block w3-white w3-collapse w3-top" style="z-index:3;width:250px" id="mySidebar">
    <div class="w3-container w3-display-container w3-padding-16">
        <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-display-topright"></i>
        <h3 class="w3-wide"><a href="index.php">ACN3AV</a></h3>
    </div>
    <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
        <?php foreach ($categories as $category): ?>
            <a href="index.php?C=<?php echo $category->id ?>" class="w3-bar-item w3-button"> <?php echo $category->name ?></a>
        <?php endforeach; ?>
    </div>

    <form class="m-4" action="../App/Controllers/UserController.php" method="post" enctype="multipart/form-data" >
        <?php if(!isset($_SESSION['userId'])): ?>
            <input type="hidden" name="action" value="login">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <?php if ($error): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <button class="w3-bar-item w3-button w3-padding" type="submit">Login</button>
        <?php else: ?>
            <input type="hidden" name="action" value="logout">
            <button class="w3-bar-item w3-button w3-padding" type="submit">Logout</button>
        <?php endif; ?>

    </form>

</nav>
