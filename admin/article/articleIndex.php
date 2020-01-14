<?php include_once('../partials/_head.php'); ?>
<!-- Site wrapper -->
<div class="wrapper">
    <?php include_once('../partials/_header.php'); ?>
    <!-- =============================================== -->
    <!-- Left side column. contains the sidebar -->
    <?php include_once '../partials/_leftSidebar.php'; ?>
    <!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Article index
                <small>it all starts here</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Examples</a></li>
                <li class="active">Blank page</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <!-- <h3 class="box-title">Category index</h3> -->
                    <a href="addArticle.php" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add article</a>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <!-- Code below -->
                    <?php
                    // Will load vendor autoLoader
                    require_once('../app/start.php');

                    use CodeCourse\Repositories\Article as Article;
                    use CodeCourse\Repositories\Category as Category;
                    use CodeCourse\Repositories\Helpers as Helpers;
                    use CodeCourse\Repositories\Session as Session;
                    use CodeCourse\Repositories\Tag as Tag;

                    // Classes instantiated
                    $article = new Article;
                    $category = new Category;
                    $helpers = new Helpers;
                    $tag = new Tag;

                    // Tables to be operated upon
                    $table = 'tbl_articles';
                    $tableCategory = 'tbl_category';
                    $tableTag = 'tbl_tag';

                    // Display validation message if any
                    Session::init();
                    $message = Session::get('message');
                    if (!empty($message)) {
                        echo $message;
                        Session::set('message', null);
                    }
                    ?>
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Photo</th>
                                    <th>Status</th>
                                    <th>Category</th>
                                    <th>Tag</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th>Will publ</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $order_by = ['order_by' => 'category_id DESC'];
                                /*
                                $selectCond = ['select' => 'name'];
                                $whereCond = [
                                'where' => ['id' => '1', 'email' => 'bishwajit@gmail.com'],
                                'return_type' => 'single'
                                ];
                                $limit = ['start' => '2', 'limit' =>'4'];
                                $limit = ['limit' => '4'];
                                There is problem in $whereCond
                                $whereCond = [
                                'where' => ['id' => '2', 'email' => 'bishwajit@gmail.com'],
                                'return_type' => 'single'
                                ];
                                */
                                $articleData = $article->select($table, $order_by);
                                if (!empty($articleData)) {
                                    $i = 1;
                                    foreach ($articleData as $article) { ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $helpers->textShorten($article->title, 40); ?></td>
                                            <td><?= $article->author; ?></td>
                                            <td>
                                                <?php if (!empty($article->photo)) : ?>
                                                    <img src="<?= $article->photo; ?>" style="width:80px;height:50px;" class="img-rounded img-thumbnail" alt="Article photo">
                                                <?php else : ?>
                                                    <img src="../images/avatar/avatar.jpg" style="width:60px;height:60px;" class="img-rounded img-thumbnail" alt="Avatar">
                                                <?php endif ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($article->status == '0') {
                                                    echo 'Published';
                                                } elseif ($article->status == '1') {
                                                    echo 'Coming soon';
                                                } elseif ($article->status == '2') {
                                                    echo 'Draft';
                                                } elseif ($article->status == '3') {
                                                    echo 'Unpublished';
                                                } else {
                                                    echo 'Undefined';
                                                } ?>
                                            </td>
                                            <td>
                                                <?php
                                                $categoryData = $category->select($tableCategory);
                                                if (!empty($categoryData)) {
                                                    foreach ($categoryData as $value) {
                                                        if ($value->category_id == $article->category_id) {
                                                            echo $value->category_name;
                                                        }
                                                    }
                                                } ?>
                                            </td>
                                            <td>
                                                <?php
                                                $tagData = $tag->select($tableTag);
                                                if (!empty($tagData)) {
                                                    foreach ($tagData as $value) {
                                                        if ($value->tag_id == $article->tag_id) {
                                                            echo $value->tag_name;
                                                        }
                                                    }
                                                } ?>
                                            </td>
                                            <td><?= $helpers->dateFormat($article->created_at); ?></td>
                                            <td><?= $helpers->dateFormat($article->updated_at); ?></td>
                                            <td><?= $helpers->dateFormat($article->published_on); ?></td>
                                            <td>
                                                <a href="editarticle.php?edit_id=<?= $article->id; ?>" class="btn btn-xs btn-success btn-block"><i class="fa fa-edit"></i> Edit</a>

                                                <form style="margin-top:3px;" action="processArticle.php" method="post" accept-charset="utf-8">
                                                    <input type="hidden" name="action" value="verify">
                                                    <input type="hidden" name="id" value="<?= $article->id; ?>">

                                                    <button type="submit" name="submit" value="delete" class="btn btn-xs btn-danger btn-block" onClick="return confirm('Do you really want to delete this data ?');"><i class="fa fa-trash"></i> Delete </button>
                                                </form>
                                            </td>
                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Photo</th>
                                    <th>Status</th>
                                    <th>Category</th>
                                    <th>Tag</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th>Will publ</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- Code above -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">Footer</div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include_once('../partials/_footer.php'); ?>
</div>
<!-- ./wrapper -->
<?php include_once('../partials/_scripts.php'); ?>
</body>

</html>
