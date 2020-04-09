<?php
if( isset($_GET['access_id']) ) {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=rbac", "root", "toor");

    //查询用户信息
    $stmt = $pdo->prepare("select * from access where access_id = :access_id");
    $stmt->execute(array("access_id" => $_GET['access_id']));
    $access = $stmt->fetch(PDO::FETCH_ASSOC);

}
function print_json($data){
    $arr = json_decode($data,true);
    foreach($arr as $v ){
        echo $v;
    }
}



    if( isset($_POST['addaccess']) ) {
        $access_id = $_POST['access_id'];
        $title = $_POST['title'];
        $urls=$_POST['urls'];
        $urls = json_encode(explode(",", $_POST['urls']));
        //echo $access_id;
        //echo $title;
        //echo $urls;
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=rbac", "root", "toor");

$stmt = $pdo->prepare("insert into access (access_id,title,urls) values ( :access_id,:title, :urls )");
        $stmt->execute(array(":access_id"=>$access_id,":title"=>$title,":urls"=>$urls));
    }
    if(isset($_POST['deleteaccess']))
    {
        $access_id = $_POST['access_id'];
        $title = $_POST['title'];
        $urls = json_encode(explode(",", $_POST['urls']));
        $url=$_POST['urls'];
        echo $urls;
      echo $access_id;
        echo $title;
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=rbac", "root", "toor");
        $stmt = $pdo->prepare("delete from access where access_id=$access_id and title='$title' and urls regexp '[$urls]'");
        $stmt->execute(array(":access_id"=>$access_id,":title"=>$title,":urls"=>$urls));

    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<div>
    <form action="" method='post'>

        <table>
            <caption>用户信息</caption>
            <tr>
                <td>id:</td>
                <td>
                    <input type="" name="access_id" value="<?php echo $access['access_id'] ?>">

                </td>

            </tr>
            <tr>
                <td>title:</td>
                <td>
                    <input type="" name="title" value="<?php echo $access['title'] ?>">

                </td>
            </tr>
            <tr>
                <td>urls:</td>
                <td>

                    <input type="" name="urls" value="<?php print_json($access['urls']); ?>">
                </td>
                <td>   <input type="submit" name="addaccess"><input type="button" name="addaccess" onclick="location.href='rbacindex.php'" value="zhuye"></td>
                <td>
                    <input type="submit" name="deleteaccess" value="删除记录">

                </td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>

