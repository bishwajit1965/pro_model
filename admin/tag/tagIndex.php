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
            Tag index
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
                    <a href="addTag.php" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add Tag</a>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                        title="Remove">
                        <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <!-- Code below -->
                    <?php
                    // Will load vendor autoloader
                    require_once('../app/start.php');
                    use Codecourse\Repositories\Session as Session;
                    use Codecourse\Repositories\Tag as Tag;
                    use Codecourse\Repositories\Category as Category;
                    use Codecourse\Repositories\Helpers as Helpers;

                    // Instantiate classes
                    $category = new Category;
                    $tag = new Tag;
                    $helpers = new Helpers;

                    // Tables
                    $table = 'tbl_tag';
                    $tableCategory = 'tbl_category';

                    // Will disolay validation messages
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
                                    <th>Tag name</th>
                                    <th>Category name</th>
                                    <th>Created at</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $order_by = ['order_by' => 'tag_id DESC'];
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
                                $tagData = $tag->select($table, $order_by);
                                if (!empty($tagData)) {
                                    $i = 1;
                                    foreach ($tagData as $tag) { ?>
                                <tr>
                                    <td><?=$i++;?></td>
                                    <td><?=$tag->tag_name;?></td>
                                    <td>
                                        <?php $categoryData = $category->select($tableCategory); ?>
                                        <?php foreach ($categoryData as $value) : ?>
                                            <?php if ($tag->category_id == $value->category_id) {
                                                echo $value->category_name;
                                            } ?>
                                        <?php endforeach ?>
                                    </td>
                                    <td><?=$helpers->dateFormat($tag->created_at);?></td>
                                    <td>
                                        <a href="edittag.php?edit_id=<?=$tag->tag_id;?>" class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Edit</a>

                                        <form style="display:inline;" action="processTag.php" method="post" accept-charset="utf-8">
                                            <input type="hidden" name="action" value="verify">
                                            <input type="hidden" name="tag_id" value="<?=$tag->tag_id;?>">

                                            <button type="submit" name="submit" value="delete" class="btn btn-xs btn-danger" onClick="return confirm('Do you really want to delete this data ?');"><i class="fa fa-trash"></i> Delete </button>
                                        </form>
                                    </td>
                                </tr>
                                    <?php }
                                } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Tag name</th>
                                    <th>Category name</th>
                                    <th>Created at</th>
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
