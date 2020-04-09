<?php
    if( isset($_GET['user_id']) ){
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=rbac","root","toor");

        //查询用户信息
        $stmt = $pdo->prepare("select * from user where user_id = :user_id");
        $stmt->execute(array("user_id" => $_GET['user_id']));
        $user_info = $stmt->fetch(PDO::FETCH_ASSOC);
        //print_r($user_info);
 
        //查询用户的角色
        $stmt = $pdo->prepare("select * from user_role where user_id = :user_id");
        $stmt->execute(array(":user_id" => $_GET['user_id']));
        //这里只留下role_id
        $user_role_info = array_column( $stmt->fetchAll(PDO::FETCH_ASSOC),"role_id" );
        //print_r($user_role_info);
 
        //查询所有角色
        $stmt = $pdo->prepare("select * from role");
        $stmt->execute();
        $role_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

                    <input type="hidden" name="user_id" value="<?php echo $user_info['user_id'] ?>">
                    <?php echo $user_info['user_name']; ?>

                 

                <?php if( count($role_arr) ):?>
                    <?php foreach($role_arr as $role): ?>

            <input type="checkbox" class="mgc mgc-info" <?php checked($role['role_id'],$user_role_info);?> name="role[]" value="<?php echo $role['role_id'];?>"><?php echo $role['role_name'] ?>

                    <?php endforeach; ?>
                <?php endif; ?>
        <br/>
        <br/>
                    <input type="submit" name="editUser" class="btn btn-sm btn-info">
        <input type="button" value="返回" class="btn btn-sm btn-info" onclick="window.history.back();">
        <input type="button" value="返回主页" class="btn btn-sm btn-info" onclick="location.href='rbacindex.php'">
                    <input type="button" value="返回用户列表" class="btn btn-sm btn-info" onclick="location.href='./UserList.php'">

    </form>  
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>

 
 
<?php
    if( isset($_POST['editUser'])){
        //获取传递的role复选框数组，当将全部角色都撤销时，传递的post数据中将不再有role，所以将其设为空数组。
        $edit_role = isset($_POST['role'])?$_POST['role']:array();
        $user_id = $_POST['user_id'];
 
        //增加的角色：
        $add_role = array_diff($edit_role,$user_role_info);
 
        //删除的角色
        $sub_role = array_diff($user_role_info,$edit_role);
 
        //执行删除角色
        $stmt = $pdo->prepare("delete from user_role where user_id = :user_id and role_id = :role_id");
        foreach($sub_role as $role_id){    
            $stmt->execute(array(":user_id"=>$user_id,":role_id"=>$role_id)); 
        }
 
        //执行增加角色
        $stmt = $pdo->prepare("insert into user_role (user_id,role_id) values(:user_id,:role_id)");
        foreach($add_role as $role_id){
            $stmt->execute(array(":user_id"=>$user_id,":role_id"=>$role_id));
        }
 
        // echo "<script>location.href='editUser.php?user_id=$user_id</script>";
        echo "<script>location.replace(location.href);</script>";
    }
    include './footer.php';
 ?>