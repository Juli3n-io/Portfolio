<?php
require_once __DIR__ . './../../global/config/bootstrap.php';
require_once __DIR__ . './../functions/portfolio_functions.php';


/* #############################################################################

Calcul le nombre de click d'un liens

############################################################################# */

if(!empty($_POST)){
  
  $id_post = $_POST['post_id'];

  if(getPostClick($pdo,'post_id',$id_post)!==null){

  $data = $pdo->query("SELECT * FROM clicks WHERE post_id = '$id_post'");
  $thisPost = $data->fetch(PDO::FETCH_ASSOC);

 

  $click = ++$thisPost['nb_clicks'];
  $id = $thisPost['id'];

  $req_update = $pdo->prepare('UPDATE clicks SET nb_clicks = :nb_clicks WHERE id = :id');

  $req_update->bindParam(':id',$id,PDO::PARAM_INT);
  $req_update->bindValue(':nb_clicks',$click);
  $req_update->execute();


  }else{

  $req = $pdo->prepare('INSERT INTO clicks(nb_clicks, post_id) VALUES (:nb_clicks, :post_id)');
      
  $req->bindValue(':nb_clicks',1);
  $req->bindValue(':post_id',$id_post);
  $req->execute();

  }
  

}
?>
