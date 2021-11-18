<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/reviews_functions.php';

/* #############################################################################

delete d'une reviews a partir reviews.php en Ajax

############################################################################# */

if (!empty($_POST)) {

  $result = array();
  $id = $_POST['id'];
  $logo = $_POST['img'];
  $confirme = 'on';

  // validation en back de la confirmation de la suppression
  if (($_POST['confirmedelete']) !== $confirme) {

    $result['status'] = false;
    $result['notif'] = notif('error', 'Merci de confirmer la suppression');
  } else {

    //suppresion du logo
    $data = $pdo->query("SELECT * FROM reviews_logo WHERE id = '$logo'");
    $photo = $data->fetch(PDO::FETCH_ASSOC);

    $file = __DIR__ . '/../../../../global/uploads/';
    $dir = opendir($file);
    unlink($file . $photo['logo']);
    closedir($dir);

    $req1 = $pdo->exec("DELETE FROM reviews_logo WHERE id = '$logo'");

    //suppresion de la categorie de la BDD
    $req = $pdo->exec("DELETE FROM reviews WHERE id = '$id'");

    $result['status'] = true;
    $result['notif'] = notif('success', 'Reviews, supprimée');

    $query = $pdo->query('SELECT * FROM reviews');

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

      $result['resultat'] .= '<td>' . $row['company'] . '</td>;
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


echo json_encode($result);
