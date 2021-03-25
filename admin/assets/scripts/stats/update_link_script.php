<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/stats_functions.php';

/* #############################################################################

Modification d'un link a partir stats.php en Ajax via update_modal.php

############################################################################# */

$result = array();

if(!empty($_POST)){

  $id = $_POST['update_id'];
  $titre = $_POST['update_titre'];
  $icone = $_POST['new_logo'];
  
  
  $query = $pdo->query("SELECT * FROM origin_clicks WHERE id = '$id'");
  $thisLink = $query->fetch(PDO::FETCH_ASSOC); 


  // debut de la requete d'update
  $param = FALSE;
  $requete = 'UPDATE origin_clicks SET ';

  //modification du titre
  if($titre !== $thisLink['titre']){

    if(getLinkBy($pdo,'titre',$titre)!==null){

      $result['status'] = false;
      $result['notif'] = notif('error','oups! ce link existe déjà'); 
    
    }else{

      $requete .= 'titre = :titre';
      $param = TRUE;   

    }

  }

  //modification icone
  if($icone !== $thisLink['icone']){

    if(getLinkBy($pdo,'icone',$icone)!==null){

      $result['status'] = false;
      $result['notif'] = notif('error','oups! cet icone est déjà utilisé'); 
    
    }else{

      if($param == TRUE){

        $requete .= ', icone = :icone';
  
      }else{
  
        $requete .= 'icone = :icone';
      }
  
    $param = TRUE;  

    }

  }
  
  //lancement de la requete
  $requete .= ' WHERE id = :id';

  // préparation de la requete
  $req_update = $pdo->prepare($requete);
  $req_update->bindParam(':id',$id,PDO::PARAM_INT);

  if($titre !== $thisLink['titre']){
    $req_update->bindParam(':titre',$titre);
  }
  if($icone !== $thisLink['icone']){
    $req_update->bindParam(':icone',$icone);
  }
  
  $req_update->execute();

    $result['status'] = true;
    $result['notif'] = notif('success','link modifié');
    
    $query = $pdo->query('SELECT * FROM origin_clicks');

  //retour ajax
  $result['resultat'] = '<table>';

  $result['resultat'] .= '<thead>
                    <tr>
                      <th>ID</th>
                      <th>Logo</th>
                      <th>Titre</th>
                      <th>Clicks</th>';
                      if($Membre['statut'] == 0){
                        $result['resultat'] .= '<th>Actions</th>';
                      }
    $result['resultat'] .=  '</tr>
                </thead>';

    $result['resultat'] .= '<tbody>';

  while($link = $query->fetch()){

    $result['resultat'] .= '<tr>';

      $result['resultat'] .= '<td>'.$link['id'].'</td>';
      $result['resultat'] .= '<td><div class="img-logo"><i class="'.$link['icone'].'"></i></div></td>';
      $result['resultat'] .= '<td>'.$link['titre'].'</td>';
      $result['resultat'] .= '<td>'.$link['nb_clicks'].'</td>';

      if($Membre['statut'] == 0){
        $result['resultat'] .= '<td class="member_action">';
            $result['resultat'] .='<button class="copybtn" onclick="copyUrl(this)" value="'.$link['url'].'" title="copier url"><i class="far fa-copy"></i></button>';
            $result['resultat'] .= '<input type="button" class="viewbtn" name="view" id="'.$link['id'].'"></input>';
            $result['resultat'] .= '<input type="button" class="editbtn" id="'.$link['id'].'"></input>';
            $result['resultat'] .= '<input type="button" class="deletebtn"></input>';
        $result['resultat'] .= '</td>';
        }

    $result['resultat'] .= '</tr>';
    
    }

    $result['resultat'] .= '</tbody>';

    $result['resultat'] .= '</table>';

    }



// Return result 
echo json_encode($result);
?>


  