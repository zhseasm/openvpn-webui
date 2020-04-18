setInterval(function () {

    $.ajax({
        url: "./status.php?time=true",
        data: "data",
        async:'true',
        dataType:"json",
        success:function(data,status) {
           // console.log(data);
            $("#normaltime").text(data.hostname+" "+data.date);

          //  $("#copysecret").load(location.href + " #copysecret");
        },
        error:function(jqxhr,textStatus,error){
            console.log("__失败__");
            console.log(error);
            console.log(textStatus);
            console.log(jqxhr);
            console.log("******");}
    });
},1000)

setInterval(function () {
    $("#secret").load(location.href + " #secret");
},30000)