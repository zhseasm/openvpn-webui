<?php
include './header.php';
include 'checkPermission.php';
//var_dump($_SERVER['SERVER_ADDR']);
//var_dump($_SERVER);
$SERVER=$_SERVER['SERVER_ADDR'];
?>

<div class="container-sm">
    <div class="jumbotron jumbotron-sm " >
        <div class="container-sm text-monospace">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                    <?php
                    $init=shell_exec("sudo bash /var/www/html/admin/initnovnc.sh");
                    //var_dump($init);
                    if(!empty($init))
                    {
                        echo "<span><a href=\"./initnovnc.php\" class=\"badge badge-info badge-sm\">请初始化novnc</a></span>";
                    }
                    else
                    {
                        echo "<span><a href=\"https://$SERVER:6080/vnc.html \" target='_blank' class=\"badge badge-info badge-sm\">请初始化novnc</a></span>";
                    }

                      ?>
<iframe src="https://127.0.0.1" class="card-body  min-vw-auto min-vh-100">
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
