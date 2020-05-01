<?php include './header.php';
include './checkPermission.php';
/*include './login.php';*/
/*session_start();*/
////先执行一次，后续再用text更改内容//
///
//include './status.php'
?>

<?php
/*echo ("<script>setTimeout('window.location.reload()', 5000);</script>");*/
$kernel = shell_exec('uname -r');
$uptime = shell_exec('uptime');
$who = shell_exec('who');
$status = shell_exec('sudo bash /var/www/html/admin/status.sh');
$status = str_replace(array("\r", "\n"), '', $status);
//$status=$_GET;
//var_dump( $status);
//$status=$_POST;
//var_dump( $status);
$loads = sys_getloadavg();
$core_nums=trim(shell_exec("grep -P '^physical id' /proc/cpuinfo|wc -l"));
$load=$loads[0]/$core_nums;
$load=round($load,0);
/*var_dump($loads);*/
/*var_dump($core_nums);*/
/*var_dump($load);*/
/*$fh = fopen('/proc/meminfo', 'r');
$mem = 0;
while ($line = fgets($fh)) {
    $pieces = array();
    if (preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $pieces)) {
        $mem = ceil($pieces[1] / 1024);
        break;
    }
}*/
$mem=shell_exec('cat /proc/meminfo |grep MemTotal|awk \'{print $2}\'');
/*$mem=ceil(intval($mem) / 1024);*/
(int)$mem=ceil($mem / 1024);
/*var_dump($mem);*/
$memfree=shell_exec('cat /proc/meminfo |grep MemFree|awk \'{print $2}\'');
(int)$memfree=ceil($memfree / 1024);
/*var_dump($memfree);*/
$memused = $mem - $memfree;
/*var_dump($memused);*/
/*fclose($fh);
$fh = fopen('/proc/meminfo', 'r');
$memfree = 0;
while ($line = fgets($fh)) {
    $pieces = array();
    if (preg_match('/^MemFree:\s+(\d+)\skB$/', $line, $pieces)) {
        $memfree = ceil($pieces[1] / 1024);
        break;
    }
}
/*echo */
/*echo $memfree;

echo $memused = $mem - $memfree;*/
?>

