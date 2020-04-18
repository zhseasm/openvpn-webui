<?php include './header.php';
include "./checkPermission.php";
?>
<div class="container-sm">
    <div class="jumbotron jumbotron-sm font-weight-light text-wrap" style="font-size:12px;">
        <div class="row">
            <div class="col-sm-12 text-sm-center text-monospace">

                <div class="card">

                <div class="col-md-12 text-center text-success">


            <?php
            shell_exec('sudo bash /var/html/admin/upload.sh');
            $success = 0;
            $target_dir = "/var/www/html/restore/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                /*    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                    if($check !== false) {
                        echo "File is an image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                    } else {
                        echo "File is not an image.";
                        $uploadOk = 0;
                    }*/
            }
            // Check if file already exists
            if (file_exists($target_file)) {
                echo "File already exists. ";
                echo shell_exec('ls /var/www/html/restore');
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                echo "<hr />";
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" && $imageFileType != "conf" ) {
                echo "Sorry, only configuration files are allowed. ";
                echo "<hr />";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {

                echo "Pattern mismatch. File was not uploaded. ";
                // if everything is ok, try to upload file
                echo "<a class='badge-info badge-sm badge' href='./cleanconf.php'>清空备份目录</a>";
                echo "<hr />";
                $copyresult = shell_exec('cat '.$target_file);
                echo "<pre class='text-left'>".$copyresult."</pre><hr />";
                echo '<p><a class="badge badge-primary btn-sm" href="javascript:history.go(-1)" role="button">Cancel</a><tab>';
                echo'<a class="badge badge-sm badge-success" style="margin-left: 6px !IMPORTANT;" href="/var/html/admin/applyconf?confname='.basename( $_FILES["fileToUpload"]["name"]).'" role="button">Apply</a></p>';
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    echo "The file \"". basename( $_FILES["fileToUpload"]["name"]). "\" has been uploaded successfully.";
                    $success = 1;
                } else {
                    echo "Sorry, there was an error uploading your file.";
                    echo "<hr />";
                }
            }

            if ($success)
            {
                echo "This is your uploaded backup file. Please examine it carefully before applying it to the live configuration.<br><br>";
                echo "<hr />";
                $copyresult = shell_exec('cat '.$target_file);
                echo "<pre class='text-left'>".$copyresult."</pre><hr />";
                echo '<p><a class="badge badge-primary btn-sm" href="javascript:history.go(-1)" role="button">Cancel</a><tab>';
                echo'<a class="badge badge-sm badge-success" style="margin-left: 6px !IMPORTANT;" href="./applyconf.php?confname='.basename( $_FILES["fileToUpload"]["name"]).'" role="button">Apply</a></p>';
            }

            ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include './footer.php';?>
