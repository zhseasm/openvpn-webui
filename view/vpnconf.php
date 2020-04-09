<?php include './header.php';
include './checkPermission.php';
?>
<?php

$proto = shell_exec("cat /etc/openvpn/server.conf | grep proto | head -n1 |cut -c 7-");
$port  = shell_exec("cat /etc/openvpn/server.conf | grep port  | cut -c 6-");
$serverNet = shell_exec("cat /etc/openvpn/server.conf | grep server|head -n 1|cut -c 8-");
$serverNet = str_replace(array("\r", "\n"), '', $serverNet);
$serverNetArr = explode(' ', $serverNet);


 ?>


<?php
//转化为enabled
function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}


							$serverNet = shell_exec("grep 'server ' /etc/openvpn/server.conf |head -n 1| cut -c 8-");
							$serverNet = str_replace(array("\r", "\n"), '', $serverNet);
							$serverNetArr = explode(' ', $serverNet);
							$proto = shell_exec("grep proto /etc/openvpn/server.conf|head -n 1| cut -c 7-");
							$proto = str_replace(array("\r", "\n"), '', $proto);
							$port  = shell_exec("grep port /etc/openvpn/server.conf |head -n 1| cut -c 6-");
							$port = str_replace(array("\r", "\n"), '', $port);
							$cipher  = shell_exec("grep 'cipher' /etc/openvpn/server.conf | cut -c 8-");
							$cipher = str_replace(array("\r", "\n"), '', $cipher);
							$interclient  = shell_exec("grep 'client-to-client' /etc/openvpn/server.conf");//客户端to客户端
							$interclient = str_replace(array("\r", "\n"), '', $interclient);
							$compression  = shell_exec("grep 'comp-lzo' /etc/openvpn/server.conf ");
							$compression = str_replace(array("\r", "\n"), '', $compression);
							$username=shell_exec("grep 'username-as-common-name' /etc/openvpn/server.conf");
							/*$username=str_replace(array("\r", "\n"), '',$username);*/
							$mysql=shell_exec("grep 'plugins' /etc/openvpn/server.conf");
							$otp=shell_exec("grep 'openvpn-otp.so' /etc/openvpn/server.conf");
							$script=shell_exec("grep 'auth-user-pass-verify' /etc/openvpn/server.conf");
//PHP函数中，我们经常可以看到haystack和needle，那么这两个到底是什么意思呢？
//
//其实啊，$haystack(干草堆)是搜索字符序列,$needle(针)是
//要在$haystack中搜索的内容。所以可以解释为Find a needle in haystack,就是大海捞针,查找困难。
//从某一行里寻找是否有;符号，有;符号在openvpn中是注释

if (startsWith($script,";")) {
    $script ="disabled";
}else{
    $script="enabled";
}

if (startsWith($otp,";")) {
    $otp ="disabled";
}else{
    $otp="enabled";
}
if (startsWith($username,";")) {
    $username ="disabled";
}else{
    $username="enabled";
}
if (startsWith($mysql,";")) {
    $mysql ="disabled";
}else{
    $mysql="enabled";
}

if (startsWith($interclient,";")) {
$interclient="disabled";
}else{
$interclient="enabled";
}

if (startsWith($compression,";")) {
$compression="disabled";
}else{
$compression="enabled";
}
?>


