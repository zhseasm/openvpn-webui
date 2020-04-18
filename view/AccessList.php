<?php
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=rbac","root","toor");
    $stmt = $pdo->prepare("select * from access");
    $stmt->execute();
    $access_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
    function print_json($data){
        $arr = json_decode($data,true);
        foreach($arr as $v ){
            echo $v."<br>";
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
                        <div class="card-body text-center">

            <?php if( count($access_arr) ): ?>
                <?php foreach($access_arr as $access): ?>

                     <?php echo $access['access_id']; ?>
                       <?php echo $access['title']; ?>
                     <?php print_json($access['urls']); ?>

                            <a class="btn btn-sm btn-info" href="EditAccess.php?access_id=<?php echo $access['access_id']?>">资源设置</a>
                    <br />
                <?php endforeach; ?>

            <?php endif; ?>
<div>
    <br />
    <a href="rbacindex.php" class="btn btn-sm btn-info">
        回到主页
    </a>
</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include './footer.php';?>