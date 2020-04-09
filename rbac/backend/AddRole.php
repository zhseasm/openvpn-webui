<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>创建角色</title>
</head>
<body>
    <div id="container">
        <table>
            <form action="" method="post">
            <caption>角色信息</caption>
            <tr>
                <td>id:</td>
                <td><input type="text" name="role_id" style="width:300px"></td>
            </tr>
                <td>角色名:</td>
                <td><input type="text" name="role_name" style="width:300px"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="addrole" value="添加">
                    <input type="button" value="返回首页" onclick="location.href='./index.php'">
                </td>
            </tr>
            </form>
        </table>
    </div>
</body>
</html>
 
 
<?php
    if( isset($_POST['addrole']) ){
        $role_id = $_POST['role_id'];
        $role_name = $_POST['role_name'];
        echo $role_name;
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=rbac","root","toor");
        $stmt = $pdo->prepare("insert into role (role_id,role_name) values ( :role_id,:role_name )");
        $stmt->execute(array(":role_id"=>$role_id,":role_name"=>$role_name));
    }
 ?>