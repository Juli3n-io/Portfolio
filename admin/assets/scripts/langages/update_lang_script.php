<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/langages_functions.php';

/* #############################################################################

Modification d'un langage a partir langage.php en Ajax via update_modal.php

############################################################################# */

$result = array();

if(!empty($_POST)){

  $id = $_POST['update_id'];
  $titre = $_POST['update_name_lang'];
  $icone = $_POST['new_logo'];
  $number = $_POST['UpdateskillRange'];
  
  $query = $pdo->query("SELECT * FROM langages WHERE id_langage = '$id'");
  $thislang = $query->fetch(PDO::FETCH_ASSOC); 


  // debut de la requete d'update
  $param = FALSE;
  $requete = 'UPDATE langages SET ';

  //modification du titre
  if($titre !== $thislang['titre']){

    if(getSkillBy($pdo,'titre',$titre)!==null){

      $result['status'] = false;
      $result['notif'] = notif('error','oups! cet langage existe déjà'); 
    
    }else{

      $requete .= 'titre = :titre';
      $param = TRUE;   

    }

  }

  //modification du titre
  if($icone !== $thislang['icone']){

    if(getSkillBy($pdo,'icone',$icone)!==null){

      $result['status'] = false;
      $result['notif'] = notif('error','oups! cet icone existe déjà'); 
    
    }else{

      $requete .= 'icone = :icone';
      $param = TRUE;   

    }

  }

  //modification du nombre
  if($number !== $thislang['number']){

    if($param == TRUE){

      $requete .= ', number = :number';

    }else{

      $requete .= 'number = :number';
    }

  $param = TRUE;  

  }


  //lancement de la requete
  $requete .= ' WHERE id_langage = :id';

  // préparation de la requete
  $req_update = $pdo->prepare($requete);
  $req_update->bindParam(':id',$id,PDO::PARAM_INT);


  if($titre !== $thislang['titre']){
    $req_update->bindValue(':titre',$titre);
  }
  if($icone !== $thislang['icone']){
    $req_update->bindValue(':icone',$icone);
  }
  if($number !== $thislang['number']){
    $req_update->bindValue(':number',$number);
  }

  $req_update->execute();

  $result['status'] = true;
  $result['notif'] = notif('success','Langage Modifié');

    $query = $pdo->query('SELECT * FROM langages');

     //retour ajax
    $result['resultat'] = '<table>';

    $result['resultat'] .= '<thead>
                      <tr>
                        <th>ID</th>
                        <th>Logo</th>
                        <th>Titre</th>
                        <th>%</th>';
                        if($Membre['statut'] == 0){
                          $result['resultat'] .= '<th>Actions</th>';
                        }
      $result['resultat'] .=  '</tr>
                  </thead>';

      $result['resultat'] .= '<tbody>';

      while($lang = $query->fetch()){

      $result['resultat'] .= '<tr>';
        $result['resultat'] .= '<td>'.$lang['id_langage'].'</td>';
        $result['resultat'] .= '<td><div class="img-logo"><i class="'.$lang['icone'].'"></i></div></td>';
        $result['resultat'] .= '<td>'.$lang['titre'].'</td>';
        $result['resultat'] .= '<td>'.$lang['number'].' %</td>';

        if($Membre['statut'] == 0){
        $result['resultat'] .= '<td class="member_action">';
            $result['resultat'] .= '<input type="button" class="viewbtn" name="view" id="'.$lang['id_langage'].'"></input>';
            $result['resultat'] .= '<input type="button" class="editbtn" id="'.$lang['id_langage'].'"></input>';
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


  