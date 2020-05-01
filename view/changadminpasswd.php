<?php
include "./header.php";
include './checkPermission.php';
//var_dump($_SESSION);

?>
<script type="text/javascript" src="./js/changadminpasswd.js"></script>

<div class="container-sm">
    <div class="jumbotron jumbotron-sm " style="font-size:12px;">
        <div class="container-sm">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">

                            <form action="changadminpwd.php" method="post" >
                                <p>
                                <input type="password" name="old_psd" placeholder="请输入原密码" class="form-control" id="old_psd">
                                    <br>

                                    <input type="password" name="new_psd1" id="newpass1" placeholder="请输入新密码" class="form-control">
                                    <br>

                                    <input type="password" name="new_psd2"  id="newpass2" placeholder="请确认新密码" class="form-control">
                                    <br>
                                </p>

                                <button type="submit" name="submit" class="btn btn-sm btn-info" id="submit">提交</button>
                                <a href="javascript:history.back(-1);" class="btn btn-sm btn-info"/>返回</a>
                                <a href="javascript:changepass();" class="btn btn-sm btn-info" id="changepass"/>显示密码</a>
                          <!--  <a href="#" onClick="javascript:history.back(-1);">返回上一页</a><a href="#" onClick="javascript:history.go(-1);">返回上一页</a>-->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function changepass() {
        //alert("aaa");
       var bt=$("#changepass").html();
      // alert (bt);
       if(bt == "显示密码"){

           $("input").prop("type","text");
           $("#changepass").html("隐藏密码")
       }
       else
       {
           $("input").prop("type","password");
           $("#changepass").html("显示密码")
       }

    }
</script>
<?php
include "./footer.php";
?>
