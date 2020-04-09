setInterval(function () {

    $.ajax({
        url: "./status.php?ajax=true",
        data: "data",
        async: "false",
        dataType:"json",
        success:function(data,status) {
            //data=eval('('+data+')');
            //console.log("__成功__");
            //console.log(data);
           // console.log(status);
            // $("#time").append(data['time']);
            //console.log(data);
            $("#kernel").text(data.kernel);
            $("#who").text(data.who);
            $("#uptime").text(data.uptime);
            $("#ens33").text(data.ens33);
             $("#tun0").text(data.tun0);
            // alert($("#userinfo").html());
            //$("#meminfo").html("<span class=\"badge badge-pill badge-warning text-wrap\"></span>")
            $("#meminfo").text(data.meminfo);
            $("#cpuinfo").text(data.cpuinfo);
            $("#cpuprogress").attr("aria-valuenow",data.cpuused);
            $("#cpuprogress").attr("aria-valuemin","0");
            $("#cpuprogress").attr("aria-valuemax","100");
            $("#cpuprogress").attr("style","min-width:0em;"+"width:"+data.cpuprogress+"%");
            $("#cpuprogress").text(data.cpuprogress+"%");
            $("#memprogress").attr("aria-valuenow",data.memused);
            $("#memprogress").attr("aria-valuemin","0");
            $("#memprogress").attr("aria-valuenmax",data.mem);
            $("#memprogress").attr("style","min-width:0em;"+"width:"+data.memprogress+"%");
            $("#memprogress").text(data.memprogressall+"%");
//console.log(data.tun0);
//js,html方法
            $("#time").text(data.hostname +" "+ data.date);
            // switch (data.status) {
            //     case 'active':
            //           $("#status").html("<span class=\"badge badge-success badge\" id='status'>active</span>");
            //       break;
            //        case 'inactive':
            //           $("#status").html("<span class=\"badge badge-danger badge\" id='status'>dead</span>");
            //           break;
            //       case 'failed':
            //           $("#status").html("<span class=\"badge badge-warning badge\" id='status'>failed</span>");
            //          break;
            //      default:
        //}


        },
        error:function(jqxhr,textStatus,error){
            console.log("__失败__");
            console.log(error);
            console.log(textStatus);
            console.log(jqxhr);
            console.log("******");}
    });
},2000)
//setInterval(function () {
    //$("#meminfo").load(location.href + " #meminfo>*","");
  // $("#userinfo").load(location.href + " #userinfo>*","");
    //$("#netspeed").load(location.href + " #netspeed");
  //  $("#userinfo").load("index.php #userinfo");
//},3000)

setInterval(function () {
    $.ajax({
        url:'./userinfo.php',
        dataType: 'text',
        success:function (data) {
          $("#userinfo").html(data);
        }
    })
},2000)





