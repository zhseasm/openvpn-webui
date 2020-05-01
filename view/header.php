<?php
/*session_start();
$sessionid=session_id();*/
/*echo $sessionid;*/
//include './status.php'
?>
<!DOCTYPE html>
<html lang="utf-8">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
     <!-- <meta http-equiv="refresh" content="5">-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
     <link rel="stylesheet" type="text/css" href="./css/magic.css">
      <!--<link rel="stylesheet" type="text/css" href="https://unpkg.com/magic-input/dist/magic-input.min.css">-->

     <!--  <link rel="stylesheet" type="text/css" href="./css/bootstrap-grid.min.css">
      <link rel="stylesheet" type="text/css" href="./css/bootstrap-reboot.min.css"> -->
      <!--<script type="text/javascript">
          window.onload=function () {
              alert('xss');
          }
      </script>-->
<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>-->
      <script type="text/javascript" src="./js/qrcode.min.js"></script>
      <script type="text/javascript" src="./jQuery/jquery.min.js"></script>
      <script type="text/javascript" src="./jQuery/jquery.js"></script>
   <script type="text/javascript" src="./js/bootstrap.bundle.min.js"></script>
      <script src="./js/status.js"></script>

      <!--   <script type="text/javascript" src="./js/bootstrap.min.js"></script> -->
    <title>OpenVpn</title>
  </head>

<body>

<div class="container-sm">
    <noscript>
        <p class="badge badge-warning text-monospace col-sm-12">
            <span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span>
            <a class="text-light">
                <span>你的浏览器不支持script<br /><br />或者禁用了script!请换个浏览器再试!</span>
            </a>
        <p/>
    </noscript>

<nav class="navbar navbar-expand-lg navbar-dark bg-info">
  <a class="navbar-brand" href="index.php" style="font-size: 16px;">OpenVpn</a>
  
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>


  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
     
     
      <li class="nav-item dropdown">
        <a class="nav-link " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          detailinfo
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="./detail.php">Detail</a>
          <a class="dropdown-item" href="./vpnconf.php">Config</a>
          <!--<div class="dropdown-divider"></div>-->
          <a class="dropdown-item" href="./user.php">Userinfo</a>
        </div>
      </li>

        <li class="nav-item dropdown">
            <a class="nav-link " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                management
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="./gateone.php">Gateone</a>
                <a class="dropdown-item" href="./novnc.php">Novnc</a>
                <a class="dropdown-item" href="./rbacindex.php">Rbac</a>
                <!--<div class="dropdown-divider"></div>-->
            </div>
        </li>


    </ul>
      <!--<button class="badge badge-sm" type="button">logout</button>-->
      <!--<a href="#" class="badge badge-info text-monospace">logout</a>-->
  </div>
</nav>
</div>

