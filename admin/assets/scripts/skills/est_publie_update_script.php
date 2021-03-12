<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/soft_skills_functions.php';


/* #############################################################################

publication d'une compétence directement depuis le tableau de posts.php en Ajax

############################################################################# */



if(!empty($_POST)){

  $result = array();
  $id = $_POST['id'];
  $publie = $_POST['publie'];

  if($publie == 0){

  $req = $pdo->prepare('UPDATE skills SET est_publie = :publie WHERE id_skill = :id');

  $req->bindParam(':id',$id,PDO::PARAM_INT);
  $req->bindValue(':publie',1);
  $req->execute();

  $result['status'] = true;
  $result['notif'] = notif('success','Compétence publiée');

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


    
  }else{

  $req = $pdo->prepare('UPDATE skills SET est_publie = :publie WHERE id_skill = :id');

  $req->bindParam(':id',$id,PDO::PARAM_INT);
  $req->bindValue(':publie',0);
  $req->execute();

  $result['status'] = true;
  $result['notif'] = notif('success','Compétence retirée');

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
        $result['resultat'] .= '<input type="button" class="viewbtn" name="view" id="'.$skill['id_skill'].'"></input>';
        $result['resultat'] .= '<input type="button" class="editbtn" id="'.$skill['id_skill'].'"></input>';
        $result['resultat'] .= '<input type="button" class="deletebtn"></input>';
      $result['resultat'] .= '</td>';
      }

      $result['resultat'] .= '</tr>';

    }

    $result['resultat'] .= '</tbody>';

    $result['resultat'] .= '</table>';

  }


// retour Ajax
echo json_encode($result);
}




?>