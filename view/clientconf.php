<?php include './normalheader.php';
session_start();
/*var_dump($_SESSION);*/
include './checknormallogin.php';
//include './checkPermission.php';
/*var_dump($_SERVER);*/
?>
<div class="container-sm">
    <div class="jumbotron jumbotron-sm " style="font-size:12px;">
        <div class="container-sm text-monospace">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">



                            <a class="badge badge-sm badge-info" data-toggle="modal" data-target="#exampleModal" href="#">
                                查看配置文件
                            </a>
                            <a class="badge badge-sm badge-info"  href="./updateclient.php?name=<?=$_SESSION["username"];?>">
                                更新配置文件
                            </a>
                            <a class="badge badge-sm badge-info"  href="./downloadclient.php?name=<?=$_SESSION["username"];?>.zip" >
                                下载配置文件
                            </a><!--get传值到downloadclient.php，进行相关操作-->
                            <a class="badge badge-sm badge-info" href="#" data-toggle="modal" data-target="#exampleModal1">
                                下载客户端
                            </a>



                            <div class="modal fade text-monospace" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <span class="modal-title text-monospace badge-sm badge badge-info" id="exampleModalLabel1">客户端</span>
                                            <a  data-dismiss="modal" aria-label="Close" class="badge-light badge badge--sm">
                                                <span aria-hidden="true">x</span>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <code>
                                                <?php
                                                /*$username=$_SESSION['username'];
                                                $conf=shell_exec("sudo bash /var/www/html/admin/clientconf.sh -c $username");
                                                /*echo "cat /etc/openvpn/client/keys/${_SESSION['username']}/${_SESSION['username']}.ovpn";*/
                                               /* $conf='aa';
                                                $conf=nl2br($conf);
                                                echo $conf;*/
                                                ?>
                                                <a href="./download.php?name=openvpn.apk" class="badge badge-sm badge-info">
                                                    安卓
                                                </a>
                                                <a href="./download.php?name=and-openvpn.apk" class="badge badge-sm badge-info">
                                                    第三方安卓
                                                </a>
                                                <a href="https://apps.apple.com/us/app/openvpn-connect/id590379981" class="badge badge-sm badge-info">
                                                    ios
                                                </a>
                                                <a href="./download.php?name=openvpn-Win7.exe" class="badge badge-sm badge-info">
                                                    windows7
                                                </a>
                                                <a href="./download.php?name=openvpn-Win10.exe" class="badge badge-sm badge-info">
                                                    windows10
                                                </a>
                                                <a href="./download.php?name=openvpn-linux.zip" class="badge badge-sm badge-info">
                                                    linux
                                                </a>
                                                <a href="./download.php?name=openvpn-macos.dmg" class="badge badge-sm badge-info">
                                                    macos
                                                </a>
                                            </code>
                                        </div>
                                        <div class="modal-footer">
                                            <a  class="badge badge-sm badge-info" data-dismiss="modal" href="#">Close</a>
                                            <!-- <a  class="badge badge-sm badge-info">Save changes</a>-->
                                        </div>
                                    </div>
                                </div>
                            </div>



                           <!-- <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        ...
                                    </div>
                                </div>
                            </div>-->
                            <!-- Modal -->
                            <div class="modal fade text-monospace" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <span class="modal-title text-monospace badge-sm badge badge-info" id="exampleModalLabel"><?=$_SESSION['username'].'.ovpn';?></span>
                                            <a  data-dismiss="modal" aria-label="Close" class="badge-light badge badge--sm">
                                                <span aria-hidden="true">x</span>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <code>
                                                <?php
                                                $username=$_SESSION['username'];
                                                $conf=shell_exec("sudo bash /var/www/html/admin/clientconf.sh -c $username");
                                                /*echo "cat /etc/openvpn/client/keys/${_SESSION['username']}/${_SESSION['username']}.ovpn";*/
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







                           <!-- <code>
                                <?php
/*                                $clientconf=shell_exec('cat /etc/openvpn/client/keys/zhu/zhu.ovpn');
                                $clientconf=nl2br($clientconf);
                                echo $clientconf;
                                ;*/?>

                            </code>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include './normalfooter.php';?>
