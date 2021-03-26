<?php
require_once __DIR__ . './../../global/config/bootstrap.php';

ajouter_vue($pdo, $myIp);

$token = '';
$url = '';

if(isset($_SERVER['HTTP_REFERER'])){

  $url =  $_SERVER['HTTP_REFERER'];
  
}

if(isset($_GET['from'])){

$token = htmlspecialchars($_GET["from"]);

}

origin_click($pdo, $myIp, $token, $google, $url);
 
include __DIR__. './../views/header_view.php';
?>