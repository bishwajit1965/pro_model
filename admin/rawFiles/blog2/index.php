<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <?php include_once('../admin/classes/autoloader.php');
    include_once'../admin/dbconfig.php';
    ?>
</head>
<body>
    <h1>Test</h1>
    <?php

    $article = new Article;
    $suery = "SELECT * FROM tbl_article";
    $article->viewData($query);
        ?>
</body>
</html>
