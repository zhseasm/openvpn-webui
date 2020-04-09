<?php
/*var_dump($_GET['name']);*/
$name=$_GET['name'];
$server=$_SERVER['SERVER_ADDR'];
/*var_dump($server);*/
shell_exec("sudo bash /var/www/html/admin/updateclientconf.sh -c $name -s $server");
echo "<meta http-equiv=\"refresh\" content=\"0;url=clientconf.php\">";
?>