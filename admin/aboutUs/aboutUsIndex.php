<?php require_once '../partials/_head.php'; ?>
<!-- Site wrapper -->
<div class="wrapper">
    <?php require_once'../partials/_header.php'; ?>
    <!-- =============================================== -->
    <!-- Left side column. contains the sidebar -->
    <?php require_once '../partials/_leftSidebar.php'; ?>
    <!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Category index
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
                    <a href="addAboutUs.php" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add About Us</a>
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
                    // Will load vendor auto loader
                    require_once '../app/start.php';

                    use CodeCourse\Repositories\Session as Session;
                    use CodeCourse\Repositories\AboutUs as AboutUs;
                    use CodeCourse\Repositories\Helpers as Helpers;

                    $aboutUs = new AboutUs;
                    $helpers = new Helpers;

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
                                    <th>About us</th>
                                    <th>Created at</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $table = 'tbl_about_us';
                                $order_by = ['order_by' => 'id DESC'];
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
                                $aboutUsData = $aboutUs->select($table, $order_by);
                                if (!empty($aboutUsData)) {
                                    $i = 1;
                                    foreach ($aboutUsData as $aboutUs) { ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo htmlspecialchars_decode($aboutUs->about_us); ?></td>
                                            <td><?php echo $helpers->dateFormat($aboutUs->created_at); ?></td>
                                            <td>
                                                <a href="editAboutUs.php?edit_id=<?php echo $aboutUs->id; ?>" class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Edit</a>
                                            </td>
                                            <td>
                                                <form  action="processAboutUs.php" method="post" accept-charset="utf-8" style="display:inline-block;">
                                                    <input type="hidden" name="action" value="verify">
                                                    
                                                    <input type="hidden" name="id" value="<?php echo $aboutUs->id; ?>">

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
                                    <th>About us</th>
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
    <?php require_once'../partials/_footer.php'; ?>
</div>
<!-- ./wrapper -->
<?php require_once'../partials/_scripts.php'; ?>
</body>

</html>
