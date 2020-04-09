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


<div>
    <form action="" method='post'>


                    <input type="" name="access_id" class="form-control" value="<?php echo $access['access_id'] ?>">
<br />
                    <input type="" name="title" class="form-control" value="<?php echo $access['title'] ?>">
        <br />

                    <input type="" name="urls" class="form-control" value="<?php print_json($access['urls']); ?>">
        <br />
             <input type="submit" name="addaccess" class="btn btn-sm btn-info">
        <input type="button" class="btn btn-sm btn-info" onclick="window.history.back()" value="返回">
        <input type="button"  class="btn btn-sm btn-info" onclick="location.href='rbacindex.php'" value="主页"></td>

        <input type="submit"  class="btn btn-sm btn-info" name="deleteaccess" value="删除记录">


    </form>
</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "./footer.php";?>~

