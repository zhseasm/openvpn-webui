
<?php
include './header.php';
$clientname = $_GET['clientname'];
$serverurl = $_GET['server'];
/*$port=$_GET['port'];*/
$pass=$_GET['password'];

?>

<div class="container-sm">
    <div class="jumbotron jumbotron-sm font-weight-light text-wrap" style="font-size:12px;">
        <div class="row">
            <div class="col-sm-12 text-sm-center text-monospace">

                <div class="card">

                    <div class='card-body'>

                <div class='well'>

                    <?php
                   /* var_dump($clientname);
                    var_dump($serverurl);
                    var_dump($pass);*/
                    $run = shell_exec('sudo bash /var/www/html/admin/rwadduser.sh -c '.$clientname.' -s '.$serverurl.' -p '.$pass.' -o /var/www/html/download');
                    $result  = shell_exec('echo '.$run.' ｜ grep "DSC ovpn clientWiz done"');
                    if ($result){
                        echo "success creating user ".$clientname.".<br>Please go to <a href='./downloadclient.php?name=".$clientname.".zip'>/download/".$clientname."</a> to retrieve the generated client config and certs.";
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
</div>
<?php include './footer.php';?>