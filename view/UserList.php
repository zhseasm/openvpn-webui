<?php
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=rbac","root","toor");
    $stmt = $pdo->prepare("select * from user");
    $stmt->execute();
    $user_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
include './header.php';
/*session_start();*/
include './checkPermission.php';
 ?>
    <div class="container-sm">
    <div class="jumbotron jumbotron-sm " style="font-size:12px;">
        <div class="container-sm text-monospace">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body text-center">



            <?php if( count($user_arr) ): ?>
                <?php foreach($user_arr as $user): ?>
                    <?php echo $user['user_id']; ?>
                    <?php echo $user['user_name']; ?>
                    <?php echo $user['user_status']?"正常":"禁用"; ?>
                    <a href="EditUser.php?user_id=<?php echo $user['user_id']?>" class="btn btn-sm btn-info">角色设置</a>
<br/>
                    <br/>
                <?php endforeach; ?>
            <?php endif; ?>







                            <div>
                                <br />
                                <a href="rbacindex.php" class="btn btn-sm btn-info">
                                    回到主页
                                </a>
                            </div>




    <!--    <table>
            <caption>用户列表</caption>
            <tr>
                <td>用户名</td>
                <td>状态</td>
                <td>操作</td>
            </tr>
            <?php /*if( count($user_arr) ): */?>
                <?php /*foreach($user_arr as $user): */?>
                     <tr>
                         <td><?php /*echo $user['user_id']; */?></td>
                        <td><?php /*echo $user['user_name']; */?></td>
                        <td><?php /*echo $user['user_status']?"正常":"禁用"; */?></td>
                        <td>
                            <a href="EditUser.php?user_id=<?php /*echo $user['user_id']*/?>">角色设置</a>
                        </td>
                     </tr>
                <?php /*endforeach; */?>
            <?php /*endif; */?>
        </table>-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

<?php include './footer.php';?>