<?php
include './header.php';
include 'checkPermission.php';
//var_dump($_SERVER['SERVER_ADDR']);
$SERVER=$_SERVER['SERVER_ADDR'];
shell_exec("sudo bash /var/www/html/env/novnc.sh -n $SERVER");
?>
<div class="container-sm">
    <div class="jumbotron jumbotron-sm " >
        <div class="container-sm text-monospace">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
<iframe src="https://192.168.31.121:6080/vnc.html" class="card-body  min-vw-auto min-vh-100">
<!--    <script>document.write()
        }</script>-->
    <iframe>
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
