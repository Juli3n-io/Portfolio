<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/experiences_functions.php';

/* #############################################################################

Ajout d'une experience a partir experience.php en Ajax

############################################################################# */

$result = array(); 

if(!empty($_POST)){ 

  

  $id = $_POST['update_id'];
  $titre = $_POST['update_titre'];
  $inc = $_POST['update_inc'];
  $contenu = $_POST['update_contenu'];
  $url = $_POST['update_url'];
  $publie = isset($_POST['est_publie_update']);

  $query = $pdo->query("SELECT * FROM experiences WHERE id_experience = '$id'");
  $thisExe = $query->fetch(PDO::FETCH_ASSOC); 

  // debut de la requete d'update
  $param = FALSE;
  $requete = 'UPDATE experiences SET ';

  //modification du titre
  if($titre !== $thisExe['titre']){

    if(getExeBy($pdo,'titre',$titre)!==null){

      $result['status'] = false;
      $result['notif'] = notif('error','oups! cette experience existe déjà'); 
    
    }else{

      $requete .= 'titre = :titre';
      $param = TRUE;   

    }

  }

  //modification school
  if($school !== $thisExe['entreprise']){

    if(getEduBy($pdo,'entreprise',$inc)!==null){

      $result['status'] = false;
      $result['notif'] = notif('error','oups! cette entreprise existe déjà'); 
    
    }else{

      if($param == TRUE){

        $requete .= ', entreprise = :entreprise';
  
      }else{
  
        $requete .= 'entreprise = :entreprise';
      }
  
    $param = TRUE;  

    }

  }

  //modification contenu
  if($contenu !== $thisExe['contenu']){

    if($param == TRUE){

      $requete .= ', contenu = :contenu';

    }else{

      $requete .= 'contenu = :contenu';
    }
    
    $param = TRUE;  

  }

  //modification Url
  if($url !== $thisExe['url']){

    if($param == TRUE){

      $requete .= ', url = :url';

    }else{

      $requete .= 'url = :url';
    }
    
    $param = TRUE;  

  }

  //modification de la publication
  if($publie !== $thisExe['est_publie']){

    if($param == TRUE){

      $requete .= ', est_publie = :est_publie';

    }else{

      $requete .= 'est_publie = :est_publie';
    }
    
    $param = TRUE;  

  }

  //lancement de la requete
  $requete .= ' WHERE id_experience = :id';

  // préparation de la requete
  $req_update = $pdo->prepare($requete);
  $req_update->bindParam(':id',$id,PDO::PARAM_INT);

  if($titre !== $thisExe['titre']){
    $req_update->bindParam(':titre',$titre);
  }
  if($school !== $thisExe['entreprise']){
    $req_update->bindParam(':entreprise',$inc);
  }
  if($contenu !== $thisExe['contenu']){
    $req_update->bindParam(':contenu',$contenu);
  }
  if($url !== $thisExe['url']){
    $req_update->bindParam(':url',$url);
  }
  if($publie !== $thisExe['est_publie']){
      $req_update->bindValue(':est_publie',$publie,PDO::PARAM_BOOL);
  }
  
  $req_update->execute();

  $result['status'] = true;
  $result['notif'] = notif('success','Expérience modifiée');

  // préparation retour Ajax
  $query = $pdo->query('SELECT * FROM experiences');

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

  while($exe = $query->fetch()){

    // changement format date
    $date_from = str_replace('/', '-', $exe['start_date']);
    $date_to = str_replace('/', '-', $exe['stop_date']);

    $result['resultat'] .= '<tr>';
    $result['resultat'] .= '<td>'.$exe['id_experience'].'</td>';
    $result['resultat'] .= '<td>'.$exe['titre'].'</td>';
    $result['resultat'] .= '<td>'.$exe['entreprise'].'</td>';
    $result['resultat'] .= '<td>'.date('Y', strtotime($date_from)).'</td>';
    if($exe['actuel'] == 1 ){
      $result['resultat'] .= '<td><p class="badge actuel">Actuel</p></td>';
    }else{
      $result['resultat'] .= '<td>'.date('Y', strtotime($date_to)).'</td>';
    }

    if($Membre['statut'] == 0){

      if($exe['est_publie'] == 1){

        $result['resultat'] .= '<td> <input type="checkbox" id="est_publie" name="est_publie" class="est_publie" value='.$exe['est_publie'].' checked></td>';

      }else{

        $result['resultat'] .= '<td> <input type="checkbox" id="est_publie" name="est_publie" class="est_publie" value='.$exe['est_publie'].'></td>';

      }
      
      
      $result['resultat'] .= '<td class="member_action">';
          $result['resultat'] .= '<a href='.$exe['url'].' class="linkbtn"></a>';
          $result['resultat'] .= '<input type="button" class="viewbtn" name="view" id="'.$exe['id_experience'].'"></input>';
          $result['resultat'] .= '<input type="button" class="editbtn" id="'.$exe['id_experience'].'"></input>';
          $result['resultat'] .= '<input type="button" class="deletebtn"></input>';
      $result['resultat'] .= '</td>';

      }else{

        $result['resultat'] .= '<td class="member_action">';
          $result['resultat'] .= '<a href='.$exe['url'].' class="linkbtn"></a>';
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