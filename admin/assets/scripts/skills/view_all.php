<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';


/* #############################################################################

view all skills  skills.php en Ajax

############################################################################# */

$result = array(); 

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

// Return result 
echo json_encode($result);
?>