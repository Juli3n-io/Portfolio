<?php
require_once __DIR__ . './../config/bootstrap.php';
require_once __DIR__ . '/users.php';

function ajouter_vue($pdo, $myIp):void {

  $date = date('Y-m-d');
  $user_ip = getIp();
  
  if(!in_array($user_ip, $myIp)){

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

}


function origin_click(PDO $pdo, $myIp, $token, $google, $url){

  $user_ip = getIp();

  if(!in_array($user_ip, $myIp)){

    if(in_array($url , $google)){

      $name = 'Google';
    
      $data = $pdo->query("SELECT * FROM origin_clicks WHERE titre = '$name'");
      $thisG = $data->fetch(PDO::FETCH_ASSOC);
      
      $new_visite = ++$thisG['nb_clicks'];
      $id = $thisG['id'];
      
      $req_update = $pdo->prepare('UPDATE origin_clicks SET nb_clicks = :nb_clicks WHERE id = :id');
      
      $req_update->bindParam(':id',$id,PDO::PARAM_INT);
      $req_update->bindValue(':nb_clicks',$new_visite);
      $req_update->execute();
      
    }elseif($token !== ''){
    
    
      $data = $pdo->query("SELECT * FROM origin_clicks WHERE token = '$token'");
      $thisClick = $data->fetch(PDO::FETCH_ASSOC);
      
      $new_visite = ++$thisClick['nb_clicks'];
      $id = $thisClick['id'];
      
      $req_update = $pdo->prepare('UPDATE origin_clicks SET nb_clicks = :nb_clicks WHERE id = :id');
      
      $req_update->bindParam(':id',$id,PDO::PARAM_INT);
      $req_update->bindValue(':nb_clicks',$new_visite);
      $req_update->execute();
    
    }else{
    
      $name = 'Autres';
    
      $data = $pdo->query("SELECT * FROM origin_clicks WHERE titre = '$name'");
      $thisO = $data->fetch(PDO::FETCH_ASSOC);
      
      $new_visite = ++$thisO['nb_clicks'];
      $id = $thisO['id'];
      
      $req_update = $pdo->prepare('UPDATE origin_clicks SET nb_clicks = :nb_clicks WHERE id = :id');
      
      $req_update->bindParam(':id',$id,PDO::PARAM_INT);
      $req_update->bindValue(':nb_clicks',$new_visite);
      $req_update->execute();
    
    
    }  

    

  }

  

}

?>