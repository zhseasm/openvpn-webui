<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 2020/3/10
 * Time: 11:51
 */

$servername = "localhost";
$username = "vpn";
$password = "vpn123";

try {
    $conn = new PDO("mysql:host=$servername;", $username, $password);
    echo "连接成功";
}
catch(PDOException $e)
{
    echo $e->getMessage();
}

?>

<?php
$servername = "localhost";
$username = "vpn";
$password = "vpn123";

// 创建连接
$conn = new mysqli($servername, $username, $password);

// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
echo "连接成功";
?>

<?php
$servername = "localhost";
$username = "vpn";
$password = "vpn123";
//创建连接
$conn = mysqli_connect($servername, $username, $password);

// 检测连接
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "连接成功";

?>