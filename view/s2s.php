
<?php
include './header.php';
$ip=shell_exec('/usr/sbin/ip addr |grep "inet " |grep -v " lo"|grep -v "tun0"|awk \'{print$2}\'|sed "s/\/24//g"|sed "s/\/16//g"|sed "s/\/8//g"');
$ip=trim($ip);
$ip=str_replace("\n",'或',$ip);
include "./checkPermission.php";
?>

<div class="container-sm">
    <div class="jumbotron jumbotron-sm font-weight-light text-wrap" style="font-size:12px;">
        <div class="row">
            <div class="col-sm-12 text-sm-center text-monospace">

                <div class="card">

                    <div class="card-body">
                    <form id="myform" action="./s2s2.php" >
                        <div class="row">
                <div class="col-sm-12">
                          <span>
                                <input type="text" class="form-control" name="clientname" placeholder="客户端名称" value="">
                            </span>
<br />
                            <span>
                                <input type="text" class="form-control" name="server" placeholder="服务器域名或ip:<?=$ip;?>" value="">
                            </span>
    <br />
                            <span>
                                <input type="text" class="form-control" data-toggle="popover" title="例子"  data-placement="left" data-content="可选子网组[  1,  2] [  5,  6] [  9, 10] [ 13, 14] [ 17, 18]
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
[241,242] [245,246] [249,250] [253,254]" name="network" placeholder="客户端子网:10.8.0.1 10.8.0.2" value="">
                            </span>

<br />
                    <span>
                                <input type="text" class="form-control" name="pass" placeholder="密码" value="">
                            </span>



                    <br />
<span>
       <button class="btn btn-sm btn-info"  type="submit">创建</button>

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
<script>
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
    });
</script>
<?php include './footer.php';?>