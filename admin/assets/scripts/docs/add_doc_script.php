<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';


/* #############################################################################

Ajout d'un doc a partir docs.php en Ajax

############################################################################# */

$result = array();

if(!empty($_POST)){

  $titre = $_POST['add_title'];

if(empty($titre)){

  $result['status'] = false;
  $result['notif'] = notif('error','oups!  il manque le titre');
  
  
}elseif(empty($_FILES["add_file"]["tmp_name"])){

  $result['status'] = false;
  $result['notif'] = notif('error','oups!  il manque le fichier');

}else{

  //insertion du fichier
  $extension = pathinfo($_FILES['add_file']['name'], PATHINFO_EXTENSION);
  $path = __DIR__.'/../../../../global/uploads';
  // Allow certain file formats 
  $allowTypes = array('pdf', 'page', 'doc', 'docx'); 

  if($_FILES['add_file']['error'] !== UPLOAD_ERR_OK) {

    $result['status'] = false;
    $result['notif'] = notif('warning','Probléme lors de l\'envoi du fichier.code '.$_FILES['add_file']['error']);

  }elseif(!in_array($extension, $allowTypes)){

    $result['status'] = false;
    $result['notif'] = notif('error','Le fichier envoyé n\'est pas accepté'); 

  }else{
  
    $filename = pathinfo($_FILES['add_file']['name'], PATHINFO_FILENAME);
    $complete_path = $path.'/'.$filename.'.'.$extension;

  }// fin if img

  if(!move_uploaded_file($_FILES['add_file']['tmp_name'],$complete_path)){

    $result['status'] = false;
    $result['notif'] = notif('error','Le fichier n\'a pas pu être enregistré'); 

    }else{

      $req = $pdo->prepare('INSERT INTO docs(titre, fichier, date_enregistrement) VALUES (:titre, :fichier, :date)');
              
      $req->bindValue(':titre',$titre);
      $req->bindValue(':fichier',$filename.'.'.$extension);
      $req->bindValue(':date',(new DateTime())->format('Y-m-d H:i:s'));
      $req->execute();

      $result['status'] = true;
      $result['notif'] = notif('success','fichier ajouté');

      // préparation retour Ajax
  $query = $pdo->query('SELECT * FROM docs');

  //retour ajax table
  $result['resultat'] = '<table>';

  $result['resultat'] .= '<thead>
                              <tr>
                                <th>ID</th>
  
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

    
} // else

}// fin if global

// Return result 
echo json_encode($result);
?>