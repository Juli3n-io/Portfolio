<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/experiences_functions.php';

/* #############################################################################

Delete d'une expérience a partir experience.php en Ajax

############################################################################# */

if(!empty($_POST)){

  $result = array();
  $id = $_POST['id'];
  $confirme = 'on';

  // validation en back de la confirmation de la suppression
    if(($_POST['confirmedelete']) !== $confirme ){

      $result['status'] = false;
      $result['notif'] = notif('error','Merci de confirmer la suppression');
  
    }else{

     //suppresion de la categorie de la BDD
    $req = $pdo->exec("DELETE FROM experiences WHERE id_experience = '$id'");

    $result['status'] = true;
    $result['notif'] = notif('success','Expérience, supprimée');

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


  echo json_encode($result);
}

?>