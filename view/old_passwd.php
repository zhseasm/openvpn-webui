<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 2020/5/1
 * Time: 10:57
 */
//$username="admin";
//include 'checkPermission.php';
session_start();

$username=$_SESSION['username'];
$mysqli = new mysqli("localhost", "root", "toor", "rbac");
$flag=$mysqli->query("select password('{$_POST['old_psd']}')");
$old_psd = $flag->fetch_assoc();
$old_psd=implode(".",$old_psd);
//ar_dump($old_psd);
$mysqli = new mysqli("localhost", "root", "toor", "rbac");
$flag=$mysqli->query("select passwd from user where user_name='{$username}'");
$row = $flag->fetch_assoc();
$row=implode(".",$row);
//var_dump($row);
if(!empty($_POST['old_psd']))
{
    if($old_psd==$row){
        echo 0;
    }
    else
    {
    echo 1;

    }
}
?>
