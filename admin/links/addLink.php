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
                Add Link Data
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
                    <a href="linkIndex.php" class="btn btn-sm btn-primary"><i class="fa fa-list"></i> Link Index</a>
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
                    <div class="col-sm-6 col-sm-offset-3">
                        <?php
                        // Will load vendor autoloader
                        require_once '../app/start.php';

                        use CodeCourse\Repositories\Session as Session;
                        use CodeCourse\Repositories\Link as Link;

                        // Instantiate Category
                        $link = new Link();

                        // Will display validation message if any
                        Session::init();
                        $message = Session::get('message');
                        if (!empty($message)) {
                            echo $message;
                            Session::set('message', null);
                        }
                        ?>
                        <form action="processLink.php" method="post" accept-charset="utf-8">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control" value="" placeholder="Title">
                            </div>
                            <div class="form-group">
                                <label for="title">Email</label>
                                <input type="email" name="email" class="form-control" value="" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="title">Phone</label>
                                <input type="text" name="phone" class="form-control" value="" placeholder="Phone">
                            </div>
                            <div class="form-group">
                                <label for="title">Url</label>
                                <input type="text" name="url" class="form-control" value="" placeholder="Url">
                            </div>
                            <div class="form-group">
                                <label for="title">Address</label>
                                <input type="text" name="address" class="form-control" value="" placeholder="Address">
                            </div>
                            <div class="form-group">
                                <label for="title">Zipcode</label>
                                <input type="text" name="zipcode" class="form-control" value="" placeholder="Zipcode">
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" name="country" class="form-control" value="" placeholder="Country">
                            </div>

                            <input type="hidden" name="action" value="verify">
                            <button type="submit" name="submit" value="insert" class="btn btn-sm btn-primary"><i class="fa fa-upload"></i> Add Tag</button>
                        </form>
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