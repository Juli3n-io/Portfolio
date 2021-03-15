<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';


/* #############################################################################

vue du modal update a partir education.php en Ajax

############################################################################# */

if(isset($_POST['edu_id'])){

    $result = '';
    $id = $_POST['edu_id'];
    
    $query = $pdo->query("SELECT * FROM education WHERE id_education = '$id'");
    
    $result .= '<form action="" method="post" id="update_edu" enctype="multipart/form-data">';

        while($edu = $query->fetch()){

            $date_from = str_replace('/', '-', $edu['start_date']);
            $date_to = str_replace('/', '-', $edu['stop_date']);

        $result .= '<input type="hidden" name="update_id" id="update_id" value="'.$edu['id_education'].'">';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="update_titre">Nom de la formation : </label>';
            $result .= '<input type="text"  class="form-control" name="update_titre" id="update_titre" value="'.$edu['titre'].'">';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="update_school">School : </label>';
            $result .= '<input type="text"  class="form-control" name="update_school" id="update_school" value="'.$edu['school'].'">';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="update_contenu">Contenu : </label>';
            $result .= '<textarea class="form-control" id="update_contenu" name="update_contenu">'.nl2br($edu['contenu']).'</textarea>';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="update_url">Url : </label>';
            $result .= '<input type="text"  class="form-control" name="update_url" id="update_url" value="'.$edu['url'].'">';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="updatefrom" class="form_label">Début : '.date("Y", strtotime($date_from)).'</label>';
            $result .= '<input type="text" id="updatefrom" name="updatefrom" class="from form-control">';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="updateto" class="form_label">Fin : '.date("Y", strtotime($date_to)).'</label>';
            $result .= '<input type="text" id="updateto" name="updateto" class="to form-control">';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="est publié" class="form_label">Publié : </label>';
            if($edu['est_publie'] == 1){
                $result .= '<td> <input type="checkbox" id="est_publie" name="est_publie" class="est_publie" value='.$edu['est_publie'].' checked></td>';
            }else{
                $result .= '<td> <input type="checkbox" id="est_publie" name="est_publie" class="est_publie" value='.$edu['est_publie'].'></td>';
            }
        $result .= '</div>';
    }

        $result .= '<div class="modal-footer">';
            $result .= '<button type="submit" name="update_edu" id="UpdateEduBtn" class="updateBtn">Modifier</button>';
        $result .= '</div>';
    $result .= '</form>';

    echo $result;
}

?>