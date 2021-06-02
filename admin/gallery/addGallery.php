<?php require_once '../partials/_head.php' ; ?>
<!-- Site wrapper -->
<div class="wrapper">
    <?php require_once '../partials/_header.php' ; ?>
    <!-- =============================================== -->
    <!-- Left side column. contains the sidebar -->
    <?php require_once '../partials/_leftSidebar.php'; ?>
    <!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Add photo to gallery
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
                    <a href="galleryIndex.php" class="btn btn-sm btn-primary"><i class="fa fa-list"></i> Photo Gallery
                        Index</a>
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
                    // Will load vendor autoload
                    require_once '../app/start.php';

                    use CodeCourse\Repositories\Session as Session;
                    use CodeCourse\Repositories\Gallery as Gallery;

                    // Instantiate classes
                    $gallery = new Gallery();
                    // Tables will be dealt with
                    $tableCategory = 'tbl_gallery';
                    // User specific session
                    $user_session = session_id();

                    // Will display validation message if any
                    Session::init();
                    $message = Session::get('message');
                    if (!empty($message)) {
                        echo $message;
                        Session::set('message', null);
                    }
                    ?>
                    <form action="processGallery.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title">Photo Title</label>
                                    <input type="text" name="title" class="form-control" value="" placeholder="Insert title">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title">Photo Status</label>
                                    <select name="status" class="form-control">
                                        <option>Select photo status</option>
                                        <option value="0">Publish</option>
                                        <option value="1">Coming soon</option>
                                        <option value="2" selected>Draft</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title">Photo </label>
                                    <input type="file" name="photo" class="form-control">
                                </div> 
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title">Photo Will publish on</label>
                                    <input type="datetime-local" name="published_on" class="form-control" value="">
                                </div>
                                <input type="hidden" name="user_session" value="<?= $user_session; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title">Photo Description</label>
                            <textarea id="editor1" name="description" rows="5" cols=""></textarea>
                        </div>
                        <input type="hidden" name="action" value="verify">
                        <button type="submit" name="submit" value="insert" class="btn btn-sm btn-primary"><i class="fa fa-upload"></i> Add Photo to Gallery</button>
                    </form>
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
    <?php require_once '../partials/_footer.php' ; ?>
</div>
<!-- ./wrapper -->
<?php require_once '../partials/_scripts.php' ; ?>
</body>

</html>
