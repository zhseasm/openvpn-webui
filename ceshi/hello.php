<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 2020/2/23
 * Time: 16:16
 */
//echo $_SERVER['HTTP_USER_AGENT'];
//echo "hello world";
//if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) {
//    echo '正在使用 Internet Explorer。<br />';}
$out = shell_exec('bash /var/www/html/helloa.sh');
echo "<pre>$out</pre>";
?>

<form action="hello.php" method="post">
    <p>国家: <input type="text" name="country"/></p>
    <p>省份: <input type="text" name="province"/></p>
    <p>城市: <input type="text" name="city"/></p>
    <p>组织: <input type="text" name="org" /></p>
    <p>邮箱: <input type="text" name="mail" /></p>
    <p>域名: <input type="text" name="cn" /></p>
    <p>vpn名称: <input type="text" name="name" /></p>
    <p>单位: <input type="text" name="ou" /></p>
    <p>CA根证书名称: <input type="text" name="common name" /></p>
    <p>服务端证书名称: <input type="text" name="server name" /></p>
    <p><input type="submit" /></p>
</form>
国家<?php echo htmlspecialchars($_POST['country']); ?> <br />
省份<?php echo htmlspecialchars($_POST['province']); ?><br />
城市<?php echo htmlspecialchars($_POST['city']); ?><br />
组织<?php echo htmlspecialchars($_POST['org']); ?><br />
邮箱<?php echo htmlspecialchars($_POST['mail']); ?><br />
域名<?php echo htmlspecialchars($_POST['cn']); ?><br />
vpn名称<?php echo htmlspecialchars($_POST['name']); ?><br />
单位<?php echo htmlspecialchars($_POST['ou']); ?><br />



