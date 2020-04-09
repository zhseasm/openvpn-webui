<?php
//去掉了容易混淆的字符oOLl和数字01
//例子中只产生4个字符长度的字符串
$code_len = 4;
$width = 160;
$height = 60;
$type = "png";//图片类型
$font = "./assets/ttfs/t10.ttf";//字体文件，放在同目录下
/*$chars='ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';*/
$chars='0123456789';
$len = strlen($chars);
$chars = str_shuffle($chars);
$code = substr($chars,mt_rand(0,$len - $code_len),$code_len);//随机打乱，然后随机的截取连续的字符
isset($_SESSION) || session_start();
$_SESSION['code']=$code;

if ( $type!='gif' && function_exists('imagecreatetruecolor')) {
    $img = @imagecreatetruecolor($width,$height);
}else {
    $img = @imagecreate($width,$height);
}

$bg_color = imagecolorallocate($img, 255,255,255);//背景颜色
@imagefilledrectangle($img, 0, 0, $width - 1, $height - 1, $bg_color);//填充背景

$code_Color = imagecolorallocate($img,0,0,0);//字符颜色
//@imagestring($img, 5, 5, 3, $code, $code_color);
for($i=0;$i<$code_len;$i++){
    imagettftext($img,mt_rand(25,30),mt_rand(-45,45),30*$i+10,mt_rand(30,35),$code_Color,$font,substr($code,$i,1));
}

//画点
for($i=0;$i<100;$i++){
    imagesetpixel($img,mt_rand(0,$width),mt_rand(0,$height),$code_Color);
}
//画直线
for($i=0;$i<1;$i++){
    imageline($img,mt_rand(0,$width),mt_rand(0,$height),mt_rand(0,$width),mt_rand(0,$height),$code_Color);
}
function distort($img,$scale =8 ) {//8即为最大错开像素个数
    $w = imagesx($img);
    $h = imagesy($img);
    $new_w = $w + $scale * 2;
    $new_img = @imagecreatetruecolor($new_w, $h);
    $bg_color = imagecolorallocate($new_img, 255, 255, 255);
    @imagefilledrectangle($new_img, 0, 0, $new_w - 1, $h - 1, $bg_color);//新图片背景填充为白色

    $tmp = mt_rand();
    $f = 6.28 / $h;
    for ($i = 0; $i < $h; $i++) {
        $detaX = $scale * (1 + sin($i * $f  + $tmp));//计算每一行错开的像素
        for ($j = 0; $j < $w; $j++) {
            $rgb = imagecolorat($img, $j, $i);
            imagesetpixel($new_img, $j + $detaX, $i, $rgb);
        }
    }
    imagedestroy($img);
    return $new_img;
}

/*part_reverse($img,$rw = 50 ,$rh = 55,$border =1);*/
function part_reverse($img,$rw,$rh,$border)
{//rw:反色区域宽度，border：边界距离
    $w = imagesx($img) - $rw;
    $h = imagesy($img) - $rh;
    $x = mt_rand($border,$w - $border - 1);
    $y = mt_rand($border,$h - $border - 1);
    $tmp_img = @imagecreatetruecolor($rw, $rh);
    imagecopy($tmp_img,$img,0,0,$x,$y,$rw,$rh);
    imagefilter($tmp_img,IMG_FILTER_NEGATE);//这是个不错的函数，详见http://cn2.php.net/manual/zh/function.imagefilter.php
    imagecopy($img,$tmp_img,$x,$y,0,0,$rw,$rh);
    imagedestroy($tmp_img);
    return $img;
}


header("Content-type: image/".$type);//这样，浏览器就可以直接显示图片了

$image_func='Image'.$type;//颜色输出函数

$image_func($img);

imagedestroy($img);
?>
