<?php
include './header.php';
include 'checkPermission.php';
$SERVER=$_SERVER['SERVER_ADDR'];
$result=shell_exec("sudo bash /var/www/html/env/novnc.sh -n $SERVER");
?>

<meta http-equiv="refresh" content="1;url=novnc.php">
<div class="container-sm">
    <div class="jumbotron jumbotron-sm " >
        <div class="container-sm text-monospace">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
        <?php echo $result;
        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>