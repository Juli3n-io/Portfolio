<?php

//récupération des posts
function getDocs(PDO $pdo):array
{
  $req=$pdo->query(
     'SELECT *
       FROM docs'
  );
  $docs = $req->fetchAll(PDO::FETCH_ASSOC);
  return $docs;
}

// calcul du nombre de téléchargement
function getClick(PDO $pdo, INT $id){

  $req = $pdo->query(
    "SELECT nb_clicks
    from cv_clicks
    WHERE doc_id = '$id'");


    $click = $req->fetch(PDO::FETCH_ASSOC);
    
    if($click){
      return $click['nb_clicks'];
    }else{
      return 0;
    }

  }


?>