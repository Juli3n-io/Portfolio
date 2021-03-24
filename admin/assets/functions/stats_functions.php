<?php

function getDayVisites(PDO $pdo){

  $date = date('Y-m-d');

  $data = $pdo->query("SELECT nb_visites FROM visites WHERE date = '$date'");
  $thisDay = $data->fetch(PDO::FETCH_ASSOC);

  if($thisDay){
    return $thisDay['nb_visites'];
  }else{
    return 0;
  }

}

function getMonth_Visites(PDO $pdo){
  

$data = $pdo->query("SELECT SUM(nb_visites)
                        FROM visites
                        WHERE MONTH(date) = MONTH(CURRENT_DATE())");
$visites = $data->fetch(PDO::FETCH_ASSOC);

if($visites['SUM(nb_visites)']){
  return $visites['SUM(nb_visites)'];
}else{
  return 0;
}

}

function getYear_Visites(PDO $pdo){
  

  $data = $pdo->query("SELECT SUM(nb_visites)
                          FROM visites
                          WHERE YEAR(date) = YEAR(CURRENT_DATE())");
  $visites = $data->fetch(PDO::FETCH_ASSOC);
  
  if($visites['SUM(nb_visites)']){
    return $visites['SUM(nb_visites)'];
  }else{
    return 0;
  }
  
  }

function getTotales_Visites(PDO $pdo){

  $data = $pdo->query("SELECT SUM(nb_visites) FROM visites");
  $visites = $data->fetch(PDO::FETCH_ASSOC);

  if($visites['SUM(nb_visites)']){
    return $visites['SUM(nb_visites)'];
  }else{
    return 0;
  }
}