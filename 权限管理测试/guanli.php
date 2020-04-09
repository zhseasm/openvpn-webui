<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <script src="https://code.jquery.com/jquery-3.2.0.min.js"></script>
</head>

<body>
<h1>用户角色对应</h1>
<div>
    <select id="user">
        <?php
        require"DBDA.class.php";
        $db = new DBDA();
        $sql = "select * from users";
        $arr = $db->query($sql,1);
        foreach($arr as $v)
        {
            echo"<option value='{$v[0]}'>{$v[2]}</option>";
        }
        ?>
    </select>
</div>
<br/>
<div>请选择角色：
    <?php
    $sql = "select * from juese";
    $arr = $db->query($sql,1);
    foreach($arr as $v)
    {
        echo "<input type='checkbox' class='ck' value='{$v[0]}'/>{$v[1]}";
    }
    ?>
</div>
<br/>
<input type="button" value="保存" id="baocun" />

</body>
<script type="text/javascript">

    Xuan();

    $("#user").change(function(){
        Xuan();
    })
    $("#baocun").click(function(){
        var uid = $("#user").val();
        var str = "";
        var ck = $(".ck");
        for(var i=0;i<ck.length;i++)
        {
            if(ck.eq(i).prop("checked"))
            {
                str = str + ck.eq(i).val()+",";
            }
        }

        str = str.substr(0,str.length-1);

        $.ajax({
            url:"add.php",
            data:{uid:uid,js:str},
            type:"POST",
            dataType:"TEXT",
            success: function(data){
                alert("保存成功！");
            }
        })
    })

    function Xuan()
    {
        var uid = $("#user").val();
        $.ajax({
            url:"chuli.php",
            data:{uid:uid},
            type:"POST",
            dataType:"TEXT",
            success: function(data){
                var js = data.trim().split("|");
                var ck = $(".ck");
                ck.prop("checked",false);
                for(var i=0;i<ck.length;i++)
                {
                    var v = ck.eq(i).val();
                    if(js.indexOf(v)>=0)
                    {
                        ck.eq(i).prop("checked",true);
                    }
                }
            }

        })
    }
</script>
</html>