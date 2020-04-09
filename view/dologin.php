<?php include './header.php' ?>
    <div class="container-sm">
    <div class="jumbotron jumbotron-sm " style="font-size:12px;">
    <div class="container-sm">
    <div class="row">
    <div class="col-sm-12">
    <div class="card">
    <div class="card-body">

<form method="post" action="login.php">
    <span>
        <input type="text" class=" form-control" placeholder="用户名" name="username"><br><br>
    </span>
    <span>
        <input type="password" class="form-control" placeholder="密码" id="password"><br><br>
    </span>
    <span>
        <input type="text" placeholder="验证码" name="verifycode" class="captcha form-control"><br><br>
    </span>
    <!--<img id="captcha_img" src="captcha1.php?r=<?php /*echo rand();*/?>" alt="验证码">-->
    <img id="captcha_img" src="captcha.php?r=<?php echo rand();?>" alt="验证码">
    <!--<img id="googleqr_img" src="googleqr.php" alt="qr">-->
    <span class="badge-info badge badge-sm">
                                        <a href="javascript:void(0)" class="badge badge-info badge-sm" rel="external nofollow" onclick="document.getElementById('captcha_img').src='captcha.php?r='+Math.random()">换一个</a>
                            </span>
    <!--<label><a href="javascript:void(0)"  class="badge badge-success badge-sm" rel="external nofollow" onclick="document.getElementById('googleqr_img').src='googleqr.php?r='+Math.random()">换一个</a> </label>-->

    <span class="badge badge-info badge-sm">
                                 <input type="checkbox" class="mgc-info mgc mgc-sm" name="autologin[]" value="1"/>自动登录
    <button type="submit" class="btn btn-info btn-sm" onclick="document.getElementById('password').setAttribute('name','password');" style="font-size: 12px;">登录</button>

                                </span>

</form>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
<?php include './footer.php' ?>