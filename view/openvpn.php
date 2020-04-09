<?php
include './header.php';
echo "<meta http-equiv=\"Refresh\" content=\"1;url=./index.php\" />";
switch ($_GET[xh]) {
    case '0';
        /*system('/var/www/html/admin/stopvpn', $retval);*/
       $result=shell_exec('sudo bash /var/www/html/admin/stop.sh');
        break;
    case '1';
        /*system('/var/www/html/admin/restartvpn', $retval);*/
        $result= shell_exec('sudo bash /var/www/html/admin/start.sh');
        break;
    case '2';
        /*system('/var/www/html/admin/reboot', $retval);*/
        $result=shell_exec('sudo bash /var/www/html/admin/restart.sh');
        break;
    default:
}
?>
    <div class="container-sm">
        <div class="jumbotron jumbotron-sm " style="font-size:12px;">
            <div class="container-sm">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <?php echo $result; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
include './footer.php';
?>