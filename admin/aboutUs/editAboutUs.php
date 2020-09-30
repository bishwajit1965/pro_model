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
                Edit Category
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
                    <!-- <h3 class="box-title">Add category</h3> -->
                    <a href="aboutUsIndex.php" class="btn btn-sm btn-primary"><i class="fa fa-list"></i> About Us Index</a>
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
                    <div class="col-sm-10 col-sm-offset-1">
                        <?php
                        // Will load vendor auto loader
                        require_once '../app/start.php';

                        use CodeCourse\Repositories\Session as Session;
                        use CodeCourse\Repositories\AboutUs as AboutUs;

                        // Will display validation message if any
                        $aboutUs = new AboutUs;
                        Session::init();
                        $message = Session::get('message');
                        if (!empty($message)) {
                            echo $message;
                            Session::set('message', null);
                        }
                        // Will catch the id to edit data
                        $id = $_GET['edit_id'];
                        $table = 'tbl_about_us';
                        $whereCond = [
                            'where' => ['id' => $id],
                            'return_type' => 'single'
                        ];
                        $getAboutUsData = $aboutUs->select($table, $whereCond);
                        if (!empty($getAboutUsData)) { ?>
                            <form action="processAboutUs.php" method="post" accept-charset="utf-8">
                                <div class="form-group">
                                    <label for="about_us">About us</label>
                                    <textarea class="form-control" name="about_us" id="editor1" rows="3">
                                        <?php echo $getAboutUsData->about_us; ?>
                                    </textarea>
                                </div>

                                <input type="hidden" name="action" value="verify">

                                <input type="hidden" name="id" value="<?php echo $getAboutUsData->id ;?>">

                                <button type="submit" name="submit" value="update" class="btn btn-sm btn-primary"><i class="fa fa-upload"></i> Edit About Us</button>
                            </form>
                        <?php } ?>
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