<!--
   <script>
        setInterval(function () {
            var a;
            a = $.ajax
            ({
                url:"./echart.php?ajax=true",
                async:false,
                dataType:'json',
                success:function (result) {
                    console.log(result);
                },
                error:function () {
                    console.log('failed');
                },
            });
            $('#time').html(a.responseText);
        },1000)
    </script>-->




    <div class="container-sm">
        <div class="jumbotron jumbotron-sm " style="font-size:12px;">
            <div class="container-sm">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                            <h6 class="card-title">服务器情况</h6>
                            <p class="card-text text-monospace">
                                <span class="badge badge-pill badge-warning">Kernel:</span>
                                <span class="badge badge-pill badge-light text-wrap" id="kernel"><?php echo $kernel ?></span>
                            </p>
                            <p class="card-text text-monospace">
                                <span class="badge badge-pill badge-warning">Who:</span>
                                <span class="badge badge-pill badge-light text-wrap" id="who"><?php echo $who ?></span>
                            </p>
                            <p class="card-text text-monospace">
                                <span class="badge badge-pill badge-warning">Uptime:</span>
                                <span class="badge badge-pill badge-light text-wrap" id="uptime"><?php echo $uptime ?></span>
                            </p>
                            <span id="status"></span>
                            <?php
                            /* echo $status;*/
                           /*if ($status == 'running') {
                                echo "<span class=\"badge badge-success\">Running</span>";
                            } else {
                                echo "<span class=\"badge badge-danger\">Dead</span>";
                            }*/
                           switch ($status){
                                case 'active';
                                echo "<span class=\"badge badge-success\" id='status'>Running</span>";
                                break;
                                case 'failed';
                                    echo "<span class=\"badge badge-warning\" id='status'>Failed</span>";
                                break;
                                case 'inactive';
                                echo "<span class=\"badge badge-danger\" id='status'>Dead</span>";
                                break;
                                default:
                            }


                            ?>


                            <a href="./openvpn.php?xh=0" class="badge badge-primary">关闭</a>
                            <a href="./openvpn.php?xh=1" class="badge badge-primary">开启</a>
                            <a href="./openvpn.php?xh=2" class="badge badge-primary">重启</a>
                                <a class="badge badge-info" data-toggle="collapse" href="#startlog" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    短日志
                                </a>
                                <a class="badge badge-info"  href="./backupconf.php" >
                                    备份配置文件
                                </a>
                                <a class="badge badge-info" href="./restoreconf.php" >
                                    恢复配置文件
                                </a>





                                <!-- Button trigger modal -->
                                <a class="badge badge-sm badge-info" data-toggle="modal" data-target="#exampleModal" href="#">
                                    查看配置文件
                                </a>

                                <!-- Modal -->
                                <div class="modal fade text-monospace" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <span class="modal-title text-monospace badge-sm badge badge-info" id="exampleModalLabel">server.conf</span>
                                                <a  data-dismiss="modal" aria-label="Close" class="badge-light badge badge--sm">
                                                    <span aria-hidden="true">x</span>
                                                </a>
                                            </div>
                                            <div class="modal-body">
                        <code>
                                             <?php

                                           $conf=shell_exec('cat /etc/openvpn/server.conf');
                                            $conf=nl2br($conf);
                                            echo $conf;
                                             ?>
                        </code>
                                            </div>
                                            <div class="modal-footer">
                                                <a  class="badge badge-sm badge-info" data-dismiss="modal" href="#">Close</a>
                                               <!-- <a  class="badge badge-sm badge-info">Save changes</a>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>






                                <a href="./index.php" class="badge badge-info">刷新</a>
                            <!--<a href="#" class="badge badge-info" onclick="window.location.reload()">刷新</a>-->
                            <!--<a href="?xh=2" class="badge badge-primary">重启服务器</a>-->
                                <div class="collapse text-wrap" id="startlog">
                                    <div class="card card-body">

                                        <code>
                                            <?php
                                            $startlog=shell_exec('sudo bash /var/www/html/admin/startlog.sh');
                                            $startlog=nl2br($startlog);
                                            echo $startlog;
                                            ?>

                                        </code>

                                    </div>
                                </div>

                        </div>
                    </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div>


                                    <span class="badge badge-pill badge-warning">网络负载:</span>


                                <p class="card-text text-monospace text-wrap" style="font-size: 13px;">
                                    <code>
                                   <!--<span class="badge badge-pill badge-light text-wrap"><?php /*echo nl2br(shell_exec('sudo bash /var/www/html/admin/s.sh ens33')); */?></span>-->
                                    <span id="ens33" class="badge badge-pill badge-light text-wrap"><?php echo nl2br(shell_exec('sudo bash /var/www/html/admin/s.sh ens33')); ?></span>
                                    </code>
                                </p>

                                <p class="card-text text-monospace text-wrap" style="font-size: 13px;">
                                    <code>
                                   <!--<span class="badge badge-pill badge-light text-wrap"><?php /*echo nl2br(shell_exec('bash /var/www/html/admin/s.sh tun0')); */?></span>-->
                                        <span id="tun0" class="badge badge-pill badge-light text-wrap"><?php echo nl2br(shell_exec('bash /var/www/html/admin/s.sh tun0')); ?></span>
                                    </code>
                                </p>
                                </div>


                            </div>
                        </div>
                    </div>
                <div class="col-sm-6" >
                    <div class="card">
                        <div class="card-body">

                            <div class="card-content text-monospace text-wrap">
                                <!--<span class="badge badge-pill badge-warning text-wrap">
                                内存用量:<span id="mem-used"></span>of
                                    <span id="mem-total"></span>
                                </span>-->
                                <span id="meminfo" class="badge badge-pill badge-warning text-wrap">
                                    内存用量:<?= $memused; ?>
                                    MB of <?= $mem; ?> MB
                                </span>
                                <!--<span class="badge badge-pill badge-warning text-wrap">内存用量:<?/*= $memused; */?>
                                    MB of <?/*= $mem; */?> MB</span>-->
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="<?= $memused; ?>"
                                         aria-valuemin="0" aria-valuemax="<?= $mem; ?>"
                                         style="min-width: 0em; width: <?= (((1 / $mem) * $memused) * 100); ?>%" id="memprogress">
                                        <?= round((((1 / $mem) * $memused) * 100), 0); ?>%

                                    </div>
                                </div>
                                <span class="badge badge-pill badge-warning text-wrap" id="cpuinfo">cpu平均用量(1/5/15min):<?= $loads[0]; ?>,<?= $loads[1]; ?>,<?= $loads[2]; ?></span>

                        <?php
                      /*  ceil($load);
                        var_dump($load);
                        var_dump($loads);*/
                        ?>
                                <div class="progress">

                                    <div class="progress-bar" role="progressbar" aria-valuenow="<?= $load; ?>"
                                         aria-valuemin="0" aria-valuemax="100"
                                         style="min-width: 0em; width: <?= ($load) * 100; ?>%" id="cpuprogress">
                                        <?= ($load) * 100; ?>%
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">用户详情</h6>
                                <p class="card-text text-monospace">
                                    <span class="badge badge-pill badge-warning">账户数量:</span>
                                    <span class="badge badge-pill badge-light text-wrap"><?php
                                        echo shell_exec('ls /etc/openvpn/client/keys/ |wc -l')
                                        ?></span>

                                </p>
                                <p class="card-content text-monospace">
                                    <span class="badge badge-pill badge-warning">在线用户:</span>
                                    <span  id="userinfo">


                                    <?php
/*                                     echo shell_exec('date "+%A %d %b %Y %T"');
                                     echo "aa";
                                     */?>
                                        <?php
/*                                    $users= array();
                                    exec('/usr/bin/ls /etc/openvpn/client/keys/', $users);
                                    var_dump($users);
                                    foreach ($users as &$user){
                                        $result=exec('cat /var/log/openvpn/status.log | grep ' . $user);
                                         var_dump($result);
                                        if ($result){
                                            echo "<div class='text-success' role='alert'>";
                                            echo  "<span class='badge-success badge-sm badge badge-pill'>".$user.'</span>';
                                            echo "<span>";
                                            echo "<a class='badge badge-success' href='./userdetail.php?username=".$user."' role='button'>details</a>";
                                            echo "</span>";
                                            echo "</div>";
                                        }
                                    }
                                    */?>
                                    </span>
                                </p>

                            </div>
                        </div>
                    </div>


                    </div>
            </div>
        </div>
    </div>


<?php include './footer.php';

?>