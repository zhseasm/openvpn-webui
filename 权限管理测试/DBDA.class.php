<?php
class DBDA
{
    public $host = "localhost";                //将连接的四要素定义为成员属性
    public $uid = "root";
    public $pwd = "123";
    public $dbname = "mydb";

    //执行SQL语句返回相应的结果
    //$sql 要执行的SQL语句
    //$type 代表SQL语句的类型，0代表增删改 1代表查询
    function query($sql,$type=1)    //方法的命名也遵循驼峰命名法，第一个单词的首字母小写，往后的每个单词的首字母大写，和类命名有一点点区别
    {
        $db = new MySQLi($this->host,$this->uid,$this->pwd,$this->dbname);

        $result = $db->query($sql);

        if($type)
        {
            //如果是查询，返回数据
            return $result->fetch_all();// 这里抓取了all，会返回一个二维数组，也可以抓取row（），返回的是一维数组
        }
        else
        {
            //如果是增删改，返回true或false
            return $result;
        }
    }
}
?>