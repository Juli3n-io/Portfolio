<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/education_functions.php';

/* #############################################################################

vue d'une formation a partir education.php en Ajax

############################################################################# */

if(isset($_POST['edu_id'])){

  $result = '';
  $id = $_POST['edu_id'];
  
  $query = $pdo->query("SELECT * FROM education WHERE id_education = '$id'");

  $result .= '<div class="card" style="">';

  while($edu = $query->fetch()){

    // changement format date
    $date_from = str_replace('/', '-', $edu['start_date']);
    $date_to = str_replace('/', '-', $edu['stop_date']);

    $result .= '<div class="card-body">';
      $result .= '<h5 class="card-title">'.$edu['titre'].'</h5>';
      $result .= '<p class="card-text">'.$edu['contenu'].'</p>';
    $result .= '</div>';

    $result .= '<div class="table-responsive">';
      $result .= '<table class="table table-bordered">';

        $result .= '<tr>  
                        <td width="40%"><label>ID : </label></td>  
                        <td width="60%">'.$edu["id_education"].'</td>  
                    </tr>';
        $result .= '<tr>  
                        <td width="40%"><label>Début :</label></td>  
                        <td width="60%">'.date('Y', strtotime($date_from)).'</td>  
                    </tr>';
        $result .= '<tr>  
                        <td width="40%"><label>Fin :</label></td>  
                        <td width="60%">'.date('Y', strtotime($date_to)).'</td>  
                    </tr>';
        }


      $result .= '</table>';
    $result .= '</div>';


    $result .='</div>';
  

    echo $result;

  }

?>