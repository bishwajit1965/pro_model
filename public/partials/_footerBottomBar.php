<div class="container-fluid footer-bottom-bar py-2 text-white text-center" style="background-color:#000;">
    <?php

    require_once '../admin/app/start.php';

    // Class included
    use CodeCourse\Repositories\Category as Copyright;

    // Classes instantiated
    $copyRight = new Copyright();

    // Table to be operated on
    $table = 'tbl_footer';
    $limit = ['limit' => '1'];
    $footerCopyrightData = $copyRight->select($table, $limit);
    if (!empty($footerCopyrightData)) {
        foreach ($footerCopyrightData as $copyRightText) {
            echo htmlspecialchars_decode($copyRightText->copyright_text);   
        }
    } else {
        echo 'Copyright data has not been uploaded yet !';
    }
    ?>
</div>
