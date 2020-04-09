<?php include './header.php';
include './checkPermission.php';
?>
    <div class="container-sm">
        <div class="jumbotron jumbotron-sm font-weight-light text-wrap" style="font-size:12px;">
            <div class="row">
                <div class="col-sm-12 text-sm-center text-monospace">

                    <div class="card">

                <div class='well'>
                    <form action="upload.php" method="post" enctype="multipart/form-data">
                        <b>Select backup file to restore the configuration from:</b><br><br>
                        <input type="file" name="fileToUpload" id="fileToUpload"><br><br>
                        <input type="submit" class="btn btn-sm btn-info" value="Restore" name="submit">
                    </form>

                    <br>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include './footer.php';?>