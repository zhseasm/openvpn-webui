<?php include './header.php';
include './checkPermission.php';
?>

<div class="container-sm">
    <div class="jumbotron jumbotron-sm font-weight-light text-wrap" style="font-size:12px;">
        <div class="row">
            <div class="col-sm-12 text-sm-center text-monospace">
                <div class="card">
                    <div class="card-body">
                        <code style="font-size: 18px;" class="text-info">
                            <b>V</b> is valid, <b>R</b> is revoked
                        </code>
                        <div>
                        <span>
                            <a href="javascript:history.go(-1)" class="badge badge-info badge-sm">
                                back
                            </a>
                        </span>
                            <span>
                                <a href="javascript:window.location.reload(true)" class="badge badge-info badge-sm">flush</a>
                            </span>
                        </div>
                        <hr/>
                        <span>
                        <code>
                        <?php
                        $ca=shell_exec('sudo bash /var/www/html/admin/showca.sh');
                     /*   $ca = array();*/
                        $ca=nl2br($ca);
                        echo $ca;
                        ?>
                        </code>
                        </span>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
<?php include  './footer.php';?>