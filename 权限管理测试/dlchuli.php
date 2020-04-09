<?php
session_start();


require "DBDA.class.php";
$db = new DBDA();
$uid = $_POST["uid"];
$pwd = $_POST["pwd"];
$sql = "select pwd from users where uid='{$uid}'";
$mm = $db->strquery($sql);
if($mm==$pwd && !empty($pwd))
{
    $_SESSION["uid"] = $uid;
    header("location:main.php");
}
else
{
    echo"输入的用户名或密码有误！";
}