<?php
require_once __DIR__ . './../../global/config/bootstrap.php';
require_once __DIR__ . './../functions/docs_functions.php';


/* #############################################################################

Calcul le nombre de téléchargement du cv

############################################################################# */

if(!empty($_POST)){
  
  $id_doc = $_POST['doc_id'];

  if(getDocClick($pdo,'doc_id',$id_doc)!==null){

  $data = $pdo->query("SELECT * FROM cv_clicks WHERE doc_id = '$id_doc'");
  $thisDoc = $data->fetch(PDO::FETCH_ASSOC);

 
  $click = ++$thisDoc['nb_clicks'];
  $id = $thisDoc['id'];

  $req_update = $pdo->prepare('UPDATE cv_clicks SET nb_clicks = :nb_clicks WHERE id = :id');

  $req_update->bindParam(':id',$id,PDO::PARAM_INT);
  $req_update->bindValue(':nb_clicks',$click);
  $req_update->execute();


  }else{

  $req = $pdo->prepare('INSERT INTO cv_clicks(nb_clicks, doc_id) VALUES (:nb_clicks, :doc_id)');
      
  $req->bindValue(':nb_clicks',1);
  $req->bindValue(':doc_id',$id_doc);
  $req->execute();

  }
  

}
?>