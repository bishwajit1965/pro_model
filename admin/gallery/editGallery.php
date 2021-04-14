<?php require_once('../partials/_head.php'); ?>
<!-- Site wrapper -->
<div class="wrapper">
    <?php require_once('../partials/_header.php'); ?>
    <!-- =============================================== -->
    <!-- Left side column. contains the sidebar -->
    <?php require_once '../partials/_leftSidebar.php'; ?>
    <!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Edit photo in gallery
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
                    // Will load vendor autoLoader
                    require_once '../app/start.php';

                    use CodeCourse\Repositories\Session as Session;
                    use CodeCourse\Repositories\Gallery as Gallery;
                    use CodeCourse\Repositories\Helpers as Helpers;

                    // Instantiate Category
                    $gallery = new Gallery;
                    $helpers = new Helpers;

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
                    $table = 'tbl_gallery';
                     
                    // Where condition in fetching data
                    $whereCond = [
                        'where' => ['id' => $id],
                        'return_type' => 'single',
                    ];
                    $getGalleryData = $gallery->select($table, $whereCond);
                    if (!empty($getGalleryData)) { ?>
                    <form action="processGallery.php" method="post" enctype="multipart/form-data"
                        accept-charset="utf-8">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="title">Photo title</label>
                                    <input type="text" name="title" class="form-control"
                                        value="<?= $getGalleryData->title; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="title">Photo will publish on : </label>
                                    <?php echo isset($getGalleryData->published_on) ? $helpers->dateFormat($getGalleryData->published_on) : ''; ?>
                                    <input type="datetime-local" name="published_on" class="form-control"
                                        value="<?= isset($getGalleryData->published_on) ? $getGalleryData->published_on : ''; ?>">
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="status">Photo status</label>
                                            <div class="selection">
                                                <select name="status" class="form-control">
                                                    <?php
                                                        if ($getGalleryData->status == '0') { ?>
                                                    <option value="0">Published</option>
                                                    <option value="1">Coming soon</option>
                                                    <option value="2">Draft</option>
                                                    <option value="3">Unpublish</option>
                                                    <?php
                                                        } elseif ($getGalleryData->status == '1') { ?>
                                                    <option value="1">Coming soon</option>
                                                    <option value="0">Publish</option>
                                                    <option value="2">Draft</option>
                                                    <option value="3">Unpublish</option>
                                                    <?php
                                                        } elseif ($getGalleryData->status == '2') { ?>
                                                    <option value="2">Draft</option>
                                                    <option value="0">Publish</option>
                                                    <option value="1">Coming soon</option>
                                                    <option value="3">Unpublish</option>
                                                    <?php
                                                        } elseif ($getGalleryData->status == '3') { ?>
                                                    <option value="3">Unpublished</option>
                                                    <option value="2">Draft</option>
                                                    <option value="0">Publish</option>
                                                    <option value="1">Coming soon</option>
                                                    <?php
                                                        } else {
                                                        }
                                                        ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="photo">Choose new photo</label>
                                            <input type="file" name="photo" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?php
                                        if (!empty($getGalleryData->photo)) { ?>
                                    <img src="<?= $getGalleryData->photo; ?>"
                                        style="width:100%;height:187px;margin-top:20px;"
                                        class="img img-responsive img-thumbnail" alt="Article photo">
                                    <?php } else { ?>
                                    <img src="../images/avatar/avatar.jpg" style="width:100%;"
                                        class="img img-responsive img-thumbnail" alt="">
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo description</label>
                            <textarea id="editor1" name="description" rows="10" cols="80">
                                    <?= htmlspecialchars_decode($getGalleryData->description); ?>
                                </textarea>
                        </div>

                        <input type="hidden" name="user_session" value="<?php echo $user_session; ?>">
                        <input type="hidden" name="action" value="verify">
                        <input type="hidden" name="id" value="<?php echo $getGalleryData->id; ?>">
                        <button type="submit" name="submit" value="update" class="btn btn-sm btn-primary">
                            <i class="fa fa-edit"></i> Update Photo in Gallery</button>
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