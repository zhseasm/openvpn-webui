<?php
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'device.php');
include './header.php';
?>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://libel.work/pi/assets/jquery-3.1.1.min.js"></script>
    <script src="https://libel.work/pi/assets/highcharts.js"></script>
    <script src="https://libel.work/pi/assets/highcharts-more.js"></script>
    <script src="https://libel.work/pi/assets/solid-gauge.js"></script>
    <script src="https://libel.work/pi/assets//bootstrap.min.js"></script
  <link href="https://libel.work/pi/assets/bootstrap.min.css" rel="stylesheet">
    <script src="./js/dashboard.js"></script>
    <script language="JavaScript">
        window.dashboard_old = null;
        window.dashboard = null;
          var init_vals = eval('('+"{'mem': {'total':<?php echo($D['mem']['total']) ?>,'swap':{'total':<?php echo($D['mem']['swap']['total']) ?>}}, 'disk': {'total':<?php echo($D['disk']['total']) ?>}, 'net': { 'count': <?php echo($D['net']['count']) ?>} }"+')');
    </script>
<div class="container-sm">
    <div class="jumbotron jumbotron-sm " style="font-size:12px;">
        <div class="container-sm">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text text-monospace text-wrap">
                            <span class="badge badge-sm badge-warning">Time:</span>
                                <span id="time" class="badge badge-info badge-sm"></span>
                                <span class="badge badge-sm badge-warning">UpTime:</span>
                                <span id="uptime" class="badge-info badge badge-sm"></span>
                                <span class="badge badge-sm badge-warning">User:</span>
                                <span id="user" class="badge-info badge badge-sm"><?php echo($D['user']); ?></span>
                                <span class="badge badge-sm badge-warning">Os:</span>
                                <span id="os" class="badge-info badge badge-sm"><?php echo($D['os'][0]); ?></span>
                            </p>
                            <p class="card-text text-monospace text-wrap">
                                <span class="badge badge-sm badge-warning">hostname:</span>
                                <span id="hostname" class="badge-info badge badge-sm"><?php echo($D['hostname']); ?></span>
                                <span class="badge badge-sm badge-warning">uname:</span>
                                <span id="uname" class="badge-info badge badge-sm text-wrap"><?php echo($D['uname']); ?></span>
                            </p>

                            <div class="row">
                                <div id="container-mem" class="col-sm-2"></div>
                                <div id="container-cache"class="col-sm-2" ></div>
                                <div id="container-mem-real" class="col-sm-2"></div>
                                <div id="container-swap" class="col-sm-2"></div>
                                <div id="container-disk" class="col-sm-2"></div>
                                <div id="container-cpu" class="col-sm-2"></div>
                            </div>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <?php
        for($i = 0; $i<$D['net']['count'];$i++)
        {
            ?>
            <div class="row" style="margin: 0;">
                <div class="col-md-10 col-sm-10 col-xs-10" ">
                    <div id="container-net-interface-<?php echo($i+1) ?>" ></div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2" style="padding: 0;">
                    <div style="height: 80px; margin-top: 10px;">
                        <div class="text-center" style="padding: 2px 0 2px 0; background-color: #CCCCCC;"><strong><span id="net-interface-<?php echo($i+1) ?>-name"><?php echo($D['net']['interfaces'][$i]['name']) ?></span></strong></div>
                        <div class="text-center" style="padding: 10px 0 10px 0; background-color: #9BCEFD;"><span id="net-interface-<?php echo($i+1) ?>-total-in"><?php echo($D['net']['interfaces'][$i]['total_in']) ?></span><br /><small class="label">IN</small></div>
                        <div class="text-center" style="padding: 10px 0 10px 0; background-color: #CDFD9F;"><span id="net-interface-<?php echo($i+1) ?>-total-out"><?php echo($D['net']['interfaces'][$i]['total_out']) ?></span><br /><small class="label">OUT</small></div>
                    </div>
                </div>
            </div>

            <?php
        }
        ?>






