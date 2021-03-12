<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';
require_once __DIR__ . '/../../functions/soft_skills_functions.php';

/* #############################################################################

view d'une compétence a partir skil.php en Ajax

############################################################################# */

if(isset($_POST['skill_id'])){

  $result = '';
  $id = $_POST['skill_id'];
  
  $query = $pdo->query("SELECT * FROM skills WHERE id_skill = '$id'");

  $result .= '<div class="card" style="">';

  while($skill = $query->fetch()){

    $result .= '<div class="card-body">';
      $result .= '<h5 class="card-title">'.$skill['titre'].'</h5>';
      // $result .= '<p class="card-text">'.$post['contenu'].'</p>';
    $result .= '</div>';

    $result .= '<div class="table-responsive">';
      $result .= '<table class="table table-bordered">';

        $result .= '<tr>  
                        <td width="40%"><label>ID : </label></td>  
                        <td width="60%">'.$skill["id_skill"].'</td>  
                    </tr>';
        $result .= '<tr>  
                        <td width="40%"><label>Class :</label></td>  
                        <td width="60%">'.$skill["class"].'</td>  
                    </tr>';
        $result .= '<tr>  
                        <td width="40%"><label>Pourcentage :</label></td>  
                        <td width="60%">'.$skill["number"].'%</td>  
                    </tr>';
        }


      $result .= '</table>';
    $result .= '</div>';


    $result .='</div>';
  

    echo $result;

  }



?>


  
    
    
  
  
   