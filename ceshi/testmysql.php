<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 2020/2/26
 * Time: 18:19
 */

require_once "mysql.php";
$conn=new Mysql();
$sql="select * from user";
//执行查询并获取查询结果
$result=$conn->sql($sql);
//输出受影响数据行数
$num=$conn->getResultNum($sql);
echo "影响的行数：".$num;
//读取并输出记录
while ($row = mysqli_fetch_assoc($result))
{
    echo "{$row['name']}";
    echo "{$row['password']}";
}
//关闭数据库
$conn->close();
?>