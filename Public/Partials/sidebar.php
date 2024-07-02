<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use App\Services\CategoryService;
use App\Repositories\CategoryRepository;

$categoryRepository = new CategoryRepository();
$categoryService = new CategoryService($categoryRepository);
$categories = $categoryService->get();

?>

<nav class="w3-sidebar w3-bar-block w3-white w3-collapse w3-top" style="z-index:3;width:250px" id="mySidebar">
    <div class="w3-container w3-display-container w3-padding-16">
        <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-display-topright"></i>
        <h3 class="w3-wide"><b>ACN3AV</b></h3>
    </div>
    <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
        <?php foreach ($categories as $category): ?>
            <a href="#" class="w3-bar-item w3-button"> <?php echo $category->name ?></a>
        <?php endforeach; ?>
    </div>
    <a href="#footer"  class="w3-bar-item w3-button w3-padding">Login</a>
</nav>
