<?php include './header.php';
include './checkPermission.php';
?>
    <div class="container-sm">
    <div class="jumbotron jumbotron-sm " style="font-size:12px;">
        <div class="container-sm text-monospace">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card ">
                        <div class="card-body text-center">

<p>
    <a href="./UserList.php" class="btn btn-sm btn-info">用户列表</a>


    <a href="./RoleList.php" class="btn btn-sm btn-info">角色管理</a>


    <a href="./AccessList.php" class="btn btn-sm btn-info">权限管理</a>
</p>


    <p>
        <a href="./rbacAddUser.php" class="btn btn-sm btn-info">添加用户</a>
        <a href="./AddRole.php" class="btn btn-sm btn-info">添加角色</a>
        <a href="./AddAccess.php" class="btn btn-sm btn-info">增加资源</a>

    </p>



</div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './footer.php';?>