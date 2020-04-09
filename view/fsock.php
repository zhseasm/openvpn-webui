<?php
$fp = fsockopen("10.8.0.5", 80, $errno, $errstr, 30);
if (!$fp) {
    echo "$errstr ($errno)<br />\n";
} else {
    $out = "GET / HTTP/1.1\r\n";
    $out .= "Host: 10.8.0.5\r\n";
    $out .= "Connection: Close\r\n\r\n";
    fwrite($fp, $out);
    while (!feof($fp)) {
        echo fgets($fp, 128);
    }
    fclose($fp);
}
?>


<?php
/*
$host = gethostbyaddr($_SERVER['REMOTE_ADDR']);

# working vars
$host = '192.20.0.6';
$service_uri = '/cgi-bin/processACT';
$vars ='code=22&act=TEST';

# compose HTTP request header
$header = "Host: $host\r\n";
$header .= "User-Agent: PHP Script\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: ".strlen($vars)."\r\n";
$header .= "Connection: close\r\n\r\n";

$fp = pfsockopen("ssl://".$host, 443, $errno, $errstr);
if (!$fp) {
    echo "$errstr ($errno)<br/>\n";
    echo $fp;
} else {
    fputs($fp, "POST $service_uri  HTTP/1.1\r\n");
    fputs($fp, $header.$vars);
    fwrite($fp, $out);
    while (!feof($fp)) {
        echo fgets($fp, 128);
    }
    fclose($fp);
}

*/?>