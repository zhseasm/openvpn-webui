<?php include './header.php';
include './checkPermission.php';
?>



    <div class="container-sm">
        <div class="jumbotron jumbotron-sm " style="font-size:12px;">
            <div class="container-sm text-monospace">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body text-center">



        <table>
            <form action="" method="post">

            <input type="text" name="role_id" class="form-control" placeholder="角色ID">

<br />
               <input type="text" name="role_name" class="form-control" placeholder="角色名字">
                <br />
                <span>

      <input type="submit" name="addrole" value="添加" class="btn btn-sm btn-info">
</span>
                <span>
       <input type="button" value="返回首页" class="btn btn-sm btn-info" onclick="location.href='rbacindex.php'">

</span>




            </form>
        </table>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 
<?php
    if( isset($_POST['addrole']) ){
        $role_id = $_POST['role_id'];
        $role_name = $_POST['role_name'];
        echo $role_name;
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=rbac","root","toor");
        $stmt = $pdo->prepare("insert into role (role_id,role_name) values ( :role_id,:role_name )");
        $stmt->execute(array(":role_id"=>$role_id,":role_name"=>$role_name));
    }
    include './footer.php';
 ?>