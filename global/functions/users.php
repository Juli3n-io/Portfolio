<?php
require_once __DIR__ . './../config/bootstrap.php';

//récupération de l'IP
function getIp(){
  if(!empty($_SERVER['HTTP_CLIENT_IP'])){
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }else{
    $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
  }
  return $ip;
}


//vérification si le jour existe déjà
function getVisites(PDO $pdo, string $colonne, $valeur): ?array
  {
       $req =$pdo->prepare(sprintf(
       'SELECT *
       FROM visites
       WHERE %s = :valeur',
       $colonne
       ));
    
     $req->bindParam(':valeur', $valeur);
     $req->execute();

     $visites =$req->fetch(PDO::FETCH_ASSOC);
     return $visites ?: null;
  }

?>