
<?php
$clientname = $_GET['clientname'];
include './header.php';
include "./checkPermission.php";
echo "<meta http-equiv=\"Refresh\" content=\"1;url=./index.php\" />";
?>
<div class="container-sm">
    <div class="jumbotron jumbotron-sm font-weight-light text-wrap" style="font-size:12px;">
        <div class="row">
            <div class="col-sm-12 text-sm-center">
                <div class="card text-monospace">
                    <div class="card-body">


                    <?php
                    $run = shell_exec('sudo bash /var/www/html/admin/rwrevokeuser.sh -c '.$clientname.' -o /var/www/html/download');
                    $result  = shell_exec('echo '.$run.' ｜ grep "done"');
                    if ($result){
                        echo "Removed ".$clientname." successfully.<br><br><pre>".$result."</pre>";
                    }else{
                        echo "failure";
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include './footer.php';?>