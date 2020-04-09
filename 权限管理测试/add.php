<?php
require "DBDA.class.php";
$db = new DBDA();
$uid = $_POST["uid"];
$js = $_POST["js"];

//清空原有角色
$sql = "delete from userinjuese where userid='{$uid}'";
$db->query($sql);

//添加选中的角色
$ajs = explode(",",$js);

foreach($ajs as $v)
{
    $sql = "insert into userinjuese values('','{$uid}','{$v}')";
    $db->query($sql);
}