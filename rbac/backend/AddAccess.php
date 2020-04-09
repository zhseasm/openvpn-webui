<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>创建访问资源</title>
</head>
<body>
    <div>
        <table>
            <form action="" method="post">
            <caption>资源信息</caption>
                <tr>
                    <td>资源id:</td>
                    <td><input type="text" name="access_id" style="width:400px"></td>
                </tr>
            <tr>
                <td>资源名:</td>
                <td><input type="text" name="title" style="width:400px"></td>
            </tr>
            <tr>
                <td>URLs:</td>
                <td>
                    <textarea style="margin-top:20px;width:400px;height:100px" name="urls"
                                          placeholder="示例：rbac/frontend/pageone.php"
                    ></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="addaccess" value="添加">
                    <input type="button" value="返回首页" onclick="location.href='./index.php'">
                </td>
            </tr>
            </form>
        </table>
    </div>
</body>
</html>
 
 
<?php
 
    if( isset($_POST['addaccess']) ){
        $access_id=$_POST['access_id'];
        $title = $_POST['title'];
        $urls = json_encode( explode(",",$_POST['urls']) );
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=rbac","root","toor");
        $stmt = $pdo->prepare("insert into access (access_id,title,urls) values ( :access_id,:title, :urls )");
        $stmt->execute(array(":access_id"=>$access_id,":title"=>$title,":urls"=>$urls));
    }
 ?>