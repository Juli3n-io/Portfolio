<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/reviews_functions.php';

/* #############################################################################

vue du modal update a partir reviews.php en Ajax

############################################################################# */

if (isset($_POST['reviews_id'])) {

  $result = '';
  $id = $_POST['reviews_id'];

  $query = $pdo->query("SELECT * FROM reviews WHERE id = '$id'");

  $result .= '<form action="" method="post" id="update_reviews" enctype="multipart/form-data">';

  while ($reviews = $query->fetch()) {


    $result .= '<input type="hidden" name="update_id" id="update_id" value="' . $reviews['id'] . '">';
    $result .= '<input type="hidden" name="update_img" id="update_img" value="' . $reviews['logo_id'] . '">';

    $result .= '<img src="../global/uploads/' . getLogo($pdo, $reviews["logo_id"]) . '" alt="logo" class="update_reviews_logo" id="img-logo">';

    $result .= '<span class="hiddenFileInput">';
    $result .= '<input type="file" name="new_logo" id="new_logo">';
    $result .= '</span>';

    $result .= '<div class="mb-3 mt-4">';
    $result .= '<label for="update_name">Nom de la personne : </label>';
    $result .= '<input type="text"  class="form-control" name="update_name" id="update_name" value="' . $reviews['name'] . '">';
    $result .= '</div>';

    $result .= '<div class="mb-3 mt-4">';
    $result .= '<label for="update_company">Entreprise : </label>';
    $result .= '<input type="text"  class="form-control" name="update_company" id="update_company" value="' . $reviews['company'] . '">';
    $result .= '</div>';

    $result .= '<div class="mb-3 mt-4">';
    $result .= '<label for="update_contenu">Contenu : </label>';
    $result .= '<textarea class="form-control" id="update_contenu" name="update_contenu">' . nl2br($reviews['contenu']) . '</textarea>';
    $result .= '</div>';

    $result .= '<div class="mb-3 mt-4">';
    $result .= '<label for="update_url">Url : </label>';
    $result .= '<input type="text"  class="form-control" name="update_url" id="update_url" value="' . $reviews['url'] . '">';
    $result .= '</div>';

    $result .= '<div class="mb-3 mt-4">';
    $result .= '<label for="update_note">note actuelles : ' . stars($reviews['note']) . '</label>';
    $result .= '<select class="form-select" name="update_note">
                <option value="">Modifier la note actuelle :</option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                </select>';
    $result .= '</div>';

    $result .= '<div class="mb-3 mt-4">';
    $result .= '<label for="est publié" class="form_label">Publié : </label>';
    if ($reviews['est_publie'] == 1) {
      $result .= '<td> <input type="checkbox" id="est_publie" name="est_publie_update" class="est_publie_update" value=' . $reviews['est_publie'] . ' checked></td>';
    } else {
      $result .= '<td> <input type="checkbox" id="est_publie" name="est_publie_update" class="est_publie_update" value=' . $reviews['est_publie'] . '></td>';
    }
    $result .= '</div>';
  }

  $result .= '<div class="modal-footer">';
  $result .= '<button type="submit" name="update_reviews" id="UpdateReviewsBtn" class="updateBtn">Modifier</button>';
  $result .= '</div>';
  $result .= '</form>';

  echo $result;
}
