<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';


/* #############################################################################

vue du modal update a partir langage.php en Ajax

############################################################################# */

if(isset($_POST['skill_id'])){

    $result = '';
    $id = $_POST['skill_id'];
    
    $query = $pdo->query("SELECT * FROM skills WHERE id_skill = '$id'");
    
    $result .= '<form action="" method="post" id="update_skill" enctype="multipart/form-data">';

        while($skill = $query->fetch()){

        $result .= '<input type="hidden" name="update_id" id="update_id" value="'.$skill['id_skill'].'">';


        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="update_titre">Nouveau titre: </label>';
            $result .= '<input type="text"  class="form-control" name="update_titre" id="update_titre" value="'.$skill['titre'].'">';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="skillRange" class="form-label">Pourcentage : </label>';
            $result .= '<input type="text" id="UpdaterangeReturn" value="'.$skill['number'].' %" class="prctVal"> ';
            $result .= '<input type="range" class="form-range" min="0" max="100" step="0.5" id="UpdateskillRange" name="UpdateskillRange" value="'.$skill['number'].'">';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
          $result .= '<label for="est publié" class="form_label">Publié : </label>';
        if($skill['est_publie'] == 1){
            $result .= '<td> <input type="checkbox" id="est_publie" name="est_publie" class="est_publie" value='.$skill['est_publie'].' checked></td>';
        }else{
            $result .= '<td> <input type="checkbox" id="est_publie" name="est_publie" class="est_publie" value='.$skill['est_publie'].'></td>';
        }
        $result .= '</div>';

    }

        $result .= '<div class="modal-footer">';
            $result .= '<button type="submit" name="update_skill" id="UpdateSkillBtn" class="updateBtn">Modifier</button>';
        $result .= '</div>';
    $result .= '</form>';

    echo $result;
}

?>