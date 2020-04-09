<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <style type="text/css">
        .list{ width:100px;
            height:35px;
            border:1px solid #36F;
            margin:0px 2px 0px 2px;
            text-align:center;
            vertical-align:middle;
            line-height:35px;}
    </style>
</head>

<body>
<h1>主页面</h1>
<?php
session_start();
$uid ="";
if(empty($_SESSION["uid"]))<code class="php comments">  //判断session是否为空</code>
{
    header("location:login.php");<code class="php comments">//空的话就返回登录页面</code>
exit;
}

$uid = $_SESSION["uid"];

require"DBDA.class.php";
$db = new DBDA();
$sql = "select * from rules where code in(select distinct ruleid from juesewithrules where jueseid in(select jueseid from userinjuese where userid='{$uid}'))";

$arr = $db->query($sql,1);
foreach($arr as $v)
{
    echo "<div code='{$v[0]}' class='list'>{$v[1]}</div>";
}

?>
</body>
</html>