<div class="container-sm">
<div class="jumbotron jumbotron-sm font-weight-light text-wrap " style="font-size:12px;">
<?php
/*var_dump($cipher)*/
/*var_dump($username);*/
/*var_dump($haystack);
var_dump($needle);
var_dump($compression);*/
?>
<div class="card">
    <div class="card-body">
			<form role="form" id="formfield" action="./changeconf.php">

				<div class="row">
					<div class="col-lg-5">
					  <b>Protocol (<?=$proto?>):</b>
					</div>
			  		<div class="col-lg-5">
					  <label>
                          <input type="radio" name="proto" value="tcp" id="proto"
                              <?php if ($proto == "tcp"){echo "checked";}?> class="mgc mgc-success mgc-sm">TCP</label>
					  <label class="radio-inline">
                          <input type="radio" name="proto" value="udp" id="proto"
                              <?php if ($proto == "udp"){echo "checked";}?> class="mgc mgc-success mgc-sm" />
                          UDP
                      </label>

					</div>

				</div>

			  <div class="row">
					<div class="col-lg-5">
					  <b>Port (<?=$port?>):</b>
					</div>
			  		<div class="col-lg-5">
                        <input type="text"  name="port" value="<?=$port?>" id="port" />
					</div>

				</div><br>

 			  <div class="row">
					<div class="col-lg-5">
					  <b>Transit network (<?=$serverNetArr[0]?>/<?=$serverNetArr[1]?>):</b>
					</div>
			  		<div class="col-lg-6">
						<input type="text"  id="transnet" name="TransSubnet" value="<?=$serverNetArr[0]?>" >
						<input type="text"  id="transmask" name="TransNetmask" value="<?=$serverNetArr[1]?>" >

					</div>

				</div>

				<div class="row">
					<div class="col-lg-5">
					  <b>Cipher (<?=$cipher?>):</b>
					</div>
			  		<div class="col-lg-6">
					  <label class="radio-inline"><input id="cipher" type="radio" name="cipher" value="DES-EDE3-CBC" <?php if ($cipher === "DES-EDE3-CBC"){echo "checked";}?>>3DES</label>
					  <label class="radio-inline"><input id="cipher" type="radio" name="cipher" value="BF-CBC" <?php if ($cipher === "BF-CBC"){echo "checked";}?>>Blowfish</label>
					  <label class="radio-inline"><input id="cipher" type="radio" name="cipher" value="AES-128-CBC" <?php if ($cipher === "AES-128-CBC"){echo "checked";}?>>AES128</label>
					  <label class="radio-inline"><input id="cipher" type="radio" name="cipher" value="AES-256-CBC" <?php if ($cipher === "AES-256-CBC"){echo "checked";}?>>AES256</label>
					</div>

				</div>


				<div class="row">
					<div class="col-lg-5">
					  <b>Allow client-to-client communication (<?=$interclient?>):</b>
					</div>
			  		<div class="col-lg-5">
					  <label class="radio-inline"><input type="radio" id="interclient" name="interclient" value="1" <?php if ($interclient == "enabled"){echo "checked";}?>>enabled</label>
					  <label class="radio-inline"><input type="radio" id="interclient" name="interclient" value="0" <?php if ($interclient == "disabled"){echo "checked";}?>>disabled</label>
					</div>

				</div>

				<div class="row">
					<div class="col-lg-5">
					  <b>username as common (<?=$username?>):</b>
					</div>
			  		<div class="col-lg-5">
					  <label class="radio-inline"><input type="radio" name="username" id="username" value="1" <?php if ($username == "enabled"){echo "checked";}?>>enabled</label>
					  <label class="radio-inline"><input type="radio" name="username" id="username" value="0" <?php if ($username == "disabled"){echo "checked";}?>>disabled</label>
					</div>

				</div>

                <div class="row">
                    <div class="col-lg-5">
                        <b>plugin mysql auth(<?=$mysql?>):</b>
                    </div>
                    <div class="col-lg-5">
                        <label class="radio-inline"><input type="radio" name="mysql" id="mysql" value="1" <?php if ($mysql == "enabled"){echo "checked";}?>>enabled</label>
                        <label class="radio-inline"><input type="radio" name="mysql" id="mysql" value="0" <?php if ($mysql == "disabled"){echo "checked";}?>>disabled</label>
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-5">
                        <b>plugin otp auth(<?=$otp;?>):</b>
                    </div>
                    <div class="col-lg-5">
                        <label class="radio-inline"><input type="radio" name="otp" id="otp" value="1" <?php if ($otp == "enabled"){echo "checked";}?>>enabled</label>
                        <label class="radio-inline"><input type="radio" name="otp" id="otp" value="0" <?php if ($otp == "disabled"){echo "checked";}?>>disabled</label>
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-5">
                        <b>shell script<?=$script;?>):</b>
                    </div>
                    <div class="col-lg-5">
                        <label class="radio-inline"><input type="radio" name="script" id="script" value="1" <?php if ($script == "enabled"){echo "checked";}?>>enabled</label>
                        <label class="radio-inline"><input type="radio" name="script" id="script" value="0" <?php if ($script == "disabled"){echo "checked";}?>>disabled</label>
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-5">
                        <b>LZO compression (<?=$compression?>):</b>
                    </div>
                    <div class="col-lg-5">
                        <label class="radio-inline"><input type="radio" name="lzo" id="lzo" value="1" <?php if ($compression == "enabled"){echo "checked";}?>>enabled</label>
                        <label class="radio-inline"><input type="radio" name="lzo" id="lzo" value="0" <?php if ($compression == "disabled"){echo "checked";}?>>disabled</label>
                    </div>

                </div>

				<div class="row">
					<div class="col-lg-5">
					</div>
			  		<div class="col-lg-5">
					</div>
			  		<div class="col-lg-2">
						<input type="button" name="btn" value="Submit" id="submitBtn" data-toggle="modal" data-target="#confirm-submit" class="btn btn-success btn-sm" style="font-size: 8px;"/ >

					</div>
				</div><br>



			</form>




