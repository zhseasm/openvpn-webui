<?php include './header.php';
include './checkPermission.php';
?>
<div class="container-sm">
    <div class="jumbotron jumbotron-sm font-weight-light text-wrap" style="font-size:12px;">
        <div class="row">
            <div class="col-sm-12 text-sm-center">
                <div class="card text-monospace">
<div class="card-body">
                    <h6 class="text-success">Username:
                        <?php
                        $username=$_GET['username'];
                        $rsArr = array();
                        echo exec("cat /var/log/openvpn/status.log | grep ".$username, $rsArr);
                       /* var_dump($rsArr);*/
                        $BitStatArr = explode(',', $rsArr[0]);
                      /*  var_dump($BitStatArr);*/

                        $status =exec('cat /var/log/openvpn/status.log | grep ' . $username);
                        /*echo $status;*/
                        /*$routes =exec("cat /etc/openvpn/ccd/".$username." | sed -r 's/^.{7}//'");*/
                        $routes =exec("cat /etc/openvpn/ccd/".$username."");
                        $StatsArray = explode(',', $status);
                        echo $username."</h6>";
                        /*var_dump($routes);
                        var_dump($StatsArray);*/
                        #print_r($rsArr);



                        if ($routes){
                            echo "S-2-S subnet route:<i> ".$routes."</i><br>";
                            $routeArray = explode(' ', $routes);
                        }else{
                            echo "Roadwarrior<i> (no remote subnet)</i><br>";
                        }


                        if ($status){
                            echo "<br /><span class='text-success text-monospace'>Active:yes</span><hr />";
                            echo "Virtual IP address: " . $StatsArray[0] . "<br>";
                            echo "Certificate Common Name: CN=" . $StatsArray[1] . "<br>";
                            echo "Public IP address: " . $StatsArray[2] . "<br>";
                            echo "Last Heartbeat: " . $StatsArray[3] . "<br>";
                            echo "Connected Since: " . $BitStatArr[4] . "<br>";
                            echo "Bytes Received: " . $BitStatArr[2] . "<br>";
                            echo "Bytes Sent: " . $BitStatArr[3] . "<br>";
                        }else{
                            echo "<br /><span class='text-danger text-monospace'>Active:no</span><hr />";
                        }

                        if ($routes){
                            echo "<br><br><button class='btn btn-sm btn-danger' type='button' data-toggle='modal' data-target='#myModal2'>delete s2s peer</button>";
                            echo "<br><br><button class='btn btn-sm btn-success' type='button' data-toggle='modal' data-target='#editModal'>edit s2s peer</button>";

                        }else{
                            echo "<br><br><button class='btn btn-sm btn-danger' type='button' data-toggle='modal' data-target='#myModal'>delete dialup peer</button>";
                        }
                        ?>



                        <div id="myModal" class="modal fade text-monospace" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
                                        <h6 class="modal-title">删除客户端配置</h6>
                                    </div>
                                    <div class="modal-body">
                                        将会被删除的客户端是:<br>
                                        <br>
                                        <p>
                                            <b><?=$username?></b>
                                        </p>
                                        请注意，删除客户端也会删除对应目录下的证书和配置文件.<br>
                                        <br>
                                        你要继续吗
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal">取消</button>
                                        <a role="button" class="btn btn-sm btn-success" href="./rwremove.php?clientname=<?=$username?>">删除</a>

                                    </div>
                                </div>

                            </div>
                        </div>




                        <div id="myModal2" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                       <!-- <button type="button" class="close" data-dismiss="modal">&times;</button>-->
                                        <h6 class="modal-title">删除客户端配置</h6>
                                    </div>
                                    <div class="modal-body">
                                        将会被删除的客户端是:<br><br><p><b><?=$username?></b></p><br>请注意，删除客户端也会删除对应目录下的证书和配置文件.<br>你要继续吗
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal">取消</button>
                                        <a role="button" class="btn btn-sm btn-success" href="./s2remove.php?clientname=<?=$username?>">删除</a>

                                    </div>
                                </div>

                            </div>
                        </div>




                        <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                             aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <!--<button type="button" class="close"
                                                data-dismiss="modal">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>-->
                                        <h6 class="modal-title" id="myModalLabel">
                                           编辑客户端配置 "<?=$username?>"
                                        </h6>
                                    </div>

                                    <!-- Modal Body -->
                                    <div class="modal-body">
<?php
$subnet=shell_exec("grep \"ifconfig-push\" /etc/openvpn/ccd/$username|awk '{print$2}'");
$network=shell_exec("grep \"ifconfig-push\" /etc/openvpn/ccd/$username|awk '{print$3}'")
?>
                                        <form class="form-horizontal" role="form" action="./edits2.php">
                                            <div class="form-group">
                                                <label  class="col-sm-2 control-label"
                                                        for="inputSubnet">Subnet</label>
                                                <div class="col-sm-12">
                                                    <input type="hidden" class="form-control" id="clientname" name="clientname" value="<?=$username?>"/>
                                                    <input class="form-control"
                                                           id="inputSubnet" placeholder="子网" name="subnet" value="<?=$subnet;?>" data-toggle="popover" title="例子"  data-placement="left" data-content="可选子网组[  1,  2] [  5,  6] [  9, 10] [ 13, 14] [ 17, 18]
[ 21, 22] [ 25, 26] [ 29, 30] [ 33, 34] [ 37, 38]
[ 41, 42] [ 45, 46] [ 49, 50] [ 53, 54] [ 57, 58]
[ 61, 62] [ 65, 66] [ 69, 70] [ 73, 74] [ 77, 78]
[ 81, 82] [ 85, 86] [ 89, 90] [ 93, 94] [ 97, 98]
[101,102] [105,106] [109,110] [113,114] [117,118]
[121,122] [125,126] [129,130] [133,134] [137,138]
[141,142] [145,146] [149,150] [153,154] [157,158]
[161,162] [165,166] [169,170] [173,174] [177,178]
[181,182] [185,186] [189,190] [193,194] [197,198]
[201,202] [205,206] [209,210] [213,214] [217,218]
[221,222] [225,226] [229,230] [233,234] [237,238]
[241,242] [245,246] [249,250] [253,254]" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label"
                                                       for="inputNetmask" >Subnet</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control"
                                                           id="inputNetmask" placeholder="子网" name="netmask" value="<?=$network;?>" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <br><div class="col-sm-12">

                                                    <div class="modal-footer">
                                                        <!--<button type="button" class="btn btn-sm btn-warning" data-dismiss="modal">Cancel</button>
                                                        <a role="button" class="btn btn-sm btn-success" href="./s2remove.php?clientname=<?/*=$username*/?>">Delete</a>-->
                                                        <button type="cancel" class="btn btn-sm btn-warning" data-dismiss="modal">取消</button>
                                                        <button type="submit" class="btn btn-sm btn-success" >保存</button>

                                                    </div>


                                                </div>
                                            </div>
                                        </form>



</div>
                                </div>
                            </div>
                        </div>
                    </h6>
</div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>

    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
    });
</script>
<?php include  './footer.php' ?>
