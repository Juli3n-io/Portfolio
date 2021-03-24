<?php
require_once __DIR__ . './../config/bootstrap.php';
require_once __DIR__ . './../functions/users.php';

function ajouter_vue($pdo):void {

  $date = date('Y-m-d');
  
  if(getVisites($pdo,'date',$date)!==null){

    $data = $pdo->query("SELECT * FROM visites WHERE date = '$date'");
    $thisDay = $data->fetch(PDO::FETCH_ASSOC);

    $new_visite = ++$thisDay['nb_visites'];
    $id = $thisDay['id'];

    $req_update = $pdo->prepare('UPDATE visites SET nb_visites = :nb_visites WHERE id = :id');

    $req_update->bindParam(':id',$id,PDO::PARAM_INT);
    $req_update->bindValue(':nb_visites',$new_visite);
    $req_update->execute();

  }else{

  $req = $pdo->prepare('INSERT INTO visites(nb_visites, date) VALUES (:nb_visites, :date)');
      
  $req->bindValue(':nb_visites',1);
  $req->bindValue(':date',$date);
  $req->execute();

  }

}