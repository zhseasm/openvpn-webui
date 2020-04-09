<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 2020/4/3
 * Time: 20:49
 */
session_start();
include './normalheader.php';
include './checknormallogin.php';
/*include './checkPermission.php';*/
$user=$_SESSION['username'];
//var_dump($user);
$secret=shell_exec("grep \"^$user \" /etc/openvpn/auth/otp-secrets|cut -d \":\" -f 4 |awk '{print$1}'");
$secret=trim($secret);
/*var_dump($user);
var_dump($secret);*/
/*var_dump($_SERVER);*/
$qrCodeUrl="otpauth://totp/$user?secret=$secret";
?>
<div class="container-sm text-center">
    <div class="jumbotron jumbotron-sm font-weight-light text-wrap" style="font-size:12px;">
        <div class="card">
         <!--   <div class="col-sm-2">
                <a href="#" onclick="javascript:copy();" id="copy" class="badge badge-sm badge-info">copy</a></div>-->
                <div class="card-body">

                     <span class="text-monospace text-wrap" id="secret">
                <?php

                  $secret=trim(shell_exec("oathtool --totp -b $secret"));
                  //var_dump($secret);
                  nl2br($secret);
                  echo $secret;
                ;?>
              </span>

                    <br/>
                    <span>
                <a href="#" onclick="copysecret();" id="copysecret" class="badge badge-sm badge-info">copy</a>
            </span>
                    <br/>
                    <span id="qr" class="text-monospace text-wrap" >
    <?php echo $qrCodeUrl;?>
</span>
                    <br/>

                    <span class="text-wrap text-monospace">
                <a href="#" onclick="copy();" id="copy" class="badge badge-sm badge-info">copy</a>
            </span>
                    <br/>


                </div>
            <div id="qrcode" style="margin-right: auto;margin-left: auto;"></div>

            <br/>
          <!--  <span>
                <a class="badge badge-sm badge-info" href="#" onclick="window.location.reload()">刷新</a>
            </span>-->
            <div class="badge-info badge" >otp验证码
                <a class="badge badge-sm badge-info" href="#" onclick="window.location.reload()">刷新</a>
            </div>


        </div>
    </div>
</div>

<script>
    new QRCode(document.getElementById("qrcode"), "<?= $qrCodeUrl; ?>");
    function copy() {
        const range = document.createRange();
        range.selectNode(document.getElementById('qr'));

        const selection = window.getSelection();
        if (selection.rangeCount > 0) selection.removeAllRanges();
        selection.addRange(range);
        document.execCommand('copy');
        document.getElementById('copy').innerText = 'copyed';
    }
        function copysecret() {
            const range = document.createRange();
            range.selectNode(document.getElementById('secret'));

            const selection = window.getSelection();
            if(selection.rangeCount > 0) selection.removeAllRanges();
            selection.addRange(range);
            document.execCommand('copy');
            document.getElementById('copysecret').innerText='copyed';
        /*alert("复制成功！");*/

       /* var e=document.getElementById('qr').innerText;*/

        //e.select();
       // alert(e);
       // e.select();
       // e.execCommand("COPY");
  /*      window.clipboardData.setData("text",e);
        document.getElementById('copy').innerText='copyed';
        alert('yes')*/
    }
</script>
<?php
include './normalfooter.php'
?>
