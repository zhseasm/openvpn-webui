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

              <input type="text" name="user_id" class="form-control" placeholder="用户ID">
<br />
             <input type="text" name="user_name" class="form-control" placeholder="用户名">
                <br />
                <input type="text" name="passwd" class="form-control" placeholder="密码:大于四位数">
            <br />

                   <span>
                       <input type="submit" name="adduser" value="添加" class="btn btn-sm btn-info">
                   </span>
                <span>
                    <input type="button" value="返回首页" onclick="location.href='rbacindex.php'" class="btn btn-sm btn-info">
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
    if( isset($_POST['adduser']) ){
        $user_id = $_POST['user_id'];
        $user_name = $_POST['user_name'];
        $passwd = $_POST['passwd'];
     /*   var_dump($user_id);
        var_dump($user_name);
        var_dump($passwd);*/
        //exit;
     /*   $pdo = new PDO("mysql:host=127.0.0.1;dbname=rbac","root","toor");
        //$stmt = $pdo->prepare("insert into user (user_id,user_name) values ( :user_id, :user_name )");
       // $stmt->execute(array(":user_id"=>$user_id,":user_name"=>$user_name));
        $stmt = $pdo->prepare("insert into user (user_id,user_name,password) values ( :user_id, :user_name ,password(:passwd))");
        $stmt->execute(array(":user_id"=>$user_id,":user_name"=>$user_name,":passwd"=>$passwd));
   var_dump($stmt);*/
        $mysqli = new mysqli("localhost", "root", "toor", "rbac");
        $sql="insert into user(user_id,user_name,passwd)value ('{$user_id}','{$user_name}',password('{$passwd}'))";
        $flag=$mysqli->query($sql);
       /* if ($mysqli->connect_error) {
            die("连接失败: " . $mysqli->connect_error);
        }
        var_dump($flag);*/
    }
    include './footer.php';
?>