<?php include './header.php'; ?>
<?php
$clientname = $_GET['clientname'];
$serverurl = $_GET['server'];
$pass=$_GET['pass'];
$network=array();
$network = $_GET['network'];
$network=explode(' ',$network);
/*var_dump($clientname);
var_dump($serverurl);
var_dump($network);
var_dump($network[0]);
echo '<hr/>';
var_dump($network[1]);
var_dump($pass);*/
?>
<div class="container-sm">
    <div class="jumbotron jumbotron-sm font-weight-light text-wrap" style="font-size:12px;">
        <div class="row">
            <div class="col-sm-12 text-sm-center text-monospace">

                <div class="card">

                    <div class="card-body">


                    <?php
                    $run = shell_exec('sudo bash /var/www/html/admin/s2adduser.sh -c '.$clientname.' -s '.$serverurl.' -n '.$network[0].' -b '.$network[1].' -p '.$pass.' -o /var/www/html/download');
                    $result  = shell_exec('echo '.$run.' ｜ grep "DSC ovpn clientWiz done"');
                    if ($result){
                        echo "success creating user ".$clientname.".<br>Please go to <a href='./downloadclient.php?name=".$clientname.".zip'>/download/".$clientname."</a> to retrieve the generated client config and certs.";
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




