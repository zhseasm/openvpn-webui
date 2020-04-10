<?php
include './header.php';
include 'checkPermission.php';
//var_dump($_SERVER['SERVER_ADDR']);
$SERVER=$_SERVER['SERVER_ADDR'];
echo shell_exec("sudo bash /var/www/html/env/novnc.sh -n $SERVER");
?>
<div class="container-sm">
    <div class="jumbotron jumbotron-sm " >
        <div class="container-sm text-monospace">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
<iframe src="https://vnc.vpn.com/vnc/" class="card-body  min-vw-auto min-vh-100"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include './footer.php'
?>
