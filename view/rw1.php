
<?php
include "./header.php";
$port=shell_exec('grep "port" /etc/openvpn/server.conf|awk \'{print$2}\'');
$ip=shell_exec('/usr/sbin/ip addr |grep "inet " |grep -v " lo"|grep -v "tun0"|awk \'{print$2}\'|sed "s/\/24//g"|sed "s/\/16//g"|sed "s/\/8//g"');
$ip=trim($ip);
$ip=str_replace("\n",'或',$ip);
?>
<div class="container-sm">
    <div class="jumbotron jumbotron-sm font-weight-light text-wrap" style="font-size:12px;">
        <div class="row">
            <div class="col-sm-12 text-sm-center text-monospace">

                <div class="card">

                <div class='card-body'>
                <form  id="myform" action="./rw2.php" >
                        <div class="row">
                            <div class="col-sm-12">
                                <span>
                                <input type="text" class="form-control" name="clientname" placeholder="客户端名称" value="">
                                </span>
                                <br />
                                <span>
                                <input type="text" class="form-control" name="server" placeholder="服务端域名或ip:<?=$ip;?>" value="">
                                </span>
                                <br />
                                <span>
                                 <input type="text" class="form-control" placeholder="密码" name="password"  value="">
                                </span>
                                <br />
                                <span>

                                <!--<input type="text" class="form-control" placeholder="端口:<?/*=$port;*/?>" name="port"  value="">
                                </span>
                                <br />
                                <span>-->
                                <button class="btn btn-sm btn-info" type="submit">创建</button>
                            </span>
                            </div>
                        </div>
                    </form>

                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "./footer.php";?>