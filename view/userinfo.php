<?php
$users= array();
exec('/usr/bin/ls /etc/openvpn/client/keys/', $users);
/*var_dump($users);*/
foreach ($users as &$user){
    $result=exec('cat /var/log/openvpn/status.log | grep ' . $user);
    /*  var_dump($result);*/
    if ($result){
        echo "<div class='text-success' role='alert'>";
        echo  "<span class='badge-success badge-sm badge badge-pill'>".$user.'</span>';
        echo "<span>";
        echo "<a class='badge badge-success' href='./userdetail.php?username=".$user."' role='button'>details</a>";
        echo "</span>";
        echo "</div>";
    }
}
?>