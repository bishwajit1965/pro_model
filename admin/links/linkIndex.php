<?php include_once '../partials/_head.php'; ?>
<!-- Site wrapper -->
<div class="wrapper">
    <?php require_once '../partials/_header.php'; ?>
    <!-- =============================================== -->
    <!-- Left side column. contains the sidebar -->
    <?php require_once '../partials/_leftSidebar.php'; ?>
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
                    <a href="addLink.php" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add Link Data</a>
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
                    // Will load vendor autoloader
                    require_once '../app/start.php';

                    use CodeCourse\Repositories\Session as Session;
                    use CodeCourse\Repositories\Link as Link;
                    use CodeCourse\Repositories\Helpers as Helpers;

                    // Instantiate classes
                    $link = new Link();
                    $helpers = new Helpers();

                    // Tables
                    $table = 'tbl_link';

                    // Will display validation messages
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
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Url</th>
                                    <th>Address</th>
                                    <th>Zipcode</th>
                                    <th>Country</th>
                                    <th>created at</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
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
                                $linkData = $link->select($table, $order_by);
                                if (!empty($linkData)) {
                                    $i = 1;
                                    foreach ($linkData as $link) { ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $link->title; ?></td>
                                            <td><?php echo $link->email; ?></td>
                                            <td><?php echo $link->phone; ?></td>
                                            <td><?php echo $link->url; ?></td>
                                            <td><?php echo $link->address; ?></td>
                                            <td><?php echo $link->zipcode; ?></td>
                                            <td><?php echo $link->country; ?></td>
                                            <td><?php echo $helpers->dateFormat($link->created_at); ?></td>
                                            <td>
                                                <a href="editLink.php?edit_id=<?php echo $link->id; ?>" class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Edit</a>

                                                <form style="display:inline;" action="processLink.php" method="post" accept-charset="utf-8">
                                                    <input type="hidden" name="action" value="verify">
                                                    <input type="hidden" name="id" value="<?php echo $link->id; ?>">

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
                                    <th>Title</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Url</th>
                                    <th>Address</th>
                                    <th>Zipcode</th>
                                    <th>Country</th>
                                    <th>created at</th>
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
    <?php require_once '../partials/_footer.php'; ?>
</div>
<!-- ./wrapper -->
<?php require_once '../partials/_scripts.php'; ?>
</body>

</html>