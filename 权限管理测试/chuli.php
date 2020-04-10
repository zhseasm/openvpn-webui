<?php
require"DBDA.class.php";
$db = new DBDA();
$uid = $_POST["uid"];
$sql = "select jueseid from userinjuese where userid='{$uid}'";
echo $db->strquery($sql);