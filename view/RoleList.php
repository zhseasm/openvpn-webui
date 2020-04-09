<?php
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=rbac","root","toor");
    $stmt = $pdo->prepare("select * from role");
    $stmt->execute();
    $role_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=rbac","root","toor");
    $stmt = $pdo->prepare("select * from role_access");
    $stmt->execute();
    $role_access_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
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





            <?php if( count($role_arr) ): ?>
                <?php foreach($role_arr as $role): ?>

                  <?php echo $role['role_id']; ?>
                     <?php echo $role['role_name']; ?>

                            <a href="EditRole.php?role_id=<?php echo $role['role_id']?>" class="btn btn-sm btn-info">权限设置</a>
                    <br />
                <?php endforeach; ?>
            <?php endif; ?>

            <?php /*if( count($role_access_arr) ): */?><!--
                <?php /*foreach($role_access_arr as $role_access): */?>

                   <?php /*echo $role_access['role_id']; */?>
                      <?php /*echo $role_access['access_id']; */?>

                            <a href="EditRole.php?role_id=<?php /*echo $role_access['role_id']*/?>" class="btn btn-sm btn-success">权限设置</a>

<br />
                <?php /*endforeach; */?>
            --><?php /*endif; */?>

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

<?php include './footer.php'?>