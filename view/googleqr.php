<?php include 'header.php';?>
<div class="container-sm">
    <div class="jumbotron jumbotron-sm font-weight-light text-wrap" style="font-size:12px;">
        <div class="card">

            <pre class="text-wrap">
                <code>
                    <?php
                    require_once 'PHPGangsta/GoogleAuthenticator.php';
                    $ga = new PHPGangsta_GoogleAuthenticator();
                    $secret = $ga->createSecret();
                    //这是生成的密钥，每个用户唯一一个，为用户保存起来
                    echo $secret; echo '<br />';
                    //下面为生成二维码，内容是一个URI地址（otpauth://totp/账号?secret=密钥&issuer=标题）
                    //例子：otpauth://totp/zjwlgr@163.com?secret=6HPH5373NXGO6M7K&issuer=zjwlgr
                    $username=zxh;
                    /*$qrCodeUrl = $ga->getQRCodeGoogleUrl('zjwlgr@163.com', $secret, 'kuaxue');*/
                    $qrCodeUrl='otpauth://totp/zzzz?secret=RWDPNPS6AC47J67Q';
                    /*$qrCodeUrl="http://qr.liantu.com/api.php?text=otpauth://totp/".$username."?secret=".$secret;*/
                    echo "Google Charts URL for the QR-Code: ".$qrCodeUrl."\n\n";
                    //下面为验证参数
                    $oneCode = $_GET['code'];//用户手机中获取的code
                    $secret = '6HPH5373NXGO6M7K';//用户唯一一个密钥，上面生成的
                    //下面为验证用户输入的code是否正确
                    $checkResult = $ga->verifyCode($secret, $oneCode, 2);    // 2 = 2*30秒 时钟容差
                    echo '<br />';
                    if ($checkResult) {
                        echo 'OK';
                    } else {
                        echo 'FAILED';
                    }
                    ?>
                </code>
            </pre>
<div id="qrcode" class="card-body center"></div>
        </div>
    </div>
</div>

<script>
    new QRCode(document.getElementById("qrcode"), "<?= $qrCodeUrl; ?>");
</script>
<?php include 'footer.php';?>
