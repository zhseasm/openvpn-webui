<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 2020/2/26
 * Time: 17:44
 */

session_start();
//退出登录并跳转到登录页面
unset($_SESSION['username']);
unset($_SESSION['password']);
//unset($_SESSION);
//echo $_SESSION['username'];
//echo $_SESSION['password'];
setcookie("username","",time()-1);  //清空cookie
setcookie("password","",time()-1);
session_destroy();
header("location: dologin.php ");
?>