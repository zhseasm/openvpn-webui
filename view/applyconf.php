
<?php
$confname = $_GET['confname'];
 ?>
<meta http-equiv="refresh" content="8;url=./restoreconf.php" />



<div class="container-sm">
    <div class="jumbotron jumbotron-sm font-weight-light text-wrap" style="font-size:12px;">
        <div class="row">
            <div class="col-sm-12 text-sm-center text-monospace">

                <div class="card">
                    <div class="col-md-12 text-center text-success">


            <?php

            $result=shell_exec("sudo bash /var/www/html/admin/applyconf.sh -c $confname");
            echo "<pre>".$result." Starting cleanup of restore folder in 5 seconds.</pre>";
            ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>