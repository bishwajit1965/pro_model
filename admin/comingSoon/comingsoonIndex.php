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
            <h1>Coming soon post index <small>it all starts here</small>
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
                    <a href="addcomingSoon.php" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add Coming soon Post</a>
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
                    require_once '../app/start.php';

                    use CodeCourse\Repositories\ComingSoon as ComingSoon;
                    use CodeCourse\Repositories\Helpers as Helpers;
                    use CodeCourse\Repositories\Session as Session;

                    // Classes instantiated
                    $comingSoon = new ComingSoon();
                    $helpers = new Helpers();
                    // Tables to be operated upon
                    $table = 'tbl_comingSoon';
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
                                    <th>Description</th>
                                    <th>Photo</th>
                                    <th>Status</th>
                                    <th>Will publ</th>
                                    <th>Updated</th>
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
                                $comingSoonData = $comingSoon->select($table, $order_by);
                                if (!empty($comingSoonData)) {
                                    $i = 1;
                                    foreach ($comingSoonData as $comingSoon) { ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $helpers->textShorten($comingSoon->title, 40); ?></td>
                                            <td><?php echo htmlspecialchars_decode($comingSoon->description); ?></td>
                                            <td><?php if (!empty($comingSoon->photo)) : ?>
                                                <img src="<?php echo $comingSoon->photo; ?>" style="width:80px;height:50px;" class="" alt="Article photo">
                                                <?php else : ?>
                                                    <img src="../images/avatar/avatar.jpg" style="width:60px;height:60px;" class="img-rounded img-thumbnail" alt="Avatar">
                                                <?php endif ?>
                                            </td>
                                            <td>
                                            <?php
                                            if ($comingSoon->status == '0') {
                                                echo 'Published';
                                            }elseif ($comingSoon->status == '1') {
                                                echo '<span style="color:red;font-weight:bold;">Coming soon</span>';
                                            } elseif ($comingSoon->status == '2') {
                                                echo '<span style="color:red;font-weight:bold;">Draft</span>';
                                            } else {
                                                # code...
                                            }
                                            ?>   
                                            </td>
                                            <td><?php echo $helpers->dateFormat($comingSoon->published_on); ?></td>
                                            
                                            <td><?php echo $helpers->dateFormat($comingSoon->updated_at); ?></td>
                                            <td>
                                                <a href="editcomingSoon.php?edit_id=<?php echo $comingSoon->id; ?>" class="btn btn-xs btn-success btn-block"><i class="fa fa-edit"></i> Edit</a>
                                                 
                                                <?php
                                                if ($comingSoon->status == '2') {
                                                    ?>
                                                    <form style="margin-top:3px;" action="processcomingSoon.php" method="post" accept-charset="utf-8">
                                                        <input type="hidden" name="action" value="verify">
                                                        <input type="hidden" name="id" value="<?php echo $comingSoon->id; ?>">
                                                        <input type="hidden" name="status" value="<?php echo '0'; ?>">

                                                        <button type="submit" name="submit" value="publish" class="btn btn-xs btn-info btn-block" onClick="return confirm('Do you really want to publish this article ?');"><i class="fa fa-list"></i> Publish </button>
                                                    </form>
                                                <?php
                                                } else {
                                                    ?>
                                                    <form style="margin-top:3px;" action="processcomingSoon.php" method="post" accept-charset="utf-8">
                                                        <input type="hidden" name="action" value="verify">
                                                        <input type="hidden" name="id" value="<?php echo $comingSoon->id; ?>">
                                                        <input type="hidden" name="status" value="<?php echo '2'; ?>">

                                                        <button type="submit" name="submit" value="unpublish" class="btn btn-xs btn-warning btn-block" onClick="return confirm('Do you really want to publish this article ?');"><i class="fa fa-list"></i> Unpublish </button>
                                                    </form>
                                                <?php
                                                }
                                                ?>
                                                <form style="margin-top:3px;" action="processcomingSoon.php" method="post" accept-charset="utf-8">
                                                    <input type="hidden" name="action" value="verify">
                                                    <input type="hidden" name="id" value="<?php echo $comingSoon->id; ?>">

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
                                    <th>Description</th>
                                    <th>Photo</th>
                                    <th>Status</th>
                                    <th>Will publ</th>
                                    <th>Updated</th>
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
