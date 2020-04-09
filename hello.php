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
$out = shell_exec('ls');
echo "<pre>$out</pre>";
?>

<form action="hello.php" method="post">
    <p>姓名: <input type="text" name="name" /></p>
    <p>年龄: <input type="text" name="age" /></p>
    <p><input type="submit" /></p>
</form>
你好，<?php echo htmlspecialchars($_POST['name']); ?>。
你 <?php echo (int)$_POST['age']; ?> 岁了。
