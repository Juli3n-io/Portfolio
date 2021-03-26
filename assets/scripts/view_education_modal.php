<?php
require_once __DIR__ . './../../global/config/bootstrap.php';

/* #############################################################################

vue d'une formation en Ajax

############################################################################# */

if(isset($_POST['edu_id'])){

  $result = '';
  $id = $_POST['edu_id'];
  
  $query = $pdo->query("SELECT * FROM education WHERE id_education = '$id'");

  $result .= '<div class="shape"></div>';

  while($edu = $query->fetch()){

    // changement format date
    $date_from = str_replace('/', '-', $edu['start_date']);
    $date_to = str_replace('/', '-', $edu['stop_date']);

    $result .= '<div class="modal-body">';
      $result .= '<div class="row">';

      $result .= '<div class="col-md-12">';
        $result .= '<div class="row">';

          $result .= '<div class="col-md-5">';
            $result .= '<h1 class="text-light">'.date('Y', strtotime($date_from)).' - '.date('Y', strtotime($date_to)).' </h1>';
          $result .= '</div>';

          $result .= '<div class="col-md-7 modal-text">';
            $result .= '<h4>'.$edu['titre'].'</h4>';
          $result .= '</div>';

        $result .= '</div>';
      $result .= '</div>';

      $result .= '<div class="col-md-12 modal-part-text">';
        $result .= '<p id="eduTxt">'.nl2br($edu['contenu']).'</p>';
      $result .= '</div>';

      $result .= '</div>';
    $result .= '</div>';
        
        }

  

    echo $result;

  }

?>