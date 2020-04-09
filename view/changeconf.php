<?php
$proto = $_GET['proto'];
$port = $_GET['port'];
$subnet = $_GET['TransSubnet'];
$netmask = $_GET['TransNetmask'];
$cipher = $_GET['cipher'];
$username=$_GET['username'];
$mysql=$_GET['mysql'];
$otp=$_GET['otp'];
$script=$_GET['script'];
$interclient = $_GET['interclient'];
$lzo = $_GET['lzo'];
/*var_dump($proto);*/
/*var_dump($port);
var_dump($subnet);
var_dump($netmask);
var_dump($cipher);
var_dump($interclient);
var_dump($username);
var_dump($mysql);
var_dump($otp);
var_dump($script);
var_dump($lzo);*/
include './checkPermission.php';
?>
<?php include './header.php'; ?>
    <meta http-equiv="refresh" content="5;url=./vpnconf.php" />
<div class="container-sm">
    <div class="jumbotron jumbotron-sm font-weight-light text-wrap " style="font-size:12px;">
        <div class="card">
            <div class="card-body">
                <pre>
                    <code>
<?php
/*echo 'pr__';
var_dump($proto);
echo 'po__';
var_dump($port);
echo 'sub__';
var_dump($subnet);
echo 'netmask__';
var_dump($netmask);
echo 'clipher__';
var_dump($cipher);
echo 'interclient__';
var_dump($interclient);
echo 'username__';
var_dump($username);
echo 'mysql__';
var_dump($mysql);
echo 'otp__';
var_dump($otp);
echo 'script__';
var_dump($script);
echo 'lzo__';
var_dump($lzo);*/
?>
<?php $result=shell_exec('sudo bash /var/www/html/admin/changeconf.sh -pr '.$proto.' -po '.$port.' -s '.$subnet.' -m '.$netmask.' -c '.$cipher.' -i '.$interclient.' -u '.$username.' -mysq '.$mysql.' -ot '.$otp.' -scr '.$script.' -l '.$lzo);
echo $result;
?>

                    </code>
                </pre>

            </div>
        </div>
    </div>
</div>
<?php include './footer.php'; ?>