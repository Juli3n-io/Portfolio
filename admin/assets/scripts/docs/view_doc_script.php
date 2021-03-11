<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';


/* #############################################################################

vue doc a partir docs.php en Ajax

############################################################################# */


if(isset($_POST['doc_id'])){

  $result = '';
  $id = $_POST['doc_id'];

  $query = $pdo->query("SELECT * FROM docs WHERE id_doc = '$id'");

  while($doc = $query->fetch()){

    $result .= '<div class="iframe_container">';
      $result .= '<iframe allowfullscreen  style="width: 100%" src="../global/uploads/'.$doc['fichier'].'" ></iframe>';
    $result .= '</div>';
  }

echo $result;
}

?>