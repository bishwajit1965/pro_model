<?php
include_once '../../admin/app/start.php';
use Codecourse\Repositories\Category as Category;

$category = new Category();
$table = 'tbl_category';

?>
<div class="col-sm-2 bg-secondary text-white p-0">
    <div class="px-2 heading-bar bg-info text-white">Categories</div>
    <ul>
        <?php
        $categoryData = $category->index($table);
        if (!empty($categoryData)) {
            foreach ($categoryData as $category) {
                ?>
                <li>
                    <a href="pages/category.php?cat_id=<?=$category->cat_id;?>"><?= $category->cat_name;  ?></a></li>
                <?php
            }
        }
        ?>
    </ul>
    <div class="px-2 heading-bar bg-info text-white">Products</div>
</div>
