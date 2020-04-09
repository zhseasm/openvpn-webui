<?php
//$hostname =shell_exec("hostname");
//$date = shell_exec('date "+%A %d %b %Y %T"') ;
echo "<div class=\"container-sm \" style=\"font-size: 16px;\">";
echo "<span class=\"badge-info badge float-right text-monospace text-wrap\">";
//echo $hostname.$date;
echo "<span id='normaltime'></span>";
if(empty($_COOKIE['username'])&&empty($_COOKIE['password'])){
    if(isset($_SESSION['username']))
    {
        echo "当前用户:";
        echo $_SESSION['username'];
        echo "<a class='badge badge-info badge-sm' href='./normallogout.php'>退出登录</a>";
    }
    else
        echo "你还没有登录，<a href='./normaldologin.php' class='badge badge-info badge-sm'>请登录</a>";
    /*echo "<meta http-equiv=\"refresh\" content=\"0;url=dologin.php\">";*/
}
else
    echo "登录成功，欢迎您：".$_COOKIE['username']. "<a href='normallogout.php' class='badge badge-info badge-sm'>退出登录</a>";
echo "</span>";
echo "</div>";
echo "</body>";
echo "</html>";

?>