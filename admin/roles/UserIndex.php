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
                Role index
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
                    <a href="createRole.php" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Create Role</a>
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
                    use CodeCourse\Repositories\Role as Role;
                    use CodeCourse\Repositories\Helpers as Helpers;
                    use CodeCourse\Repositories\UserRole as UserRole;
                    use CodeCourse\Repositories\UserAssignedRoles as UserAssignedRoles;

                    $role = new Role;
                    $helpers = new Helpers;
                    $userRole = new UserRole;
                    $userAssignedRole = new UserAssignedRoles;

                    Session::init();
                    $message = Session::get('message');
                    if (!empty($message)) {
                        echo $message;
                        Session::set('message', null);
                    }
                    ?>
                        <table id="example1" class="table table-bordered table-striped">
                    <div class="table-responsive">
                            <thead>
                                <tr>
                                    <th width="3%">Id</th>
                                    <th width="8%">Name</th>
                                    <th width="10%">Email</th>
                                    <th width="8%">User role</th>
                                    <th width="10%">User status</th>
                                    <th width="18%">Created</th>
                                    <th width="18%">Updated</th>
                                    <th width="24%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Table to be operated upon
                                $table = 'tbl_users';
                                $tableRoles = 'tbl_roles';
                                $tableUserRole = 'tbl_user_role';
                                // Order by condition
                                $order_by = ['order_by' => 'userID DESC'];
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

                                // Data fetched from different tables
                                $userRoleData = $userRole->select($table, $order_by);
                                $rolesData = $role->select($tableRoles);
                                $assignedRoles = $userAssignedRole->select($tableUserRole);
                                if (!empty($userRoleData)) {
                                    $i = 1;
                                    foreach ($userRoleData as $user) { ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $user->firstName.$user->lastName; ?></td>
                                            <td><?php echo $user->userEmail; ?></td>
                                            <td>
                                            <?php
                                            foreach ($rolesData as $role) {
                                                foreach ($assignedRoles as $assigned) {
                                                    if ($user->userID == $assigned->userID && $role->role_id == $assigned->role_id) {
                                                        echo $role->role_name. ','.'<br>';
                                                    }
                                                }
                                            }
                                            ?>
                                            </td>
                                            <td>
                                            <?php
                                            if ($user->userStatus == 'Y') {
                                                echo 'Active';
                                            } else {
                                                if ($user->userStatus == 'N') {
                                                    echo 'Inactive';
                                                }
                                            }
                                            ?>
                                            </td>
                                            <td><?= $helpers->dateFormat($user->created_at); ?></td>
                                            <td><?= $helpers->dateFormat($user->updated_at); ?></td>
                                            <td>
                                                <?php 
                                                if ( $_SESSION['userSession'] == 1) {
                                                    ?>
                                                    <div class="d-inline">
                                                    <a href="editAssignedRoles.php?edit_id=<?php echo $user->userID; ?>" class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Edit</a>

                                                    <a class="btn btn-xs btn-primary"
                                                    href="assignRole.php?edit_id=<?php echo $user->userID; ?>"
                                                    onClick="return confirm('Do you really want to assign role to this user ? Then click OK !!!');"> <i class="fa fa-user"></i> Assign Role</a>

                                                    <form style="display:inline;" action="processAssignRole.php" method="post" accept-charset="utf-8">
                                                        <input type="hidden" name="action" value="verify">
                                                        <input type="hidden" name="userID" value="<?php echo $user->userID; ?>">

                                                        <button type="submit" name="submit" value="delete" class="btn btn-xs btn-danger" onClick="return confirm('Do you really want to delete this data ?');"><i class="fa fa-trash"></i> Delete</button>
                                                        
                                                    </div>

                                                    <?php  
                                                }
                                                ?>
                                                </form>
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
                                    <th>User role</th>
                                    <th>User status</th>
                                    <th>Created</th>
                                    <th>Updated</th>
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
