<?php
require_once __DIR__ . './../../global/config/bootstrap.php';

/* #############################################################################

vue d'une experience en Ajax

############################################################################# */

if(isset($_POST['exe_id'])){

  $result = '';
  $id = $_POST['exe_id'];
  
  $query = $pdo->query("SELECT * FROM experiences WHERE id_experience = '$id'");

  $result .= '<div class="shape"></div>';

  while($exe = $query->fetch()){

    // changement format date
    $date_from = str_replace('/', '-', $exe['start_date']);
    $date_to = str_replace('/', '-', $exe['stop_date']);

    $result .= '<div class="modal-body">';
      $result .= '<div class="row">';

      $result .= '<div class="col-md-12">';
        $result .= '<div class="row">';

          $result .= '<div class="col-md-5">';
            $result .= '<h1 class="text-light">'.date('Y', strtotime($date_from)).' - '.date('Y', strtotime($date_to)).' </h1>';
          $result .= '</div>';

          $result .= '<div class="col-md-7 modal-text">';
            $result .= '<h4>'.$exe['titre'].'</h4>';
          $result .= '</div>';

        $result .= '</div>';
      $result .= '</div>';

      $result .= '<div class="col-md-12 modal-part-text">';
        $result .= '<p id="exeTxt">'.nl2br($exe['contenu']).'</p>';
      $result .= '</div>';

      $result .= '</div>';
    $result .= '</div>';
        
        }

  

    echo $result;

  }

?>