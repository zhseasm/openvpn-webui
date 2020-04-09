<?php include './header.php';
include 'checkPermission.php';
?>


    <div class="container-sm">
        <div class="jumbotron jumbotron-sm " style="font-size:12px;">
            <div class="container-sm text-monospace">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body text-center">



            <form action="" method="post">


                <input type="text" name="access_id" class="form-control" placeholder="角色ID">
                <br/>

               <input type="text" name="title"  class="form-control" placeholder="资源标题">
                <br/>
                    <textarea  class="form-control" name="urls" placeholder="示例：rbac/frontend/pageone.php"></textarea>
                <br/>
                    <input type="submit" name="addaccess" class="btn btn-sm btn-info" value="添加">
                    <input type="button" value="返回首页" class="btn btn-sm btn-info" onclick="location.href='rbacindex.php'">

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
    if( isset($_POST['addaccess']) ){
        $access_id=$_POST['access_id'];
        $title = $_POST['title'];
        $urls = json_encode( explode(",",$_POST['urls']) );
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=rbac","root","toor");
        $stmt = $pdo->prepare("insert into access (access_id,title,urls) values ( :access_id,:title, :urls )");
        $stmt->execute(array(":access_id"=>$access_id,":title"=>$title,":urls"=>$urls));
    }
 ?>