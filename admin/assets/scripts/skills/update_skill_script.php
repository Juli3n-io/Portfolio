<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/soft_skills_functions.php';

/* #############################################################################

Modification d'une compétence a partir skills.php en Ajax via update_modal.php

############################################################################# */

$result = array();

if(!empty($_POST)){

  $id = $_POST['update_id'];
  $titre = $_POST['update_titre'];
  $number = $_POST['UpdateskillRange'];
  $publie = isset($_POST['est_publie']);

  
  $query = $pdo->query("SELECT * FROM skills WHERE id_skill = '$id'");
  $thisSkill = $query->fetch(PDO::FETCH_ASSOC); 

  // debut de la requete d'update
  $param = FALSE;
  $requete = 'UPDATE skills SET ';


  //modification du titre
  if($titre !== $thisSkill['titre']){

    if(getSkillBy($pdo,'titre',$titre)!==null){

      $result['status'] = false;
      $result['notif'] = notif('error','oups! cette compétence existe déjà'); 
    
    }else{

      $requete .= 'titre = :titre';
      $param = TRUE;   

    }

  }

  //modification du nombre
  if($number !== $thisSkill['number']){

    if($param == TRUE){

      $requete .= ', number = :number';

    }else{

      $requete .= 'number = :number';
    }

  $param = TRUE;  

  }

  //modification de la publication
  if($publie !== $thisSkill['est_publie']){

    if($param == TRUE){

      $requete .= ', est_publie = :est_publie';

    }else{

      $requete .= 'est_publie = :est_publie';
    }
    
    $param = TRUE;  

  }

  //lancement de la requete
  $requete .= ' WHERE id_skill = :id';

// préparation de la requete
  $req_update_skill = $pdo->prepare($requete);
  $req_update_skill->bindParam(':id',$id,PDO::PARAM_INT);

if($titre !== $thisSkill['titre']){
  $req_update_skill->bindValue(':titre',$titre);
}
if($number !== $thisSkill['number']){
  $req_update_skill->bindValue(':number',$number);
}
if($publie !== $thisSkill['est_publie']){
    $req_update_skill->bindValue(':est_publie',$publie,PDO::PARAM_BOOL);
}

$req_update_skill->execute();


$result['status'] = true;
$result['notif'] = notif('success','Compétence modifiée');


//retour ajax card
$result['cards'] = '<div class="card__single">
<div class="card__body">
  <i class="fas fa-folder-open"></i>
  <div>
    <h5>Toutes les compétences</h5>
    <h4>'.countSkill($pdo).'</h4>
  </div>
</div>
<div class="card__footer">
<input type="button" name="all" id="all" value="View All">
</div>
</div>';

$result['cards'] .= '<div class="card__single">
<div class="card__body">
  <i class="far fa-eye"></i>
  <div>
    <h5>Publiées</h5>
    <h4>'.countSkillPublie($pdo).'</h4>
  </div>
</div>
<div class="card__footer">
<input type="button" name="all_publie" id="all_publie" value="View All">
</div>
</div>';

$result['cards'] .= '<div class="card__single">
<div class="card__body">
    <i class="far fa-eye-slash"></i>
  <div>
      <h5>Non Publiées</h5>
      <h4>'. countSkillNonPublie($pdo).'</h4>
  </div>
</div>
<div class="card__footer">
<input type="button" name="non_publie" id="non_publie" value="View All">
</div>
</div>';

$query = $pdo->query('SELECT * FROM skills');

//retour ajax
$result['resultat'] = '<table>';

$result['resultat'] .= '<thead>
                  <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>%</th>';
                    if($Membre['statut'] == 0){
                      $result['resultat'] .= '<th>Publié</th>';
                      $result['resultat'] .= '<th>Actions</th>';
                    }
  $result['resultat'] .=  '</tr>
              </thead>';

  $result['resultat'] .= '<tbody>';

  while($skill = $query->fetch()){

    $result['resultat'] .= '<tr>';
      $result['resultat'] .= '<td>'.$skill['id_skill'].'</td>';
      $result['resultat'] .= '<td>'.$skill['titre'].'</td>';
      $result['resultat'] .= '<td>'.$skill['number'].' %</td>';

      if($Membre['statut'] == 0){

        if($skill['est_publie'] == 1){

          $result['resultat'] .= '<td> <input type="checkbox" id="est_publie" name="est_publie" class="est_publie" value='.$skill['est_publie'].' checked></td>';

        }else{

          $result['resultat'] .= '<td> <input type="checkbox" id="est_publie" name="est_publie" class="est_publie" value='.$skill['est_publie'].'></td>';

        }

      $result['resultat'] .= '<td class="member_action">';
          $result['resultat'] .= '<input type="button" class="editbtn" id="'.$skill['id_skill'].'"></input>';
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


  