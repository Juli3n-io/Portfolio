<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/education_functions.php';

/* #############################################################################

Ajout d'une formation a partir education.php en Ajax

############################################################################# */

$result = array(); 

if(!empty($_POST)){ 

  

  $id = $_POST['update_id'];
  $titre = $_POST['update_titre'];
  $school = $_POST['update_school'];
  $contenu = $_POST['update_contenu'];
  $url = $_POST['update_url'];
  $publie = isset($_POST['est_publie']);

  $query = $pdo->query("SELECT * FROM education WHERE id_education = '$id'");
  $thisEdu = $query->fetch(PDO::FETCH_ASSOC); 

  // debut de la requete d'update
  $param = FALSE;
  $requete = 'UPDATE education SET ';

  //modification du titre
  if($titre !== $thisEdu['titre']){

    if(getEduBy($pdo,'titre',$titre)!==null){

      $result['status'] = false;
      $result['notif'] = notif('error','oups! cette formation existe déjà'); 
    
    }else{

      $requete .= 'titre = :titre';
      $param = TRUE;   

    }

  }

  //modification school
  if($school !== $thisEdu['school']){

    if(getEduBy($pdo,'school',$school)!==null){

      $result['status'] = false;
      $result['notif'] = notif('error','oups! cette école existe déjà'); 
    
    }else{

      if($param == TRUE){

        $requete .= ', school = :school';
  
      }else{
  
        $requete .= 'school = :school';
      }
  
    $param = TRUE;  

    }

  }

  //modification contenu
  if($contenu !== $thisEdu['contenu']){

    if($param == TRUE){

      $requete .= ', contenu = :contenu';

    }else{

      $requete .= 'contenu = :contenu';
    }
    
    $param = TRUE;  

  }

  //modification Url
  if($url !== $thisEdu['url']){

    if($param == TRUE){

      $requete .= ', url = :url';

    }else{

      $requete .= 'url = :url';
    }
    
    $param = TRUE;  

  }

  //modification de la publication
  if($publie !== $thisEdu['est_publie']){

    if($param == TRUE){

      $requete .= ', est_publie = :est_publie';

    }else{

      $requete .= 'est_publie = :est_publie';
    }
    
    $param = TRUE;  

  }

  //lancement de la requete
  $requete .= ' WHERE id_education = :id';

  // préparation de la requete
  $req_update = $pdo->prepare($requete);
  $req_update->bindParam(':id',$id,PDO::PARAM_INT);

  if($titre !== $thisEdu['titre']){
    $req_update->bindParam(':titre',$titre);
  }
  if($school !== $thisEdu['school']){
    $req_update->bindParam(':school',$school);
  }
  if($contenu !== $thisEdu['contenu']){
    $req_update->bindParam(':contenu',$contenu);
  }
  if($url !== $thisEdu['url']){
    $req_update->bindParam(':url',$url);
  }
  if($publie !== $thisEdu['est_publie']){
      $req_update->bindValue(':est_publie',$publie,PDO::PARAM_BOOL);
  }
  
  $req_update->execute();

  $result['status'] = true;
  $result['notif'] = notif('success','Formation modifiée');

  // préparation retour Ajax
  $query = $pdo->query('SELECT * FROM education');

  //retour ajax table
  $result['resultat'] = '<table>';

  $result['resultat'] .= '<thead>
                  <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>School</th>
                    <th>Début</th>
                    <th>Fin</th>';
                    if($Membre['statut'] == 0){
                      $result['resultat'] .= ' <th>Publié</th>';
                      $result['resultat'] .= '<th>Actions</th>';
                    }else{
                      $result['resultat'] .= '<th>Action</th>';
                    }
                    
  $result['resultat'] .=  '</tr>
              </thead>';

  $result['resultat'] .= '<tbody>';

  while($edu = $query->fetch()){

    // changement format date
    $date_from = str_replace('/', '-', $edu['start_date']);
    $date_to = str_replace('/', '-', $edu['stop_date']);

    $result['resultat'] .= '<tr>';
    $result['resultat'] .= '<td>'.$edu['id_education'].'</td>';
    $result['resultat'] .= '<td>'.$edu['titre'].'</td>';
    $result['resultat'] .= '<td>'.$edu['school'].'</td>';
    $result['resultat'] .= '<td>'.date('Y', strtotime($date_from)).'</td>';
    $result['resultat'] .= '<td>'.date('Y', strtotime($date_to)).'</td>';

    if($Membre['statut'] == 0){

      if($edu['est_publie'] == 1){

        $result['resultat'] .= '<td> <input type="checkbox" id="est_publie" name="est_publie" class="est_publie" value='.$edu['est_publie'].' checked></td>';

      }else{

        $result['resultat'] .= '<td> <input type="checkbox" id="est_publie" name="est_publie" class="est_publie" value='.$edu['est_publie'].'></td>';

      }
      
      
      $result['resultat'] .= '<td class="member_action">';
          $result['resultat'] .= '<a href='.$edu['url'].' class="linkbtn"></a>';
          $result['resultat'] .= '<input type="button" class="viewbtn" name="view" id="'.$edu['id_education'].'"></input>';
          $result['resultat'] .= '<input type="button" class="editbtn" id="'.$edu['id_education'].'"></input>';
          $result['resultat'] .= '<input type="button" class="deletebtn"></input>';
      $result['resultat'] .= '</td>';

      }else{

        $result['resultat'] .= '<td class="member_action">';
          $result['resultat'] .= '<a href='.$edu['url'].' class="linkbtn"></a>';
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