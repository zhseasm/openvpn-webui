<?php
// OpenVPN (php-based) web status script
//
// This script has been released to the public domain by Pablo Hoffman
// on February 28, 2007.
//
// Original location:
// http://pablohoffman.com/software/vpnstatus/vpnstatus.txt

// Configuration values --------
$vpn_name = "My VPN";
$vpn_host = "localhost";
$vpn_port = 1195;
// -----------------------------

$fp = fsockopen($vpn_host, $vpn_port, $errno, $errstr, 30);
if (!$fp) {
echo "$errstr ($errno)
";
exit;
}

fwrite($fp, "status


");
sleep(1);
fwrite($fp, "quit


");
sleep(1);
$clients = array();
$inclients = $inrouting = false;
while (!feof($fp)) {
$line = fgets($fp, 128);
if (substr($line, 0, 13) == "ROUTING TABLE") {
$inclients = false;
}
if ($inclients) {
$cdata = split(',', $line);
$clines[$cdata[1]] = array($cdata[2], $cdata[3], $cdata[4]);
}
if (substr($line, 0, 11) == "Common Name") {
$inclients = true;
}

if (substr($line, 0, 12) == "GLOBAL STATS") {
$inrouting = false;
}
if ($inrouting) {
$routedata = split(',', $line);
array_push($clients, array_merge($routedata, $clines[$routedata[2]]));
}
if (substr($line, 0, 15) == "Virtual Address") {
$inrouting = true;
}
}

$headers = array('VPN Address', 'Name', 'Real Address', 'Last Act', 'Recv', 'Sent', 'Connected Since');
$tdalign = array('left', 'left', 'left', 'left', 'right', 'right', 'left');
/* DEBUG
print "
";
print_r($headers);
print_r($clients);
print_r($clines);
print_r($routedata);
print "";
*/
fclose($fp);



?>
<?php
"-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
"http://www.w3.org/1999/xhtml">




'refresh' content='300' />

"text/css">
body {
font-family: Verdana, Arial, Helvetica, sans-serif;
font-size: 14px;
background-color: #E5EAF0;
}
h1 {
color: green;
font-size: 24px;
text-align: center;
padding-bottom: 0;
margin-bottom: 0;
}
p.info {
text-align: center;
font-size: 12px;
}
.status0 {
background: #ebb;
}
.status1 {
background: lime;
}
table {
#border: medium solid maroon;
margin: 0 auto;
border-collapse: collapse;
}
th {
background: maroon;
color: white;
}
tr {
border-bottom: 1px solid silver;
}
td {
padding: 0px 10px 0px 10px;
}










foreach ($headers as $th) { ?>





<?php
foreach ($clients as $client) {
$client[3] = date ('Y-m-d H:i', strtotime($client[3]));
$client[6] = date ('Y-m-d H:i', strtotime($client[6]));
$client[4] = number_format($client[4], 0, '', '.');
$client[5] = number_format($client[5], 0, '', '.');
$client[2] = preg_replace('/(.*):.*/', '$1', $client[2]);
$i = 0;
?>

<?php
foreach ($client as $td) { ?>
<?php''>echo $td?>


<?php



echo $th?>
<?php
class='info'>This page gets reloaded every 5 min.Last update: echo date ("Y-m-d H:i:s") ?>
