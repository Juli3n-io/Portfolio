<?php 

// calcul du nombre de téléchargement du CV
function getDownloadCv(PDO $pdo){

  $req = $pdo->query(
    "SELECT nb_clicks
    from cv_clicks");

    $click = $req->fetch(PDO::FETCH_ASSOC);
    
    if($click){
      return $click['nb_clicks'];
    }else{
      return 0;
    }

  }

?>