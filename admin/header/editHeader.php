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
                    <a href="headerIndex.php" class="btn btn-sm btn-primary"><i class="fa fa-list"></i> Header Index</a>
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
                    require_once('../app/start.php');

                    use Codecourse\Repositories\Session as Session;
                    use Codecourse\Repositories\Header as Header;

                    $header = new Header();

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
                    $table = 'tbl_header';
                    // Where condition in fetching data
                    $whereCond = [
                        'where' => ['id' => $id],
                        'return_type' => 'single',
                    ];
                    $getHeaderData = $header->select($table, $whereCond);
                    if (!empty($getHeaderData)) { ?>
                        <form action="processHeader.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" class="form-control" value="<?= isset($getHeaderData->title) ? $getHeaderData->title : ''; ?>" placeholder="Title data">
                                    </div>
                                    <div class="form-group">
                                        <label for="slogan">Slogan</label>
                                        <input type="text" name="slogan" class="form-control" value="<?= isset($getHeaderData->slogan) ? $getHeaderData->slogan : ''; ?>" placeholder="Site slogan">
                                    </div>
                                    <div class="form-group">
                                        <label for="photo">Site created at</label>
                                        <input type="datetime-local" name="created_at" class="form-control" value="">
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" class="form-control" value="<?= isset($getHeaderData->email) ? $getHeaderData->email : ''; ?>" placeholder="Email address">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="phone"> Phone/Cell phone</label>
                                                <input type="text" name="phone" class="form-control" value="<?= isset($getHeaderData->phone) ? $getHeaderData->phone : ''; ?>" placeholder="Site phone">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="photo">Existing header background</label>
                                        <?php if (!empty($getHeaderData->photo)) : ?>
                                            <img src="<?= isset($getHeaderData->photo) ? $getHeaderData->photo : ''; ?>" style="width:100%;height:183px;" class="img-thumbnail" alt="Header background">
                                        <?php else : ?>
                                            <img src="../images/avatar/avatar.jpg" style="width:100%;height:183px;" class="img-rounded img-thumbnail" alt="Avatar">
                                        <?php endif ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="photo"> Choose new header background</label>
                                        <input type="file" name="photo" class="form-control">
                                    </div>
                                    <input type="hidden" name="id" value="<?= isset($getHeaderData->id) ? $getHeaderData->id : ''; ?>">
                                </div>
                            </div>
                            <input type="hidden" name="action" value="verify">
                            <button type="submit" name="submit" value="update" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit Header</button>
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
    <?php include_once('../partials/_footer.php'); ?>
</div>
<!-- ./wrapper -->
<?php include_once('../partials/_scripts.php'); ?>
</body>

</html>
