// 2020.9/24. auth.php

<?php

 if(isset($_SERVER["HTTP_AUTH_USER"]) || !isset($_SERVER["HTTP_AUTH_PASS"])){

    fail();

 } 

 # 設定後端伺服器的 port

 $name = $_SERVER["HTTP_AUTH_USER"];
 $pass = $_SERVER["HTTP_AUTH_PASS"];
 $protocol = $_SERVER["HTTP_AUTH_PROTOCOL"];
 $backend_port = 88;

 if($protocol = "imap"){
    $backend_port = 143;
 }

 if($protocol = "smtp"){
    $backend_port = 25;
 }

 if($username = "kate@mail.pattyappier.name"){
    $server_ip = "192.168.1.8";
 } else {
     faile();
 }

 function fail(){

    header("");
    exit;

 }

?>