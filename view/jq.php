<?php
include './header.php'
?>
<!--<script src="./jQuery/jquery.min.js"></script>-->
<script src="./js/echarts.min.js"></script>
<script>
//setInterval(function () {
     // $.getJSON("./echart.php?ajax=true",function (data) {
        // console.log(data);
        // console.log(data['page']);
         // $("#time").append(data['time']);
    //  })
//},2000)
setInterval(function () {
  $.ajax({
    url: "./echart.php?ajax=true",
    data: "data",
 dataType:"json",
      success:function(data,status){
          //data=eval('('+data+')');
          //console.log("__成功__");
          //console.log(data);
          //console.log(status);
         // $("#time").append(data['time']);
                  console.log(data);
                  var newDate = new Date();
                  newDate.setTime(parseInt(data.time) * 1000);

                  $("#time").text(newDate.format('hh:mm:ss'));
                  $("#date").text(newDate.format('yyyy-MM-dd'));
                  $("#uptime").text(uptimeFormat(data.uptime));
                  $("#cpu-temp").text(Math.round(data.cpu.temp/1000 * Math.pow(10,1))/Math.pow(10,1));
                  $("#mem-percent").text(data.mem.percent);
                  $("#mem-free").text(data.mem.free);
                  $("#mem-cached").text(data.mem.cached);
                  $("#mem-swap-total").text(data.mem.swap.total);
                  $("#mem-cache-percent").text(data.mem.cached_percent);
                  $("#mem-buffers").text(data.mem.buffers);
                  $("#mem-real-percent").text(data.mem.real.percent);
                  $("#mem-real-free").text(data.mem.real.free);
                  $("#mem-swap-percent").text(data.mem.swap.percent);
                  $("#mem-swap-free").text(data.mem.swap.free);
                  $("#disk-percent").text(data.disk.percent);
                  $("#disk-free").text(data.disk.free);
                  $("#loadavg-1m").text(data.load_avg[0]);
                  $("#loadavg-5m").text(data.load_avg[1]);
                  $("#loadavg-10m").text(data.load_avg[2]);
                  $("#loadavg-running").text(data.load_avg[3].split("/")[0]);
                  $("#loadavg-threads").text(data.load_avg[3].split("/")[1]);
                  for(i=0;i<data.net.count;i++)
                  {
                      $("#net-interface-"+(i+1)+"-total-in").text(bytesRound(parseInt(data.net.interfaces[i].total_in), 2));
                      $("#net-interface-"+(i+1)+"-total-out").text(bytesRound(parseInt(data.net.interfaces[i].total_out), 2));
                  }

      },
      error:function(jqxhr,textStatus,error){
          console.log("__失败__");
          console.log(error);
          console.log(textStatus);
          console.log(jqxhr);
          console.log("******");}
      });

},5000)





function bytesRound(number, round)
{
    if (number<0){
        var last=0+"B";
    }else if (number<1024){
        //var last=Math.round(number*Math.pow(10,round))/Math.pow(10,round)+"B";
        var last=number+"B";
    }else if (number<1048576){
        number=number/1024;
        var last=Math.round(number*Math.pow(10,round))/Math.pow(10,round)+"K";
    }else if (number<1048576000){
        number=number/1048576;
        var last=Math.round(number*Math.pow(10,round))/Math.pow(10,round)+"M";
    }else{
        number=number/1048576000;
        var last=Math.round(number*Math.pow(10,round))/Math.pow(10,round)+"G";
    }
    return last;
}



Date.prototype.format = function(format) {
    var date = {
        "M+": this.getMonth() + 1,
        "d+": this.getDate(),
        "h+": this.getHours(),
        "m+": this.getMinutes(),
        "s+": this.getSeconds(),
        "q+": Math.floor((this.getMonth() + 3) / 3),
        "S+": this.getMilliseconds()
    };
    if (/(y+)/i.test(format)) {
        format = format.replace(RegExp.$1, (this.getFullYear() + '').substr(4 - RegExp.$1.length));
    }
    for (var k in date) {
        if (new RegExp("(" + k + ")").test(format)) {
            format = format.replace(RegExp.$1, RegExp.$1.length == 1
                ? date[k] : ("00" + date[k]).substr(("" + date[k]).length));
        }
    }
    return format;
}

function uptimeFormat(str){
    var uptime = "";
    var min = parseInt(str) / 60;
    var hours = min / 60;
    var days = Math.floor(hours / 24);
    var hours = Math.floor(hours - (days * 24));
    min = Math.floor(min - (days * 60 * 24) - (hours * 60));

    if (days !== 0){
        if(days == 1){
            uptime = days+" day ";
        }
        else{
            uptime = days+" days ";
        }
    }
    if (hours !== 0){
        uptime = uptime+hours+":";
    }

    return uptime =uptime+min;
}






/*function startRequest()
{
    $("#time").text((new Date()).toString());
}
$(document).ready(function () {
    setInterval("startRequest()",1000);
});*/



</script>
<!--<div id="main"></div>-->
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));

    // 指定图表的配置项和数据
    myChart.setOption({
        title: {
            text: 'ens33'
        },
        tooltip: {},
        legend: {
            data:['销量']
        },
        xAxis: {
            data: []
        },
        yAxis: {},
        series: [{
            name: 'totalin',
            type: 'line',
            data: []
        }]
    });


    function getChart() {
        var nums=[]; //这是我自己建的空数组，为了把异步拿到的数据push进去
        //var names=[];
        myChart.showLoading();  //加载数据前的loading动画
        $.ajax({
            url: "./echart.php?ajax=ens33",    //请求的接口名
            type: 'GET',
            async: true,
            dataType:'json',
            success: function(data){
                console.log(data);
                myChart.hideLoading();  //加载数据完成后的loading动画
                //var dataStage = data.data;   //这里是我们后台返给我的数据
                console.log(data['total_in'])
                nums=data['total_in']
                nums=parseInt(Number(nums/1024))
                nums=String(nums)
                nums.push
                console.log(nums);
                //nums.push=data['name'];
              //  for(var i in dataStage) {
           //         var statisticsObj = {name:'',value:''};   //因为ECharts里边需要的的数据格式是这样的
             //       statisticsObj.name = dataStage[i].typeName;
              //      statisticsObj.value = dataStage[i].typeValue;
                 //   statisticsData.push(statisticsObj);   //把拿到的异步数据push进我自己建的数组里
            // }

                myChart.setOption({        //加载数据图表
                    xAxis: {
                        //data: names
                    },
                    series: [{
                        // 根据名字对应到相应的系列
                        name: 'total_in',
                        data: nums
                    }]
                });
            },
            error: function(){
                console.log('失败')
            }
        })
    }
   setInterval(function () {
       getChart()
   },1000)
    //myChart.setOption(option);
</script>
<div class="container-sm">
    <div class="jumbotron jumbotron-sm " style="font-size:12px;">
        <div class="container-sm">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">服务器情况</h6>

<div id="time" class="badge-warning badge">
</div>
<div id="date" class="badge-warning badge">
</div>

                            <div id="uptime" class="badge-warning badge">
                            </div>
                            <div id="cpu-temp" class="badge-warning badge">
                            </div>
                            <div id="mem-percent" class="badge-warning badge">
                            </div>
                            <div id="mem-free" class="badge-warning badge">
                            </div>
                            <div id="mem-cached" class="badge-warning badge">
                            </div>
                            <div id="mem-swap-total" class="badge-warning badge">
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
