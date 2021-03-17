<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';


/* #############################################################################

vue du modal update a partir experiences.php en Ajax

############################################################################# */

if(isset($_POST['exe_id'])){

    $result = '';
    $id = $_POST['exe_id'];
    
    $query = $pdo->query("SELECT * FROM experiences WHERE id_experience = '$id'");
    
    $result .= '<form action="" method="post" id="update_exe" enctype="multipart/form-data">';

        while($exe = $query->fetch()){

            $date_from = str_replace('/', '-', $exe['start_date']);
            $date_to = str_replace('/', '-', $exe['stop_date']);

        $result .= '<input type="hidden" name="update_id" id="update_id" value="'.$exe['id_experience'].'">';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="update_titre">Nom de la formation : </label>';
            $result .= '<input type="text"  class="form-control" name="update_titre" id="update_titre" value="'.$exe['titre'].'">';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="update_school">Entreprise : </label>';
            $result .= '<input type="text"  class="form-control" name="update_inc" id="update_inc" value="'.$exe['entreprise'].'">';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="update_contenu">Contenu : </label>';
            $result .= '<textarea class="form-control" id="update_contenu" name="update_contenu">'.nl2br($exe['contenu']).'</textarea>';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="update_url">Url : </label>';
            $result .= '<input type="text"  class="form-control" name="update_url" id="update_url" value="'.$exe['url'].'">';
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
            if($exe['est_publie'] == 1){
                $result .= '<td> <input type="checkbox" id="est_publie" name="est_publie_update" class="est_publie_update" value='.$exe['est_publie'].' checked></td>';
            }else{
                $result .= '<td> <input type="checkbox" id="est_publie" name="est_publie_update" class="est_publie_update" value='.$exe['est_publie'].'></td>';
            }
        $result .= '</div>';
    }

        $result .= '<div class="modal-footer">';
            $result .= '<button type="submit" name="update_exe" id="UpdateExeBtn" class="updateBtn">Modifier</button>';
        $result .= '</div>';
    $result .= '</form>';

    echo $result;
}

?>