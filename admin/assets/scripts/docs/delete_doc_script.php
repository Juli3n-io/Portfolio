<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/assets/functions/docs_functions.php';


/* #############################################################################

delete doc a partir docs.php en Ajax

############################################################################# */

$result = array();

if(!empty($_POST)){

  $id = $_POST['id'];
  $confirme = 'on';

  if(($_POST['confirmedelete']) !== $confirme ){

    $result['status'] = false;
    $result['notif'] = notif('error','Merci de confirmer la suppression');

  }else{

    //suppresion du fichier
    $data = $pdo->query("SELECT * FROM docs WHERE id_doc = '$id'");
    $doc = $data->fetch(PDO::FETCH_ASSOC);


    $file =__DIR__.'/../../../../global/uploads/';
    $dir = opendir($file);
    unlink($file.$doc['fichier']);
    closedir($dir);

    $req = $pdo->exec("DELETE FROM docs WHERE id_doc = '$id'");

    $result['status'] = true;
    $result['notif'] = notif('success','Fichier supprimé');

    // préparation retour Ajax
  $query = $pdo->query('SELECT * FROM docs');

  //retour ajax table
  $result['resultat'] = '<table>';

  $result['resultat'] .= '<thead>
                              <tr>
                                <th>ID</th>
                                <th><i class="fas fa-file-download"></i></th>
                                <th>Titre</th>
                                <th>Date d\'ajout</th> ';
                                if($Membre['statut'] == 0){
                                  $result['resultat'] .= '<th>Actions</th>';
                                }
 $result['resultat'] .=  '</tr>
                      </thead>';

while($doc = $query->fetch()){

  // changement format date
  $date = str_replace('/', '-', $doc['date_enregistrement']);

  $result['resultat'] .= '<tr>';
  $result['resultat'] .= '<td>'.$doc['id_doc'].'</td>';
  $result['resultat'] .= '<td>'.$doc['titre'].'</td>';
  $result['resultat'] .= '<td>'.getClick($pdo, $doc["id_doc"]).'</td>';
  $result['resultat'] .= ' <td>'.date('d-m-Y', strtotime($date)).'</td>';

  if($Membre['statut'] == 0){
    $result['resultat'] .= '<td class="member_action">';
        $result['resultat'] .= '<input type="button" class="viewbtn" name="view" id="'.$doc['id_doc'].'"></input>';
        $result['resultat'] .= '<input type="button" class="deletebtn"></input>';
    $result['resultat'] .= '</td>';
    }

    $result['resultat'] .= '</tr>';


} // end while

$result['resultat'] .= '</tbody>';

$result['resultat'] .= '</table>';


  }
}// fin if global
// Return result 
echo json_encode($result);
?>