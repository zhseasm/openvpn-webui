<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 2020/2/26
 * Time: 22:11
 */
$out=shell_exec("ls  /etc/openvpn/client/keys/");

$username=$_POST['username'];
$revokename=$_POST['revokename'];
shell_exec("sudo bash /var/www/html/add_user.sh $username");
shell_exec("sudo bash /var/www/html/revokeuser.sh $revokename");
    //echo $username;

    //echo $result;
echo $out;
echo '增加用户'.$username;
echo '删除用户'.$revokename;
?>
<html>
<?php
//echo "当前用户:";echo $out;
?>
<form action="showuser.php" method="post">
    <input name="username" id="username" />
    <input type="submit" value="增加用户"/>
    <input name="revokename" id="revokename" />
    <input type="submit" value="删除用户"/>

</form>
</html>
