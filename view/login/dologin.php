<?php include '../header.php' ?>
<form method="post" action="login/login.php">
    用户名：<input type="text" placeholder="用户名" name="username"><br><br>
    密码：<input type="password" placeholder="密码" id="password"><br><br>
    验证码：<input type="text" placeholder="验证码" name="verifycode" class="captcha"><br><br>
    <!--<img id="captcha_img" src="captcha1.php?r=<?php echo rand();?>" alt="验证码">-->
    <img id="captcha_img" src="captcha.php?r=<?php echo rand();?>" alt="验证码">
        <label><a href="javascript:void(0)" rel="external nofollow" onclick="document.getElementById('captcha_img').src='captcha.php?r='+Math.random()">换一个</a> </label><br>
    <label><input type="checkbox" name="autologin[]" value="1"/>自动登录</label><br>
    <button type="submit" onclick="document.getElementById('password').setAttribute('name','password');">登录</button>
</form>
<?php include '../footer.php' ?>