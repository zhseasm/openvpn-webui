$(document).ready(function() {
    $("#old_psd").blur(function () {
        var old_psd = $("#old_psd").val();
        if(old_psd == ""){
         //alert('aaa');
         $("#old_psd").attr("placeholder","您输入的原始密码为空!");
        //return false;
        }
        else if(old_psd.length<4)
        {
         alert('密钥长度大于等于4');
            //$("#old_psd").attr("placeholder","您输入的原始密码为空!");
            $("#old_psd").val("");
            return false;
        }
        else
                {
                 $.ajax({
                     async:"false",
                     url:"old_passwd.php",
                     type:"POST",
                     dataType:"text",
                     data:{old_psd:old_psd},
                     success:function (data) {
                      console.log(data);
                         if(data.trim()==0)
                         {
                             $("#submit").click(function () {
                                 var new_pass1=$("#newpass1").val();
                                 var new_pass2=$("#newpass2").val();
                                 if(new_pass1.length<4)
                                 {
                                     alert("密码长度不小于4");
                                     $("#newpass1").val("");
                                     $("#newpass2").val("");
                                     return false;
                                 }
                                 else
                                 {
                                     if (new_pass1 == "" ||newpass2 == "")
                                     {
                                         /// alert(new_pass1);
                                         alert("为空");
                                         return false;

                                     }
                                     else if(new_pass1 != new_pass2)
                                     {
                                         alert("新密码不一致");
                                         return false;
                                     }
                                     else
                                     {
                                         alert("修改成功");
                                         return true;
                                     }
                                 }

                             })
                            // $("#old_psd").attr("placeholder","不符合!");
                           // alert('密码符合');
                            // return true;
                         }
                         else{
                             alert('密码不符合');
                             $("#old_psd").val("");
                             return false;
                         }
                     },
                 }
                )

                }
    }

    )




}

);