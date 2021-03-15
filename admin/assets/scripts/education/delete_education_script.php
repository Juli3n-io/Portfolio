<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/education_functions.php';

/* #############################################################################

Ajout d'une formation a partir education.php en Ajax

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
    $req = $pdo->exec("DELETE FROM education WHERE id_education = '$id'");

    $result['status'] = true;
    $result['notif'] = notif('success','Formation, supprimée');

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


  echo json_encode($result);
}

?>