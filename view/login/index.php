<?php
session_start();
$sessionid=session_id();
echo $sessionid;
if(empty($_COOKIE['username'])&&empty($_COOKIE['password'])){
    if(isset($_SESSION['username']))
        echo "登录成功，欢迎您".$_SESSION['username']. "<a href='logout.php'>退出登录</a>";
    else
        echo "你还没有登录，<a href='../dologin.php'>请登录</a>";
}
else
    echo "登录成功，欢迎您：".$_COOKIE['username']. "<a href='logout.php'>退出登录</a>";
