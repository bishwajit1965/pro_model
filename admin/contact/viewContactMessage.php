<?php include_once('../partials/_head.php'); ?>
<!-- Site wrapper -->
<div class="wrapper">
    <?php include_once('../partials/_header.php'); ?>
    <!-- =============================================== -->
    <!-- Left side column. contains the sidebar -->
    <?php include_once('../partials/_leftSidebar.php'); ?>
    <!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                View Message
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
                    <a href="contactIndex.php" class="btn btn-sm btn-primary"><i class="fa fa-backward"></i> Go back to Message Index</a>
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
                        require_once('../app/start.php');

                        use CodeCourse\Repositories\Session as Session;
                        use CodeCourse\Repositories\Contact as Contact;
                        use CodeCourse\Repositories\Helpers as Helpers;
                        // Will display validation message if any
                        $contact = new Contact;
                        $helpers = new Helpers;
                        Session::init();
                        $message = Session::get('message');
                        if (!empty($message)) {
                            echo $message;
                            Session::set('message', null);
                        }
                        ?>
                        <?php
                        $id = $_GET['id'];
                        $table = 'tbl_contact';
                        $whereCond = [
                            'where' => ['id' => $id],
                            'return_type' => 'single',
                        ];
                        $getcontactData = $contact->select($table, $whereCond);
                        if (!empty($getcontactData)) { ?>
                             <form action="processContact.php" method="post" accept-charset="utf-8">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Message sender</label>
                                            <input type="text" class="form-control" name="" value="<?php echo $getcontactData->first_name.' '. $getcontactData->last_name;?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Sender's Email</label>
                                            <input type="text" class="form-control" name="" value="<?php echo $getcontactData->email;?>">
                                        </div>
                                    </div> 
                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Sender's Phone</label>
                                            <input type="text" class="form-control" name="" value="<?php echo $getcontactData->phone;?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Sender's Address</label>
                                            <input type="text" class="form-control" name="" value="<?php echo $getcontactData->address;?>">
                                        </div>
                                    </div>    
                                </div>
                                 
                                <div class="form-group">
                                    <label for="">Message status</label>
                                    <input type="text" name="" class="form-control" value="<?php  
                                    if($getcontactData->status == '0') {
                                        echo 'Unread contact message' ;
                                    } elseif ($getcontactData->status == '1'){
                                        echo 'Read contact message' ;
                                    }
                                    ?>">
                                </div>
                               
                                <div class="form-group">
                                    <label for="">Sender's Message</label>
                                    <textarea type="text" name="messag" cols="" rows="6" class="form-control" name="message"><?php echo htmlspecialchars_decode($getcontactData->message);?>    
                                    </textarea>
                                </div>

                                <input type="hidden" name="action" value="verify">
                                <input type="hidden" name="id" value="<?= $getcontactData->id;?>">
                                <input type="hidden" name="status" value="<?php echo '1';?>">

                                <button type="submit" name="submit" value="update" class="btn btn-md btn-primary" onClick="return confirm('Do you really want to publish this contact message ?');"><i class="fa fa-book"></i> Publish message for public view </button>
                                
                                <a href="contactIndex.php" class="btn btn-success btn-md"><i class="fa fa-backward"></i> Go back to Message Index</a>
                               
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
    <?php include_once('../partials/_footer.php'); ?>
</div>
<!-- ./wrapper -->
<?php include_once('../partials/_scripts.php'); ?>
</body>

</html>
