<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/reviews_functions.php';

/* #############################################################################

Ajout d'une review a partir reviews.php en Ajax

############################################################################# */

$result = array();

if (!empty($_POST)) {

  $name = $_POST['add_name'];
  $company = $_POST['add_company'];
  $contenu = $_POST['add_contenu'];
  $note = $_POST['note'];
  $url = $_POST['add_url'];
  $logo = NULL;

  if (empty($name)) {

    $result['status'] = false;
    $result['notif'] = notif('warning', 'oups! il manque le nom');
  } elseif (empty($company)) {

    $result['status'] = false;
    $result['notif'] = notif('warning', 'oups! il manque l\'entreprise');
  } elseif (empty($contenu)) {

    $result['status'] = false;
    $result['notif'] = notif('warning', 'oups! il manque une description');
  } elseif (empty($note)) {

    $result['status'] = false;
    $result['notif'] = notif('warning', 'oups! il manque la note');
  } else {

    if (!$_FILES['add_logo']) {

      //insertion de l'image
      $extension = pathinfo($_FILES['add_logo']['name'], PATHINFO_EXTENSION);
      $path = __DIR__ . '/../../../../global/uploads';
      // Allow certain file formats 
      $allowTypes = array('svg', 'jpg', 'png', 'jpeg', 'webp');

      if ($_FILES['add_logo']['error'] !== UPLOAD_ERR_OK) {

        $result['status'] = false;
        $result['notif'] = notif('warning', 'Probléme lors de l\'envoi du fichier.code ' . $_FILES['add_logo']['error']);
      } elseif ($_FILES['add_logo']['size'] < 12 || !in_array($extension, $allowTypes)) {

        $result['status'] = false;
        $result['notif'] = notif('error', 'Le fichier envoyé n\'est pas une image');
      } else {

        do {
          $filename = bin2hex(random_bytes(16));
          $complete_path = $path . '/' . $filename . '.' . $extension;
        } while (file_exists($complete_path));
      }

      if (!move_uploaded_file($_FILES['add_logo']['tmp_name'], $complete_path)) {

        $result['status'] = false;
        $result['notif'] = notif('error', 'La photo n\'a pas pu être enregistrée');
      } else {


        $req1 = $pdo->prepare('INSERT INTO reviews_logo(logo) VALUES (:logo)');

        $req1->bindValue(':logo', $filename . '.' . $extension);
        $req1->execute();
      }

      $logo = $pdo->lastInsertId();
    }

    $req2 = $pdo->prepare('INSERT INTO reviews(name,
                                              company, 
                                              contenu,
                                              note,
                                              logo_id,
                                              url, 
                                              date_enregistrement,
                                              est_publie) 
                                    VALUES (:name,
                                            :company,
                                            :contenu, 
                                            :note,
                                            :logo,
                                            :url, 
                                            :date,
                                            :publie)');

    $req2->bindParam(':name', $name);
    $req2->bindParam(':company', $company);
    $req2->bindParam(':contenu', $contenu);
    $req2->bindParam(':note', $note);
    $req2->bindValue(':logo', $logo);
    $req2->bindParam(':url', $url);
    $req2->bindValue(':date', (new DateTime())->format('Y-m-d H:i:s'));
    $req2->bindValue(':publie', isset($_POST['est_publie']), PDO::PARAM_BOOL);
    $req2->execute();

    $result['status'] = true;
    $result['notif'] = notif('success', 'Nouveau commentaire ajouté');

    //retour ajax card
    $result['cards'] = '<div class="card__single card_visites">
                              <div class="card__body">
                                <i class="fas fa-folder-open"></i>
                                <div>
                                  <h5>Tous les avis</h5>
                                  <h4>' . countReviews($pdo) . '</h4>
                                </div>
                              </div>
                              <div class="card__footer">
                                <input type="button" name="all" id="all" value="View All">
                              </div>
                          </div>';

    $result['cards'] .= '<div class="card__single card_visites">
                              <div class="card__body">
                                <i class="far fa-eye"></i>
                                <div>
                                  <h5>Publiés</h5>
                                  <h4>' . countReviewsPublie($pdo) . '</h4>
                                </div>
                              </div>
                              <div class="card__footer">
                                <input type="button" name="all_publie" id="all_publie" value="View All">
                            </div>
                          </div>';

    $result['cards'] .= '<div class="card__single card_visites">
                              <div class="card__body">
                                  <i class="far fa-eye-slash"></i>
                                <div>
                                    <h5>Non Publiés</h5>
                                    <h4>' . countReviewsNonPublie($pdo) . '</h4>
                                </div>
                              </div>
                              <div class="card__footer">
                                <input type="button" name="non_publie" id="non_publie" value="View All">
                              </div>
                            </div>';

    $result['cards'] .= '<div class="card__single ">
                              <div class="card__body">
                                  <i class="fas fa-star"></i>
                                <div>
                                    <h5>Notes moyennes</h5>
                                    <h4>' . notesMoyenne($pdo) . '</h4>
                                </div>
                              </div>
                              <div class="card__footer">
                                
                              </div>
                            </div>';

    $record_per_page = 5;
    $page = '';
    $output = '';

    if (isset($_POST['page'])) {

      $page = $_POST['page'];
    } else {

      $page = 1;
    }

    $start_from = ($page - 1) * $record_per_page;

    // préparation retour Ajax
    $query = $pdo->query("SELECT * FROM reviews ORDER BY date_enregistrement ASC LIMIT $start_from,$record_per_page");

    //retour ajax table
    $result['resultat'] = '<table>';

    $result['resultat'] .=
      '<thead>
                              <tr>
                            <th>ID</th>
                            <th>Nom</th>
                             <th class="dnone">pics_id</th>
                            <th>Logo</th>
                            <th>Company</th>
                            <th>Notes</th>';
    if ($Membre['statut'] == 0) {
      $result['resultat'] .= ' <th>Publié</th>';
      $result['resultat'] .= '<th>Actions</th>';
    } else {
      $result['resultat'] .= '<th>Action</th>';
    }

    $result['resultat'] .=  '</tr>
                    </thead>';

    $result['resultat'] .= '<tbody>';

    while ($row = $query->fetch()) {

      $result['resultat'] .= '
                <tr>
                  <td>' . $row['id'] . '</td>
                  <td>' . $row['name'] . '</td>
                  <td class="dnone">' . $row["logo_id"] . '</td>';
      if ($row["logo_id"] != NULL) {
        $result['resultat'] .= '<td><div class="img-profil" style="background-image: url(../global/uploads/' . getLogo($pdo, $row["logo_id"]) . '")"></div></td>';
      } else {
        $result['resultat'] .= '<td> </td>';
      }
      $result['resultat'] .= '<td>' . $row['company'] . '</td>
                  <td>' . stars($row['note']) . '</td>';

      if ($Membre['statut'] == 0) {
        if ($row['est_publie']) {
          $result['resultat'] .= '<td> <input type="checkbox" id="est_publie" name="est_publie" class="est_publie" value=' . $row['est_publie'] . ' checked></td>';
        } else {
          $result['resultat'] .= '<td> <input type="checkbox" id="est_publie" name="est_publie" class="est_publie" value=' . $row['est_publie'] . '></td>';
        }

        $result['resultat']  .= '<td class="member_action">';
        $result['resultat']  .= '<a href=' . $row['url'] . ' class="linkbtn"></a>';
        $result['resultat']  .= '<input type="button" class="viewbtn" name="view" id="' . $row['id'] . '"></input>';
        $result['resultat']  .= '<input type="button" class="editbtn" id="' . $row['id'] . '"></input>';
        $result['resultat']  .= '<input type="button" class="deletebtn"></input>';
        $result['resultat']  .= '</td>';
      } else {

        $result['resultat']  .= '<td class="member_action">';
        $result['resultat']  .= '<a href=' . $row['url'] . ' class="linkbtn"></a>';
        $result['resultat']  .= '</td>';
      }

      $result['resultat'] .= '</tr>';
    }

    $result['resultat'] .= '</tbody >';

    $result['resultat'] .= '</table><br /><div  class="custom_pagination">';

    $page_query = $pdo->query('SELECT * FROM reviews ORDER BY date_enregistrement DESC');
    $total_records = $page_query->rowCount();
    $total_pages = ceil($total_records / $record_per_page);

    for ($i = 1; $i <= $total_pages; $i++) {

      if ($i == $page) {

        $result['resultat'] .= '<span 
                class="pagination_link active" id="' . $i . '">' . $i . '</span>';
      } else {

        $result['resultat'] .= '<span 
                class="pagination_link" id="' . $i . '">' . $i . '</span>';
      }
    } // fin for

  }
} // fin if global

// Return result 
echo json_encode($result);
