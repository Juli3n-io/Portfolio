<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';


/* #############################################################################

Ajout d'un link a partir stats.php en Ajax

############################################################################# */

$result = array(); 

// If form is submitted 
if(!empty($_POST)){ 

  $titre = $_POST['add_titre'];
  $url = 'https://julien-quentier.fr';
  $icone = $_POST['add_logo'];

  if(empty($titre)){

    $result['status'] = false;
    $result['notif'] = notif('error','oups! manque le titre'); 

  }elseif(empty($icone)){

    $result['status'] = false;
    $result['notif'] = notif('error','oups!  il manque le logo'); 

  }elseif(empty($url)){

    $result['status'] = false;
    $result['notif'] = notif('error','oups!  il manque l\'url'); 

  }else{

    $token = bin2hex(random_bytes(16));
    $complet_url = $url . '?from=' . $token;

    $req = $pdo->prepare('INSERT INTO origin_clicks(titre, icone, nb_clicks, url, token) VALUES (:titre, :icone, :nb_clicks, :url, :token)');
        
    $req->bindParam(':titre',$titre);
    $req->bindValue(':icone',$icone);
    $req->bindValue(':nb_clicks',0);
    $req->bindParam(':url',$complet_url);
    $req->bindParam(':token',$token);
    $req->execute();

  $result['status'] = true;
  $result['notif'] = notif('success','Nouveau link ajouté');

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

}

// Return result 
echo json_encode($result);

?>