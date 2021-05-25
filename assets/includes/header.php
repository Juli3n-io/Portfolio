<?php
require_once __DIR__ . './../../global/config/bootstrap.php';




$token = '';
$url = '';
$robot = FALSE;
$user_agent = strstr(strtolower($_SERVER['HTTP_USER_AGENT']));

if(isset($_SERVER['HTTP_REFERER'])){

  $url =  $_SERVER['HTTP_REFERER'];
  
}

if(isset($_GET['from'])){

$token = htmlspecialchars($_GET["from"]);

}

if(in_array($user_agent, $bot)){

  $robot = TRUE;

}else{

 ajouter_vue($pdo, $myIp);

}

// if(strstr(strtolower($_SERVER['HTTP_USER_AGENT']), $bot))
// {
//    $robot = TRUE;

// }else{

//   ajouter_vue($pdo, $myIp);

// }


origin_click($pdo, $myIp, $token, $google, $robot, $url);

 
include __DIR__. './../views/header_view.php';

?>