<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/experiences_functions.php';

/* #############################################################################

vue d'une experience a partir education.php en Ajax

############################################################################# */

if(isset($_POST['exe_id'])){

  $result = '';
  $id = $_POST['exe_id'];
  
  $query = $pdo->query("SELECT * FROM experiences WHERE id_experience = '$id'");

  $result .= '<div class="card" style="">';

  while($exe = $query->fetch()){

    // changement format date
    $date_from = str_replace('/', '-', $exe['start_date']);
    $date_to = str_replace('/', '-', $exe['stop_date']);

    $result .= '<div class="card-body">';
      $result .= '<h5 class="card-title">'.$exe['titre'].'</h5>';
      $result .= '<p class="card-text">'.nl2br($exe['contenu']).'</p>';
    $result .= '</div>';

    $result .= '<div class="table-responsive">';
      $result .= '<table class="table table-bordered">';

        $result .= '<tr>  
                        <td width="40%"><label>ID : </label></td>  
                        <td width="60%">'.$exe["id_experience"].'</td>  
                    </tr>';
        $result .= '<tr>  
                        <td width="40%"><label>Début :</label></td>  
                        <td width="60%">'.date('Y', strtotime($date_from)).'</td>  
                    </tr>';
        if($exe['actuel'] == 1){

          $result .= '<tr>  
                        <td width="40%"><label>Fin :</label></td>  
                        <td><p class="badge actuel">Actuel</p></td>  
                    </tr>';

        }else{

          $result .= '<tr>  
                        <td width="40%"><label>Fin :</label></td>  
                        <td width="60%">'.date('Y', strtotime($date_to)).'</td>  
                    </tr>';

        }
    }


      $result .= '</table>';
    $result .= '</div>';


    $result .='</div>';
  

    echo $result;

  }

?>