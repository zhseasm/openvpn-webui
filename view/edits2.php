
<?php
include './header.php';
$clientname = $_GET['clientname'];
$subnet = $_GET['subnet'];
$netmask = $_GET['netmask'];
/*var_dump($clientname);
var_dump($subnet);
var_dump($netmask);*/
include "./checkPermission.php";
?>
<div class="container-sm">
    <div class="jumbotron jumbotron-sm font-weight-light text-wrap" style="font-size:12px;">
        <div class="row">
            <div class="col-sm-12 text-sm-center">
                <div class="card text-monospace">
                    <div class="card-body">



                    <?php
                        echo "<meta http-equiv=\"refresh\" content=\"2;url=userdetail.php?username=$clientname;\">";
                    $run = shell_exec('sudo bash /var/www/html/admin/edits2.sh -c '.$clientname.' -s '.$subnet.' -n '.$netmask.' -o /var/www/html/download');
                    $result  = shell_exec('echo '.$run.' ｜ grep "edit done"');
                    if ($result){
                        echo "success editing peer ".$clientname.".<br>";
                    }else{
                        echo "failure";
                    }
                    ?>
                    <br>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './footer.php';?>