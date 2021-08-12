<?php
require_once __DIR__ . './../../global/config/bootstrap.php';

$token = '';
$url = '';
$robot = (bool)false;
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$user_ip = getIp();

if (!in_array($user_ip, $myIp)) {

  if (in_array($user_agent, $bot)) {

    $robot = (bool)true;
    ajouter_vue($pdo);
    origin_click($pdo,  $token, $google, $robot, $url);
  } else {

    ajouter_vue($pdo);
    origin_click($pdo, $token, $google, $robot, $url);
  }

  if (isset($_SERVER['HTTP_REFERER'])) {

    $url =  $_SERVER['HTTP_REFERER'];
  }

  if (isset($_GET['from'])) {

    $token = htmlspecialchars($_GET["from"]);
  }
}




include __DIR__ . './../views/header_view.php';
