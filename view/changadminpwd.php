<?php
session_start();
//var_dump($_SESSION);
$username=$_SESSION['username'];
//var_dump($_POST['new_psd2']);
$psd=$_POST['new_psd2'];
$mysqli = new mysqli("localhost", "root", "toor", "rbac");
$flag=$mysqli->query("update rbac.user set passwd=password('{$psd}')  where user_name='{$username}'");
//$update = $flag->fetch_assoc();
echo "<meta http-equiv=\"refresh\" content=\"0;url=changadminpasswd.php\" />";
//echo 'done';
?>