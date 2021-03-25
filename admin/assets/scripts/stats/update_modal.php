<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';


/* #############################################################################

vue du modal update a partir stast.php en Ajax

############################################################################# */

if(isset($_POST['link_id'])){

    $result = '';
    $id = $_POST['link_id'];
    
    $query = $pdo->query("SELECT * FROM origin_clicks WHERE id = '$id'");
    
    $result .= '<form action="" method="post" id="update_link" enctype="multipart/form-data">';

        while($link = $query->fetch()){

        $result .= '<input type="hidden" name="update_id" id="update_id" value="'.$link['id'].'">';

        $result .= '<div class="img-logo"><i class="'.$link['icone'].'"></i></div>';

        $result .= '<span class="hiddenFileInput plus" id="changeIcone">';
            $result .= '<input type="button" >';
        $result .= '</span>';

        $result .= '<div class="mb-3 mt-4 dnone" id="div_new_logo">';
          $result .= '<label for="new_logo">Nouveau Logo : </label>';
          $result .= '<input type="text"  class="form-control" name="new_logo" id="new_logo" value="'.$link['icone'].'">';
        $result .= '</div>';

        $result .= '<div class="mb-3 mt-4">';
            $result .= '<label for="update_titre">Titre: </label>';
            $result .= '<input type="text"  class="form-control" name="update_titre" id="update_titre" value="'.$link['titre'].'">';
        $result .= '</div>';

        
    }

        $result .= '<div class="modal-footer">';
            $result .= '<button type="submit" name="update_link" id="UpdatelinkBtn" class="updateBtn">Modifier</button>';
        $result .= '</div>';
    $result .= '</form>';

    echo $result;
}

?>