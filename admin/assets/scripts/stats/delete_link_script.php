<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';


/* #############################################################################

Suppression d'un linka partir stats.php en Ajax

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


     //suppresion du langage de la BDD
    $req = $pdo->exec("DELETE FROM origin_clicks WHERE id = '$id'");

    $result['status'] = true;
    $result['notif'] = notif('success','link supprimé');

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

  echo json_encode($result);
  }
?>