<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/experiences_functions.php';

/* #############################################################################

Ajout d'une experiences a partir education.php en Ajax

############################################################################# */

$result = array(); 

if(!empty($_POST)){ 

  $titre = $_POST['add_name_exe'];
  $entreprise = $_POST['add_inc'];
  $contenu = $_POST['add_contenu_exe'];
  $url = $_POST['add_url'];
  $actuel = 'on';


  if(empty($titre)){

    $result['status'] = false;
    $result['notif'] = notif('warning','oups! il manque le titre'); 

  }elseif(getExeBy($pdo,'titre',$titre)!==null){

    $result['status'] = false;
    $result['notif'] = notif('warning','oups! cette expérience existe déjà'); 

  }elseif(empty($entreprise)){

    $result['status'] = false;
    $result['notif'] = notif('warning','oups! il manque l\' entreprise'); 

  }elseif(empty($contenu)){

    $result['status'] = false;
    $result['notif'] = notif('warning','oups! il manque une description'); 

  }elseif(empty($url)){

    $result['status'] = false;
    $result['notif'] = notif('warning','oups! il manque l\'adresse du site'); 

  }else{

    $req = $pdo->prepare('INSERT INTO experiences (titre, entreprise, contenu, url, start_date, stop_date, actuel, est_publie)
                          VALUES(:titre, :entreprise, :contenu, :url, :start_date, :stop_date, :actuel, :publie)');
                    
    $req->bindParam(':titre',$titre);
    $req->bindParam(':entreprise',$entreprise);
    $req->bindParam(':contenu',$contenu);
    $req->bindParam(':url',$url);
    $req->bindValue(':start_date',(new DateTime($_POST['from']))->format('Y-m-d'));
    if(isset($_POST['actuel'])){
      $req->bindValue(':stop_date',(new DateTime())->format('Y-m-d'));
    }else{
      $req->bindValue(':stop_date',(new DateTime($_POST['to']))->format('Y-m-d'));
    }
    $req->bindValue(':actuel',isset($_POST['actuel']),PDO::PARAM_BOOL);
    $req->bindValue(':publie',isset($_POST['est_publie']),PDO::PARAM_BOOL);
    $req->execute();

    $result['status'] = true;
    $result['notif'] = notif('success','Nouvelle Expérience ajoutée');

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



}
// Return result 
echo json_encode($result);
?>