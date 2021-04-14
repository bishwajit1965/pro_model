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
                Contact Message Index
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
                    <a href="messageArchive.php" class="btn btn-sm btn-primary"><i class="fa fa-list"></i> Message Archive</a>
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
                    // Will load vendor auto loader
                    require_once '../app/start.php';

                    use CodeCourse\Repositories\Session as Session;
                    use CodeCourse\Repositories\Contact as Contact;
                    use CodeCourse\Repositories\Helpers as Helpers;

                    $contact = new Contact;
                    $helpers = new Helpers;

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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Message</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Table to be operated upon
                                $tableContact = 'tbl_contact';
                                // WhereCondition and order_by condition in fetching data
                                $whereCond = ['where' => ['status' => '0'],
                                'order_by' => 'id DESC'
                                ];
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

                                // Data fetched contact tables
                                $contactData = $contact->select($tableContact , $whereCond);
                                if (!empty($contactData)) {
                                    $i = 1;
                                    foreach ($contactData as $userContact) { ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $userContact->first_name .' '.$userContact->last_name; ?></td>
                                            <td><?php echo $userContact->email; ?></td>
                                            
                                            <td><?php echo $userContact->phone; ?></td>
                                            <td><?php echo htmlspecialchars_decode($helpers->textShorten($userContact->message, 60)); ?></td>
                                            <td><?php echo $userContact->address; ?></td>
                                            <td><?php if ($userContact->status == '0') {
                                                echo 'Unread';
                                            } ?></td>
                                            <td><?= $helpers->dateFormat($userContact->created_at); ?></td>
                                            
                                            <td style="display: block;">
                                                <?php 
                                                if ( $_SESSION['userSession'] == 1) {
                                                    ?>

                                                <a class="btn btn-xs btn-primary btn-block"
                                                href="viewContactMessage.php?id=<?php echo $userContact->id; ?>"
                                                onClick="return confirm('Do you really want to read this message ? Then click OK !!!');"> <i class="fa fa-book"></i> Read Msg</a>

                                                <form action="processContact.php" method="post" accept-charset="utf-8">
                                                    <input type="hidden" name="action" value="verify">
                                                    <input type="hidden" name="id" value="<?= $userContact->id;?>">
                                                    <input type="hidden" name="status" value="<?php echo '1';?>">

                                                    <button type="submit" name="submit" value="update" class="btn btn-xs btn-success btn-block" onClick="return confirm('Do you really want to publish this message in public ? Then click OK !!!');"><i class="fa fa-list"></i> Publish Msg</button>
                                                </form>
                                                <form action="processContact.php" method="post" accept-charset="utf-8">
                                                    <input type="hidden" name="action" value="verify">
                                                    <input type="hidden" name="id" value="<?= $userContact->id;?>">
                                                    <input type="hidden" name="status" value="<?php echo '2';?>">

                                                    <button type="submit" name="submit" value="update" class="btn btn-xs btn-primary btn-block" onClick="return confirm('Do you really want to delete this data ?');"><i class="fa fa-book"></i> Archive Msg</button>
                                                </form>

                                                <form style="display:inline;" action="processContact.php" method="post" accept-charset="utf-8">
                                                    <input type="hidden" name="action" value="verify">
                                                    <input type="hidden" name="id" value="<?php echo $userContact->id; ?>">

                                                    <button type="submit" name="submit" value="delete" class="btn btn-xs btn-danger btn-block" onClick="return confirm('Do you really want to delete this data ?');"><i class="fa fa-trash"></i> Delete Msg</button>

                                                    <?php  
                                                }
                                                ?>
                                                </form>
                                                <style>
                                                    .btn {margin-bottom: 2px;}
                                                </style>
                                            </td>
                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Message</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="" style="background-color: #555;height:40px;padding-left:20px;text-align: center;font-weight: 900;color:#FFF;"><h2>Viewed Contact Messages</h2></div>

                    <div class="table-responsive">
                        <table id="example2" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                     
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Message</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Table to be operated upon
                                $tableContact = 'tbl_contact';
                                // WhereCondition and order_by condition in fetching data
                                $whereCondition = ['where' => ['status' => '1'],
                                'order_by' => 'id DESC'
                                ];
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

                                // Data fetched from contact tables
                                $dataContact = $contact->select($tableContact, $whereCondition);
                                if (!empty($dataContact)) {
                                    $i = 1;
                                    foreach ($dataContact as $userContact) { ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $userContact->first_name .' '.$userContact->last_name; ?></td>
                                            <td><?php echo $userContact->email; ?></td>
                                            
                                            <td><?php echo $userContact->phone; ?></td>
                                            <td><?php echo htmlspecialchars_decode($helpers->textShorten($userContact->message, 60)); ?></td>
                                            <td><?php echo $userContact->address; ?></td>
                                            <td><?php if ($userContact->status == '1') {
                                                echo 'Read';
                                            } ?></td>
                                            <td><?= $helpers->dateFormat($userContact->created_at); ?></td>
                                            
                                            <td>
                                                <?php 
                                                if ( $_SESSION['userSession'] == 1) {
                                                ?>
                                                    <a class="btn btn-xs btn-primary btn-block"
                                                    href="viewContactMessage.php?id=<?php echo $userContact->id; ?>"
                                                    onClick="return confirm('Do you really want to read this message ? Then click OK !!!');"> <i class="fa fa-book"></i> Read Msg</a>

                                                    <form action="processContact.php" method="post" accept-charset="utf-8">
                                                        <input type="hidden" name="action" value="verify">
                                                        <input type="hidden" name="id" value="<?= $userContact->id;?>">
                                                        <input type="hidden" name="status" value="<?php echo '2';?>">

                                                        <button type="submit" name="submit" value="update" class="btn btn-xs btn-primary btn-block" onClick="return confirm('Do you really want to delete this data ?');"><i class="fa fa-book"></i> Archive Msg</button>
                                                    </form>

                                                    <form style="display:inline;" action="processAssignRole.php" method="post" accept-charset="utf-8">
                                                        <input type="hidden" name="action" value="verify">
                                                        <input type="hidden" name="id" value="<?php echo $userContact->id; ?>">

                                                    <button type="submit" name="submit" value="delete" class="btn btn-xs btn-danger btn-block" onClick="return confirm('Do you really want to delete this data ?');"><i class="fa fa-trash"></i> Delete Msg</button>

                                                <?php  
                                                }
                                                ?>
                                                </form>
                                                <style>
                                                    .btn {margin-bottom: 2px;}
                                                </style>
                                            </td>
                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Message</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Created</th>
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
    <?php include_once('../partials/_footer.php'); ?>
</div>
<!-- ./wrapper -->
<?php include_once('../partials/_scripts.php'); ?>
</body>

</html>
