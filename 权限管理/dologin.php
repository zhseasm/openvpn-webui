<?php
header("Content-type:text/html;charset=UTF-8");
require "mysql.php";      //导入mysql.php访问数据库
session_start();        //开启会话一获取到服务器端验证码
$username=$_POST['username'];
$password=$_POST['password'];
$autologin=isset($_POST['autologin'])?1:0;   //获取是否选择了自动登录
$verifycode=$_POST['verifycode'];
$code=$_SESSION['code'];    //获取服务器生成的验证码
echo $code;
/*
 * 首先进行判空操作，通过后进行验证码验证，通过后再进行数据库验证。
 * 手机号码和邮箱验证可根据需要自行添加
 * */
if(checkEmpty($username,$password,$verifycode)){
    if(checkVerifycode($verifycode,$code)){
        if(checkUser($username,$password)){
            $_SESSION['username']=$username; //保存此时登录成功的用户名
            if($autologin==1){        //如果用户勾选了自动登录就把用户名和加了密的密码放到cookie里面
                setcookie("username",$username,time()+3600*24*3);  //有效期设置为3天
                setcookie("password",md5($password),time()+3600*24*3);
            }
            else{
                setcookie("username","",time()-1);  //如果没有选择自动登录就清空cookie
                setcookie("password","",time()-1);
            }
            header("location: rbacindex.php ");      //全部验证都通过之后跳转到首页
        }
    }
}
//方法：判断是否为空
function checkEmpty($username,$password,$verifycode){
    if($username==null||$password==null){
      /*  echo '<html><head><Script Language="JavaScript">alert("用户名或密码为空");</Script></head></html>' . "<meta http-equiv=\"refresh\" content=\"0;url=dologin.php\">";*/
    }
    else{
        if($verifycode==null){
            /*echo '<html><head><Script Language="JavaScript">alert("验证码为空");</Script></head></html>' . "<meta http-equiv=\"refresh\" content=\"0;url=dologin.php\">";*/
        }
        else{
            return true;
        }
    }
}
//方法：检查验证码是否正确
function checkVerifycode($verifycode,$code){
    if($verifycode==$code){
        return true;
    }
    else{
      /*  echo '<html><head><Script Language="JavaScript">alert("验证码错误");</Script></head></html>' . "<meta http-equiv=\"refresh\" content=\"0;url=dologin.php\">";*/
    }
}
//方法：查询用户是否在数据库中
function checkUser($username,$password){
    $conn=new Mysql();
    $sql="select * from user where name='{$username}' and password='{$password}';";
    $result=$conn->sql($sql);
    if($result){
        return true;
    }
    else{
       /* echo '<html><head><Script Language="JavaScript">alert("用户不存在");</Script></head></html>' . "<meta http-equiv=\"refresh\" content=\"0;url=dologin.php\">";*/
    }
    $conn->close();
}
//方法：手机格式验证
function checkPhoneNum($phonenumber){
    $preg="/^1[34578]{1}\d{9}$/";
    if(preg_match($preg,$phonenumber)){
        return ture; //验证通过
    }else{
        echo '<html><head><Script Language="JavaScript">alert("手机号码格式有误");</Script></head></html>' . "<meta http-equiv=\"refresh\" content=\"0;url=dologin.php\">";//手机号码格式不对
    }
}
//方法：邮箱格式验证
function checkEmail($email){
    $preg = '/^(\w{1,25})@(\w{1,16})(\.(\w{1,4})){1,3}$/';
    if(preg_match($preg, $email)){
        return true;
    }else{
        echo '<html><head><Script Language="JavaScript">alert("y邮箱格式有误");</Script></head></html>' . "<meta http-equiv=\"refresh\" content=\"0;url=dologin.php\">";
    }
}

