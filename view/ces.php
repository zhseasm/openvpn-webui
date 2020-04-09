<?php
/* if($_GET[blastip] == 1 ) {
     $blastip = shell_exec('sed -n "14,22p" /var/www/html/admin/loginfo.sh |sudo bash');
     $blastip = nl2br($blastip);
     echo $blastip;
     echo $_GET($blastip);
 }
 else
 {
     echo 'aaa';
 }*/

/*$blastip = shell_exec('sed -n "21,32p" /var/www/html/admin/loginfo.sh |sudo bash');
$blastip = nl2br($blastip);
echo $blastip;
echo $_GET($blastip);*/
$qr=shell_exec('sudo bash /var/www/html/view/ceshi.sh');
echo $qr;
var_dump($qr);
$qr=nl2br($qr);
echo $qr;

?>
