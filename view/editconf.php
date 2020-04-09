<?php include './header.php';
?>
<?php
$content=$_POST['content'];
$fileName='/etc/openvpn/server.conf';
$homepage = file_get_contents('/etc/openvpn/server.conf');
/*if ($content == null)
{
    echo "空数据";
    }
    else
    {*/
        file_put_contents($fileName,$content);
    //}

?>


<html>
<body>
<form action="editconf.php" method="post">
    <br><p><a class="btn btn-primary btn-lg" href="javascript:history.go(-1)" role="button">back</a><tab><a class="btn btn-primary btn-lg" style="margin-left: 12px !IMPORTANT;" href="javascript:window.location.reload(true)" role="button">reload current values</a></p><br>
    <input type="submit" />
    <input type="button" onclick="document.location='./editconf.php'" value="刷新页面" />
    <input type="button" value="清空配置" onclick="document.getElementById('content').value='';"/>
<textarea id="content" name="content" style="width:100%;height:100%;">
    <?php
    echo $homepage;
?>

</textarea>

</form>

<?php include './footer.php'; ?>