<div class="modal fade text-monospace" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="font-size: 10px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Are you sure you want to submit the following changes to the server configuration file?

                <!-- We display the details entered by the user here -->
                <table class="table">
                    <tr>
                        <th>Protocol</th>
                        <td id="prot"></td>
                    </tr>
                    <tr>
                        <th>Transit </th>
                        <td id="prt"></td>
                    </tr>
                    <tr>
                        <th>Transit Network</th>
                        <td id="transnt"></td>
                    </tr>
                    <tr>
                        <th>Transit Netmask</th>
                        <td id="transmsk"></td>
                    </tr>
                    <tr>
                        <th>Cipher</th>
                        <td id="ciph"></td>
                    </tr>
                    <tr>
                        <th>Allow communication between clients</th>
                        <td id="intercl"></td>
                    </tr>
                    <tr>
                        <th>username as comon</th>
                        <td id="user"></td>
                    </tr>
                    <tr>
                        <th>mysql</th>
                        <td id="mysq"></td>
                    </tr>
                    <tr>
                        <th>otp</th>
                        <td id="ot"></td>
                    </tr>
                    <tr>
                        <th>shell</th>
                        <td id="shel"></td>
                    </tr>
                    <tr>
                        <th>Enable LZO compression</th>
                        <td id="clzo"></td>
                    </tr>

                </table>

            </div>

  <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" style="font-size: 8px;">Cancel</button>
            <a href="#" id="submit" class="btn btn-success btn-sm" style="font-size: 8px;">Submit</a>
        </div>
    </div>
</div>
</div>

			<script>
			$('#submitBtn').click(function() {
				 $('#prot').text(document.querySelector('input[name="proto"]:checked').value);
				 $('#prt').text($('#port').val());
				 $('#ciph').text(document.querySelector('input[name="cipher"]:checked').value);
				 $('#transnt').text($('#transnet').val());
				 $('#transmsk').text($('#transmask').val());
				 $('#intercl').text(document.querySelector('input[name="interclient"]:checked').value);
                 $('#user').text(document.querySelector('input[name="username"]:checked').value);
                 $('#mysq').text(document.querySelector('input[name="mysql"]:checked').value);
                 $('#ot').text(document.querySelector('input[name="otp"]:checked').value);
                 $('#shel').text(document.querySelector('input[name="script"]:checked').value);
				 $('#clzo').text(document.querySelector('input[name="lzo"]:checked').value);

			});

			$('#submit').click(function(){

				$('#formfield').submit();
			});
			</script>

    </div>
</div>
	</div>
</div>

    <?php include './footer.php'; ?>



