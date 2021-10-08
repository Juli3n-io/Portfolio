<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/reviews_functions.php';

/* #############################################################################

view d'un post a partir reviews.php en Ajax

############################################################################# */

if (isset($_POST['reviews_id'])) {

  $result = '';
  $id = $_POST['reviews_id'];

  $query = $pdo->query("SELECT * FROM reviews WHERE id = '$id'");

  $result .= '<div class="card" style="">';

  while ($reviews = $query->fetch()) {

    // changement format date
    $date = str_replace('/', '-', $reviews['date_enregistrement']);


    $result .= '<div class="card-body">';
    $result .= '<h5 class="card-title">' . $reviews['name'] . '</h5>';
    $result .= '<p class="card-text">' . $reviews['company'] . '</p>';
    $result .= '<p class="card-text">' . nl2br($reviews['contenu']) . '</p>';
    $result .= '</div>';

    $result .= '<div class="table-responsive">';
    $result .= '<table class="table table-bordered">';

    $result .= '<tr>  
                        <td width="40%"><label>ID : </label></td>  
                        <td width="60%">' . $reviews["id"] . '</td>  
                    </tr>';
    $result .= '<tr>
                      <td width="40%"><label>Note : </label></td>  
                      <td width="60%">' . stars($reviews["note"]) . '</td>  
                </tr>';
    $result .= '<tr>  
                        <td width="40%"><label>Date :</label></td>  
                        <td width="60%">' . date('m-Y', strtotime($date)) . '</td>  
                    </tr>';
  }


  $result .= '</table>';
  $result .= '</div>';


  $result .= '</div>';


  echo $result;
}
