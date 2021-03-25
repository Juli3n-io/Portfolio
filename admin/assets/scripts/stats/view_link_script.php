<?php
require_once __DIR__ . '/../../config/bootstrap_admin.php';


/* #############################################################################

vue d'un link a partir stats.php en Ajax

############################################################################# */

if(isset($_POST['link_id'])){

    $result = '';
    $id = $_POST['link_id'];
    
    $query = $pdo->query("SELECT * FROM origin_clicks WHERE id = '$id'");
    
    $result .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
    while($link = $query->fetch()){

        $result .= '  
                <tr>  
                     <td width="30%"><label>ID</label></td>  
                     <td width="70%">'.$link["id"].'</td>  
                </tr>
                <tr>  
                     <td width="30%"><label>Logo :</label></td>  
                     <td width="70%"><div class="img-logo"><i class="'.$link['icone'].'"></i></div></td>  
                </tr> 
                <tr>  
                     <td width="30%"><label>Titre :</label></td>  
                     <td width="70%">'.$link["titre"].'</td>  
                </tr>
                <tr>  
                     <td width="30%"><label>Url :</label></td>  
                     <td width="70%">'.$link["url"].'</td>  
                </tr> 
                <tr>  
                     <td width="30%"><label>Nombre de clicks</label></td>  
                     <td width="70%">'.$link["nb_clicks"].'</td>  
                </tr>  
                ';  

    }

    $result .= "</table></div>"; 

    echo $result;

    
}

?>