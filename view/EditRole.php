<?php
    if( isset($_GET['role_id']) ){
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=rbac","root","toor");
 
        //查询角色信息
        $stmt = $pdo->prepare("select * from role where role_id = :role_id");
        $stmt->execute(array("role_id" => $_GET['role_id']));
        $role_info = $stmt->fetch(PDO::FETCH_ASSOC);
        //print_r($user_info);
 
        //查询当前角色拥有的权限
        $stmt = $pdo->prepare("select * from role_access where role_id = :role_id");
        $stmt->execute(array(":role_id" => $_GET['role_id']));
        //这里只留下access_id
        $role_access_info = array_column( $stmt->fetchAll(PDO::FETCH_ASSOC),"access_id" );
        //print_r($user_role_info);
 
        //查询所有的资源信息
        $stmt = $pdo->prepare("select * from access");
        $stmt->execute();
        $access_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //print_r($role_arr);
    }
 
    //用来判断复选框已选中
    function checked($i,$arr){
        if( in_array($i,$arr) ){
            echo "checked";
        }
    }
include './header.php';
    include './checkPermission.php';
 ?>

<div class="container-sm">
    <div class="jumbotron jumbotron-sm " style="font-size:12px;">
        <div class="container-sm text-monospace">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body text-center ">



    <form action="" method='post'>

                    <input type="hidden" name="role_id" value="<?php echo $role_info['role_id'] ?>">
                    <?php echo $role_info['role_name']; ?>

                 
           权限:
                <?php if( count($access_arr) ):?>

                    <?php foreach($access_arr as $access): ?>

            <input type="checkbox" class="mgc mgc-info" <?php checked($access['access_id'],$role_access_info);?> name="access[]" value="<?php echo $access['access_id']?>"><?php echo $access['title'] ?>

                    <?php endforeach; ?>

                <?php endif; ?>
<br/>
        <br/>
                    <input type="submit" name="editRole" class="btn btn-sm btn-info">
                    <input type="button" value="返回主页" class="btn btn-sm btn-info" onclick="location.href='rbacindex.php'">
                    <input type="button" value="返回角色列表" class="btn btn-sm btn-info" onclick="location.href='./RoleList.php'">

    </form>  

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

 
<?php
include './footer.php';
    if( isset($_POST['editRole'])){
        //获取传递的role复选框数组，当将全部角色都撤销时，传递的post数据中将不再有role，所以将其设为空数组。
        $access = isset($_POST['access'])?$_POST['access']:array();
        $role_id = $_POST['role_id'];
       /* print_r($role_id);exit;*/
 
        //增加的角色：
        $add_access = array_diff($access,$role_access_info);

        //删除的角色
        $sub_access = array_diff($role_access_info,$access);

        //执行删除角色
        $stmt = $pdo->prepare("delete from role_access where role_id = :role_id and access_id = :access_id");
        foreach($sub_access as $access_id){    
            $stmt->execute(array(":role_id"=>$role_id,":access_id"=>$access_id ));

        }
 
        //执行增加角色
        $stmt = $pdo->prepare("insert into role_access (role_id,access_id) values(:role_id,:access_id)");
        foreach($add_access as $access_id){
            $stmt->execute(array(":role_id"=>$role_id,":access_id"=>$access_id ));
        }
 
        echo "<script>location.replace(location.href);</script>";
    }
 ?> 