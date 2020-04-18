<!-- Include gateone.js somewhere on your page -->
<script src="./js/gateone.js"></script>
<script src="<?='https://'.$_SERVER['SERVER_ADDR'].':8443/static/gateone.js'?>"></script>

<?php
include './header.php';
include './checkPermission.php';
//var_dump('https://'.$_SERVER['SERVER_ADDR'].':8443/static/gateone.js');
$SERVER=$_SERVER['SERVER_ADDR'];
$gateone_owner =gethostname();
$secret = "YzZhOTljMjczNjIzNDAyOThmZDliMjQ3M2QxM2Y1NDgyM";
$authobj = array(
    'api_key' => "ODA4ZmNlNWFlZTBmNDM1ZmFkOGNlOWM3MTBlY2FiMGU4N",
    /*'upn' => $_SERVER['REMOTE_USER'],*/
    'upn' => $gateone_owner,
    'timestamp' => time() * 1000,
    'signature_method' => 'HMAC-SHA1',
    'api_version' => '1.0'
);
//$ssh_url="ssh://127.0.0.1";
//$ssh_url=json_encode($ssh_url);
//echo $ssh_url;
$authobj['signature'] = hash_hmac('sha1', $authobj['api_key'] . $authobj['upn'] . $authobj['timestamp'], $secret);
$valid_json_auth_object = json_encode($authobj);
/*var_dump( $_SERVER);*/
/*echo $_SERVER['SERVER_ADDR'];*/
/*var_dump($_SERVER);*/
/*var_dump($_SERVER['HTTP_HOST']);*/
?>

<div class="container-sm">
    <div class="jumbotron jumbotron-sm " >
        <div class="container-sm text-monospace">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body" id="gateone_container" style="height: 480px;">
<!-- Decide where you want to put Gate One -->
<?php
echo "<span><a href=\"https://$SERVER:8443/static/gateone.js\" target='_blank' class=\"badge badge-info badge-sm\">请初始化gateone</a></span>";
?>
    <div id="gateone">
    </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Call GateOne.init() at some point after the page is done loading -->
<script>
    window.onload = function() {
        // Initialize Gate One:
        GateOne.init({
            auth:<?=$valid_json_auth_object;?>,
            url:"https://<?=$_SERVER['HTTP_HOST'];?>:8443",
           /*embedded: true,*/
            goDIV:'#gateone',
            autoConnectURL:"ssh://root@localhost:22",
            /*max_terms:1,*/
            /*showTitle:false,
            showToolbar:false,*/


            /*showToolbar:true,*/
           /* style: { 'background-color': 'yellowgreen', 'box-shadow': '0 0 40px blueViolet'}*/
        });
    /*    GateOne.Net.autoConnect();*/
    }
</script>


<!--url:"https://--><?/*=$_SERVER['SERVER_NAME'];*/?>"
<!--url:"https://<?/*=$_SERVER['HTTP_HOST'];*/?>:8443",
url:"https://192.168.31.121:8443",-->
<?php include './footer.php';?>
<!-- That's it! -->
