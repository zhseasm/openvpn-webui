<?php
$users= array();
exec('/usr/bin/ls /etc/openvpn/client/keys/', $users);
?>

<?php include './header.php';
include './checkPermission.php';
?>
<div class="container-sm">
    <div class="jumbotron jumbotron-sm font-weight-light text-wrap" style="font-size:12px;">
        <div class="row">
            <div class="col-sm-12 text-sm-center">

            <div class="card">
                <div class="card-body text-monospace">
                    <button type="button" class="btn btn-sm btn-success" disabled>green is connected</button>
                    <button type="button" class="btn btn-sm btn-danger" disabled>red is offline</button>

                   <!-- <div class="dropdown" style="font-size: 2px;">
                        <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Show peer details
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <?php /*foreach ($users as &$user){
                                echo '<li class="text-info"><a href="/admin/vpnusers/userdetails?username='.$user.'">';
                                echo $user;
                                echo '</a></li>';
                            }*/?>

                        </ul>
                        <a class="btn btn-sm dropdown-toggle" role="button" id="dropdownMenu1" href="/admin/vpnusers/adduser">Add new peer</a>
                    </div>-->

                    <?php foreach ($users as &$user)
                    {
                        $result=exec('cat /var/log/openvpn/status.log | grep ' . $user);
                        if ($result){
                            echo "<div class='text-success' role='alert'>";
                            echo  "<span class='badge-success badge-sm badge badge-pill'>".$user.'</span>';
                            echo "<span>";
                            echo "<a class='badge badge-success' href='./userdetail.php?username=".$user."' role='button'>details</a>";
                            echo "</span>";
                            echo "</div>";
                        }
                        else
                        {
                            echo "<div class='text-warning' role='alert'>";
                            echo "<span class='badge-danger badge-sm badge badge-pill' >".$user.'</span>';
                            echo "<span>";
                            echo "<a class='badge badge-warning' href='./userdetail.php?username=".$user."' role='button'>details</a>";
                            echo "</span>";
                            echo "</div>";
                        }
                    }

                    ?>
<hr/>

                    <span>
              <a class="badge badge-sm badge-info badge-pill" href="./adduser.php">Add User</a>
                    </span>
                    <span>
                        <a class="badge badge-sm badge-info badge-pill" href="./showca.php">clients</a>
                        <!--<button type="button" class="btn btn-sm btn-success" >Flush clients</button>-->
                    </span>

                    <span class="text-light text-monospace text-center">
                      <a class="badge badge-info" href="./user.php">刷新页面</a>
                     </span>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'?>
