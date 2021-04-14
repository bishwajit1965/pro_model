<?php require_once '../partials/_head.php' ; ?>
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
                Assign user roles
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
                    <a href="userIndex.php" class="btn btn-sm btn-primary"><i class="fa fa-fast-backward"></i> User
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
                    // Will load vendor auto loader
                    require_once '../app/start.php';

                    use CodeCourse\Repositories\Session as Session;
                    use CodeCourse\Repositories\Role as Role;
                    use CodeCourse\Repositories\Helpers as Helpers;
                    use CodeCourse\Repositories\UserRole as UserRole;
                    use CodeCourse\Repositories\UserAssignedRoles as UserAssignedRoles;
                    use CodeCourse\Repositories\Admins as Admins;

                    $admins = new Admins;
                    $role = new Role;
                    $helpers = new Helpers;
                    $userRole = new UserRole;
                    $userAssignedRoles = new UserAssignedRoles;

                    Session::init();
                    $message = Session::get('message');
                    if (!empty($message)) {
                        echo $message;
                        Session::set('message', null);
                    }
                    // Tables to be operated upon
                    $table = 'tbl_roles';
                    $tableUsers = 'tbl_users';
                    $tableUserRole = 'tbl_user_role';
                    $order_by = ['order_by' => 'role_id ASC'];
                    // Edit id for specific user
                    if (isset($_GET['edit_id'])) {
                        $id = $_GET['edit_id'];
                    }
                    // Conditional fetching of data
                    $whereCond = [
                        'where' => ['userID' => $id],
                        'return_type' => 'single',
                    ];
                    // Fetching data
                    $getRoleData = $userRole->select($tableUsers, $whereCond);
                    $user = $getRoleData->userID;
                    $adminData = $admins->select($tableUsers, $whereCond);
                    $userID = $adminData->userID;
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
                    ?>
                    <form class="form" action="processAssignRole.php" method="post">
                        <?php
                        if (isset($_GET['edit_id'])) {
                            ?>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="userEmail">User Id</label>
                                    <input type="text" disabled class="form-control form-control-sm"
                                        value="<?php echo $getRoleData->userID ; ?>">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="userName">User Name</label>
                                    <input type="text" class="form-control form-control-sm"
                                        value="<?php echo $getRoleData->firstName . ' ' .$getRoleData->lastName ; ?>">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="userEmail">User Email</label>
                                    <input type="text" class="form-control form-control-sm"
                                        value="<?php echo $getRoleData->userEmail ; ?>">
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                        <div class="row">
                            <?php
                            $roleData = $role->select($table, $order_by);
                            if (!empty($roleData)) {
                                foreach ($roleData as $role) { ?>
                                    <div style="font-size: 16px;display:inline;margin-left:18px;">
                                        <input type="checkbox" id="" name="role_id" value="<?php echo $role->role_id;?>" <?php
                                        $roleData = $userAssignedRoles->select($tableUserRole);
                                        foreach ($roleData as $userRoleData) {
                                            if ($user == $userRoleData->userID && $role->role_id == $userRoleData->role_id) {
                                                echo 'checked';
                                            }
                                        }
                                        ?>>
                                        <label for="userRole"> <?php echo $role->role_name;?></label>
                                    </div>
                            <?php }
                            } ?>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="action" value="verify">
                            <input type="hidden" name="userID" class="form-control" value="<?php echo $userID ; ?>">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="submit" value="assign-user-role"
                                class="btn btn-sm btn-primary"><i class="fa fa-user"></i> Assign User Role </button>
                        </div>
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