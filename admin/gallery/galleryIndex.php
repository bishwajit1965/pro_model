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
               Photo Gallery index
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
                    <a href="addGallery.php" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add Photo To Gallery</a>
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

                    use CodeCourse\Repositories\Gallery as Gallery;
                    use CodeCourse\Repositories\Helpers as Helpers;
                    use CodeCourse\Repositories\Session as Session;

                    // Classes instantiated
                    $gallery = new Gallery();
                    $helpers = new Helpers();
                    // Tables to be operated upon
                    $table = 'tbl_gallery';
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
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th>Will publ</th>
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
                                $galleryData = $gallery->select($table, $order_by);
                                if (!empty($galleryData)) {
                                    $i = 1;
                                    foreach ($galleryData as $gallery) { ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $helpers->textShorten($gallery->title, 40); ?></td>
                                            <td><?php echo $gallery->description; ?></td>
                                            <td><?php if (!empty($gallery->photo)) : ?>
                                                <img src="<?php echo $gallery->photo; ?>" style="width:80px;height:50px;" class="" alt="Article photo">
                                                <?php else : ?>
                                                    <img src="../images/avatar/avatar.jpg" style="width:60px;height:60px;" class="img-rounded img-thumbnail" alt="Avatar">
                                                <?php endif ?>
                                            </td>
                                            <td>
                                            <?php
                                            if ($gallery->status == '0') {
                                                echo 'Published';
                                            } elseif ($gallery->status == '2') {
                                                echo '<span style="color:red;font-weight:bold;">Draft</span>';
                                            } else {
                                                # code...
                                            }
                                            ?>   
                                            </td>
                                            <td><?php echo $helpers->dateFormat($gallery->created_at); ?></td>
                                            <td><?php echo $helpers->dateFormat($gallery->updated_at); ?></td>
                                            <td><?php echo $helpers->dateFormat($gallery->published_on); ?></td>
                                            <td>
                                                <a href="editGallery.php?edit_id=<?php echo $gallery->id; ?>" class="btn btn-xs btn-success btn-block"><i class="fa fa-edit"></i> Edit</a>
                                                 
                                                <?php
                                                if ($gallery->status == '2') {
                                                    ?>
                                                    <form style="margin-top:3px;" action="processGallery.php" method="post" accept-charset="utf-8">
                                                        <input type="hidden" name="action" value="verify">
                                                        <input type="hidden" name="id" value="<?php echo $gallery->id; ?>">
                                                        <input type="hidden" name="status" value="<?php echo '0'; ?>">

                                                        <button type="submit" name="submit" value="publish" class="btn btn-xs btn-info btn-block" onClick="return confirm('Do you really want to publish this article ?');"><i class="fa fa-list"></i> Publish </button>
                                                    </form>
                                                <?php
                                                } else {
                                                    ?>
                                                    <form style="margin-top:3px;" action="processGallery.php" method="post" accept-charset="utf-8">
                                                        <input type="hidden" name="action" value="verify">
                                                        <input type="hidden" name="id" value="<?php echo $gallery->id; ?>">
                                                        <input type="hidden" name="status" value="<?php echo '2'; ?>">

                                                        <button type="submit" name="submit" value="unpublish" class="btn btn-xs btn-warning btn-block" onClick="return confirm('Do you really want to publish this article ?');"><i class="fa fa-list"></i> Unpublish </button>
                                                    </form>
                                                <?php
                                                }
                                                ?>
                                                <form style="margin-top:3px;" action="processGallery.php" method="post" accept-charset="utf-8">
                                                    <input type="hidden" name="action" value="verify">
                                                    <input type="hidden" name="id" value="<?php echo $gallery->id; ?>">

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
    <?php require_once '../partials/_footer.php'; ?>
</div>
<!-- ./wrapper -->
<?php require_once '../partials/_scripts.php'; ?>
</body>

</html>
