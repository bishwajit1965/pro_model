<?php require_once '../partials/_head.php'; ?>
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
                Logo index
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
                    <a href="addLogo.php" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add Logo</a>
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

                    use CodeCourse\Repositories\Logo as Logo;
                    use CodeCourse\Repositories\Helpers as Helpers;
                    use CodeCourse\Repositories\Session as Session;

                    // Classses instantiated
                    $logo = new Logo;
                    $helpers = new Helpers;

                    // Tables to be operated upon
                    $table = 'tbl_logo';

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
                                    <th>Description</th>
                                    <th>Logo</th>
                                    <th>Created at</th>
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
                                $logoData = $logo->select($table, $order_by);
                                if (!empty($logoData)) {
                                    $i = 1;
                                    foreach ($logoData as $logo) { ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $helpers->textShorten($logo->description, 40); ?></td>

                                            <td>
                                                <?php if (!empty($logo->photo)) : ?>
                                                    <img src="<?php echo $logo->photo; ?>" style="width:80px;height:50px;" 
                                                    class="img-rounded img-thumbnail" alt="logo photo">
                                                <?php else : ?>
                                                    <img src="../images/avatar/avatar.jpg" style="width:60px;height:60px;" 
                                                    class="img-rounded img-thumbnail" alt="Avatar">
                                                <?php endif ?>
                                            </td>

                                            <td><?php echo $helpers->dateFormat($logo->created_at); ?></td>
                                            <td>
                                                <a href="editLogo.php?edit_id=<?php echo $logo->id; ?>" class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Edit</a>

                                                <form style="margin-top:3px;display:inline;" action="processLogo.php" method="post" accept-charset="utf-8">
                                                    <input type="hidden" name="action" value="verify">
                                                    <input type="hidden" name="id" value="<?php echo $logo->id; ?>">

                                                    <button type="submit" name="submit" value="delete" class="btn btn-xs btn-danger  " onClick="return confirm('Do you really want to delete this data ?');"><i class="fa fa-trash"></i> Delete </button>
                                                </form>
                                            </td>
                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Description</th>
                                    <th>Logo</th>
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
    <?php require_once '../partials/_footer.php'; ?>
</div>
<!-- ./wrapper -->
<?php require_once '../partials/_scripts.php'; ?>
</body>

</html>