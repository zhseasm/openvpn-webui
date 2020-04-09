<?php
session_start();
require 'ceshi.php';  //先把类包含进来，实际路径根据实际情况进行修改。
$vcode = new YL_Security_Secoder();      //实例化一个对象
$vcode->entry();
?>