<?php
$D=array();
$kernel = shell_exec('uname -r');
$uptime = shell_exec('uptime');
$who = shell_exec('who');
//$status = shell_exec('sudo bash /var/www/html/admin/status.sh');
//$status = str_replace(array("\r", "\n"), '', $status);
//$loads = sys_getloadavg();
/*var_dump($loads);*/
//$core_nums=trim(shell_exec("grep -P '^physical id' /proc/cpuinfo|wc -l"));
/*var_dump($core_nums);*/
//$load=$loads[0]/$core_nums;
/*var_dump($load);*/
/*$fh = fopen('/proc/meminfo', 'r');
$mem = 0;
while ($line = fgets($fh)) {
    $pieces = array();
    if (preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $pieces)) {
        $mem = ceil($pieces[1] / 1024);
        break;
    }
}*/
$mem=shell_exec('cat /proc/meminfo |grep MemTotal|awk \'{print $2}\'');
/*$mem=ceil(intval($mem) / 1024);*/
$mem=ceil($mem / 1024);
/*var_dump($mem);*/
$memfree=shell_exec('cat /proc/meminfo |grep MemFree|awk \'{print $2}\'');
$memfree=ceil($memfree / 1024);
/*var_dump($memfree);*/
$memused = $mem - $memfree;
$memprogress=(((1/$mem)*$memused)*100);
$memprogressall=round($memprogress,0);

$loads = sys_getloadavg();
$core_nums=trim(shell_exec("grep -P '^physical id' /proc/cpuinfo|wc -l"));
$load=$loads[0]/$core_nums;

$cpuinfo='cpu平均用量(1/5/15min):'.$loads[0].','.$loads[1].','.$loads[2];
//var_dump($loads);
//var_dump($load);
$cpuused=$load;
$cpuprogress=($load)*100;
$cpuprogress=round($cpuprogress,0);
//var_dump($cpuused);
//var_dump($cpuprogress);
$D['cpuprogress']=$cpuprogress;
$D['cpuused']=$cpuused;
$D['cpuinfo']=$cpuinfo;
$D['kernel']=$kernel;
$D['uptime']=$uptime;
$D['who']=$who;
//$D['status']=$status;
$D['hostname'] = gethostname();
$D['date'] = shell_exec('date "+%A %d %b %Y %T"') ;
$D['ens33']=shell_exec('sudo bash /var/www/html/admin/s.sh ens33');
$D['tun0']=shell_exec('sudo bash /var/www/html/admin/s.sh tun0');
$D['mem']=$mem;
$D['memfree']=$memfree;
$D['memused']=$memused;
$D['memprogress']=$memprogress;
$D['memprogressall']=$memprogressall;
$D['meminfo']='内存用量:'.$memused.' MB'.' of '.$mem.' MB';
$T['hostname'] = gethostname();
$T['date']=shell_exec('date "+%A %d %b %Y %T"') ;
//$yiyan=shell_exec('fortune');
//$D['tun0']=shell_exec('sudo bash /var/www/html/admin/s.sh tun0');
if (isset($_GET['ajax']) && $_GET['ajax'] == "true"){
    echo json_encode($D);
    exit;
}
if (isset($_GET['time']) && $_GET['time'] == "true"){
    echo json_encode($T);
    exit;
}
?>