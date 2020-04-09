<?php include './header.php';?>
<?php
$result=shell_exec('rm /var/www/html/restore/*');
?>

<div class="container-sm">
    <div class="jumbotron jumbotron-sm font-weight-light text-wrap" style="font-size:12px;">
        <div class="row">
            <div class="col-sm-12 text-sm-center text-monospace">

                <div class="card">

                    <div class="col-md-12 text-center text-success">


    <meta http-equiv="refresh" content="3;url=./restoreconf.php" />

Cleanup finished. You will be redirected to the upload page now.<pre><?php echo $result; ?>


</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include './footer.php'?>