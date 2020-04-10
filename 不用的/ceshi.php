<?php
//way1
$file=fopen('文件地址',"r");

header("Content-Type: application/octet-stream");

header("Accept-Ranges: bytes");

header("Accept-Length: ".filesize('文件地址'));

header("Content-Disposition: attachment; filename=文件名称");

echo fread($file,filesize('文件地址'));

fclose($file);


//way2;
echo "<a href='/html/download/kali.zip'>kali.zip</a>";

//way3;
$filename = 'demo.zip'; //获取文件名称
$dir ="down/";  //相对于网站根目录的下载目录路径
$down_host = $_SERVER['HTTP_HOST'].'/'; //当前域名


//判断如果文件存在,则跳转到下载路径
if(file_exists(__DIR__.'/'.$dir.$filename)){
    header('location:http://'.$down_host.$dir.$filename); //拼接下载文件的绝对路径如：http://demo.xx.cn/down/demo.zip
}else{
    header('HTTP/1.1 404 Not Found'); //这个文件不存在
}

//way4;
$file_name = "demo";
$file_name = "demo.zip";     //下载文件名
$file_dir = "./down/";        //下载文件存放目录
//检查文件是否存在
if (! file_exists ( $file_dir . $file_name )) {
    header('HTTP/1.1 404 NOT FOUND');
} else {
//以只读和二进制模式打开文件
$file = fopen ( $file_dir . $file_name, "rb" );

//告诉浏览器这是一个文件流格式的文件
Header ( "Content-type: application/octet-stream" );
//请求范围的度量单位
Header ( "Accept-Ranges: bytes" );
//Content-Length是指定包含于请求或响应中数据的字节长度
Header ( "Accept-Length: " . filesize ( $file_dir . $file_name ) );
//用来告诉浏览器，文件是可以当做附件被下载，下载后的文件名称为$file_name该变量的值。
Header ( "Content-Disposition: attachment; filename=" . $file_name );

//读取文件内容并直接输出到浏览器
echo fread ( $file, filesize ( $file_dir . $file_name ) );
fclose ( $file ); //打开的时候要进行关闭这个文件
exit ();


//way5;
//浏览器对于可识别的文件格式(html、txt、png、jpg等)，默认是直接打开的，对于无法识别的文件，才作为附件来下载。为了可以让可识别的文件也直接可以下载，需要进行如下设置：

//<a title="点击下载" href="down.php?name=01.jpg&type=image/jpeg"><img src="01.jpg"></a>

//1. 读取文件

$fliename=$_GET["name"];
$filetype=$_GET["type"];

//2. 文件的描述信息 Content-Disposition（内容配置）指定为attachment(附件)(必须)

header("Content-Disposition:attachment;filename={$filename}");

//3. 指定被下载文件的类型(非必须)

header("Content-Type:{$filetype}");

//4. 指定被下载文件大小（非必须）

header("Content-Length:".filesize($filename));

//5. 将内容读入内存缓冲区

readfile($filename);

//注意：在 readfile($filename) 之前，不能有任何输出语句（错误信息、var_dump调试语句，echo输出等）,否则下载的文件会出错。



//way6;

$file_name = "down";$file_name = "down.zip";     //下载文件名    $file_dir = "./down/";        //下载文件存放目录    //检查文件是否存在    if (! file_exists ( $file_dir . $file_name )) {

    header('HTTP/1.1 404 NOT FOUND');

} else {

    //以只读和二进制模式打开文件

    $file = fopen ( $file_dir . $file_name, "rb" );



    //告诉浏览器这是一个文件流格式的文件

    Header ( "Content-type: application/octet-stream" );

    //请求范围的度量单位

    Header ( "Accept-Ranges: bytes" );

    //Content-Length是指定包含于请求或响应中数据的字节长度

    Header ( "Accept-Length: " . filesize ( $file_dir . $file_name ) );

    //用来告诉浏览器，文件是可以当做附件被下载，下载后的文件名称为$file_name该变量的值。

    Header ( "Content-Disposition: attachment; filename=" . $file_name );



    //读取文件内容并直接输出到浏览器

    echo fread ( $file, filesize ( $file_dir . $file_name ) );

    fclose ( $file );

    exit ();

}

https://www.jb51.net/article/107165.htm


?>





