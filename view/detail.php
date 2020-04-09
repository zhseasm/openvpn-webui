<?php include './header.php';
include './checkPermission.php';
?>
<div class="container-sm">
    <div class="jumbotron jumbotron-sm font-weight-light text-wrap" style="font-size:12px;">

            <a class="badge badge-sm badge-info" data-toggle="collapse" href="#diskinfo" role="button" aria-expanded="false" aria-controls="collapseExample">
            磁盘信息
            </a>
            <a class="badge badge-sm badge-info" data-toggle="collapse" href="#cpuinfoto" role="button" aria-expanded="false" aria-controls="collapseExample">
            cpu信息
            </a>
        <a class="badge badge-sm badge-info" data-toggle="collapse" href="#meminfoto" role="button" aria-expanded="false" aria-controls="collapseExample">
            内存信息
        </a>
        <a class="badge badge-sm badge-info" data-toggle="collapse" href="#cputop" role="button" aria-expanded="false" aria-controls="collapseExample">
            占用cpu前10的进程
        </a>
            <a class="badge badge-sm badge-info" data-toggle="collapse" href="#ifinfo" role="button" aria-expanded="false" aria-controls="collapseExample">
            网卡信息
            </a>
        <a class="badge badge-sm badge-info" data-toggle="collapse" href="#dns" role="button" aria-expanded="false" aria-controls="collapseExample">
            dns信息
        </a>
            <a class="badge badge-sm badge-info" data-toggle="collapse" href="#ipcount" role="button" aria-expanded="false" aria-controls="collapseExample">
            ip连接数
            </a>
            <a class="badge badge-sm badge-info" data-toggle="collapse" href="#iptop" role="button" aria-expanded="false" aria-controls="collapseExample">
            访问数量前10的ip
           </a>
        <a class="badge badge-sm badge-info" data-toggle="collapse" href="#pagetop" role="button" aria-expanded="false" aria-controls="collapseExample">
            访问数量前10的页面
        </a>
        <a class="badge badge-sm badge-info" data-toggle="collapse" href="#filelist" role="button" aria-expanded="false" aria-controls="collapseExample">
           24小时内修改的文件和权限
        </a>
       <!-- <a class="badge badge-primary" data-toggle="collapse" href="#hiddenlist" role="button" aria-expanded="false" aria-controls="collapseExample">
            隐藏权限
        </a>-->
        <a class="badge badge-sm badge-info" data-toggle="collapse" href="#blastip" role="button" aria-expanded="false" aria-controls="collapseExample" >
            尝试爆破的ip
        </a>
       <!-- <a class="badge badge-primary"  href="?blastip=1" aria-expanded="false" aria-controls="collapseExample" onclick="#blastip">
            尝试爆破的ip1
        </a>-->

        <a class="badge badge-info" data-toggle="collapse" href="#" role="button" onclick="window.location.href='./detail.php'" aria-expanded="false" aria-controls="collapseExample">
            刷新
        </a>
            <div class="collapse" id="diskinfo">
                <div class="card card-body">
                <span>
                      <code>
        <?php
        $diskinfo=shell_exec('df -hP');
        $diskinfo=nl2br($diskinfo);
        echo $diskinfo;
        ?>

                      </code>
                </span>
                </div>
            </div>



            <div class="collapse" id="cpuinfoto">

                <div class="card card-body">

                        <code>
        <?php
        $processor=shell_exec('cat /proc/cpuinfo |grep processor|wc -l');
        $modlename=shell_exec('cat /proc/cpuinfo |grep "model name"|tail -n 1 |cut -d ":" -f 2');
        $cachesize=shell_exec('cat /proc/cpuinfo |grep "cache size"|tail -n 1 |cut -d ":" -f 2');
        $lscpu=shell_exec('lscpu');
        $lscpu=nl2br($lscpu);
        /*echo '核心数:'.$processor;
        echo "<br />";
        echo 'cpu名称:'.$modlename;
        echo "<br />";
        echo '缓存大小:'.$cachesize;
        echo "<br />";*/
        echo $lscpu;
        ?>
                        </code>

                </div>
            </div>

            <div class="collapse text-wrap" id="ifinfo">
                <div class="card card-body">

                            <code>
        <?php
        $ifinfo = shell_exec('/usr/sbin/ip address');
        $ifinfo=nl2br($ifinfo);
        /*str_replace("\n", '<br>', $ifinfo);*/
        echo $ifinfo;

        ?>
                            </code>

                </div>
            </div>

        <div class="collapse" id="dns">
            <div class="card card-body">

                <code>
                    <?php
                    $dns=shell_exec('sudo bash /var/www/html/admin/dnsshow.sh');
                    $dns=str_replace('\r','',$dns);
                    $dns=nl2br($dns);

                    ?>
                    <?php echo $dns;?>
                </code>

            </div>
        </div>

        <div class="collapse" id="meminfoto">
            <div class="card card-body">

                <code>
                    <?php
                    $meminfo=shell_exec('free -l -h -t');
                    $meminfo=nl2br($meminfo);
                    echo $meminfo;
                    ?>

                </code>

            </div>
        </div>

        <div class="collapse" id="cputop">
            <div class="card card-body">

                <code>
                    <?php
                    $cputop=shell_exec('ps  -axo "uname,ppid,pid,etime,%cpu,%mem,args" | tail -n +2 | sort -rn -k 5|head');
                    $cputopheader= shell_exec('ps  -axo uname,ppid,pid,etime,%cpu,%mem,args | sed -n 1p');
                    $cputop=nl2br($cputop);
                    $cputopheader=nl2br($cputopheader);
                    echo $cputopheader;
                    echo $cputop;
                    ?>

                </code>

            </div>
        </div>


        <div class="collapse" id="ipcount">
            <div class="card card-body">

                <code>
                    <?php
                    $ipcount=shell_exec('sed -n "1,4p" /var/www/html/admin/loginfo.sh |sudo bash');
                    $ipcount=nl2br($ipcount);
                    echo $ipcount;
                    ?>

                </code>

            </div>
        </div>

        <div class="collapse" id="iptop">
            <div class="card card-body">

                <code>
                    <?php
                    $iptop=shell_exec('sed -n "5,7p" /var/www/html/admin/loginfo.sh |sudo bash');
                    $iptop=nl2br($iptop);
                    echo $iptop;
                    ?>

                </code>

            </div>
        </div>

        <div class="collapse" id="pagetop">
            <div class="card card-body">

                <code>
                    <?php
                    $pagetop=shell_exec('sed -n "8,10p" /var/www/html/admin/loginfo.sh |sudo bash');
                    $pagetop=nl2br($pagetop);
                    echo $pagetop;
                    ?>

                </code>

            </div>
        </div>

        <div class="collapse" id="filelist">
            <div class="card card-body">

                <code>
                    <?php
                    $filelist=shell_exec('sed -n "11,15p" /var/www/html/admin/loginfo.sh |sudo bash');
                    $filelist=nl2br($filelist);
                    echo $filelist;
                    ?>

                </code>

            </div>
        </div>

       <!-- <div class="collapse" id="hiddenlist">
            <div class="card card-body">

                <code>
                    <?php
/*                    $hiddenlist=shell_exec('sed -n "12,13p" /var/www/html/admin/loginfo.sh |sudo bash');
                    $hiddenlist=nl2br($hiddenlist);
                    echo $hiddenlist;
                    */?>

                </code>

            </div>
        </div>-->


        <div class="collapse" id="blastip">
            <div class="card card-body">

                <code>
                    <?php
                   /* if($_GET[blastip] == 1 ) {
                        $blastip = shell_exec('sed -n "14,22p" /var/www/html/admin/loginfo.sh |sudo bash');
                        $blastip = nl2br($blastip);
                        echo $blastip;
                        echo $_GET($blastip);
                    }
                    else
                    {
                        echo 'aaa';
                    }*/

                        $blastip = shell_exec('sed -n "21,25p" /var/www/html/admin/loginfo.sh |sudo bash');
                        $blastip = nl2br($blastip);
                        echo $blastip;
                        /*echo $_GET($blastip);*/


                      /*爆破的归属地
                        $area=shell_exec('sed -n "26,31p" /var/www/html/admin/loginfo.sh |sudo bash');
                        $area=nl2br($area);
                        echo $area;*/
                        ?>
                </code>

            </div>
        </div>



    </div>



</div>
<?php include "./footer.php"; ?>


