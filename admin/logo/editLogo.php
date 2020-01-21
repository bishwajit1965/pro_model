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
                Edit header
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
                    <a href="logoIndex.php" class="btn btn-sm btn-primary"><i class="fa fa-list"></i> Logo Index</a>
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
                    use CodeCourse\Repositories\Logo as Logo;

                    $logo = new Logo();

                    // Will display validation message if any
                    Session::init();
                    $message = Session::get('message');
                    if (!empty($message)) {
                        echo $message;
                        Session::set('message', null);
                    }
                    ?>
                    <?php
                    $id = $_GET['edit_id'];
                    $table = 'tbl_logo';
                    // Where condition in fetching data
                    $whereCond = [
                        'where' => ['id' => $id],
                        'return_type' => 'single',
                    ];
                    $getLogoData = $logo->select($table, $whereCond);
                    if (!empty($getLogoData)) { ?>
                        <form action="processLogo.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="title">Description</label>
                                        <input type="text" name="description" class="form-control" value="<?php echo isset($getLogoData->description) ? $getLogoData->description : ''; ?>" placeholder="Title data">
                                    </div>
                                    <div class="form-group">
                                        <label for="photo"> Choose new Logo</label>
                                        <input type="file" name="photo" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="photo">Existing Logo</label>
                                        <?php if (!empty($getLogoData->photo)) : ?>
                                            <img src="<?php echo isset($getLogoData->photo) ? $getLogoData->photo : ''; ?>" style="width:100%;height:183px;" class="img-thumbnail" alt="Logo background">
                                        <?php else : ?>
                                            <img src="../images/avatar/avatar.jpg" style="width:100%;height:183px;" class="img-rounded img-thumbnail" alt="Avatar">
                                        <?php endif ?>
                                    </div>
                                    <input type="hidden" name="id" value="<?php echo isset($getLogoData->id) ? $getLogoData->id : ''; ?>">
                                </div>
                            </div>
                            <input type="hidden" name="action" value="verify">
                            <button type="submit" name="submit" value="update" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit Logo</button>
                        </form>
                    <?php } ?>

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