<?php

require_once __DIR__ . '/assets/config/bootstrap_admin.php';
require_once __DIR__ . '/assets/functions/langages_functions.php';


$page_title ='Education';
include __DIR__. '/assets/includes/header_admin.php';

?>

<div id="notif"></div>


<section class="recent">
  <div class="team__grid">
    <div class="team__card">
        <div class="card__header">
            <h3>Toutes les Posts </h3>
            <?php if($Membre['statut'] == 0) :?>
            <button id="add_post_modal">
                <i class="fas fa-plus"></i>
                Ajouter
            </button>
            <?php endif;?>
        </div>

        <div class="table-responsive" id="edu_table">
          <table>

          <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Url</th>
                <?php if($Membre['statut'] == 0) :?>
                <th>Publié</th>
                <th>Actions</th>
                <?php else:?>
                <th>Action</th>
                <?php endif;?>
            </tr>
          </thead>

          
              
          <tbody>
            <?php foreach(getPost($pdo) as $post): ?>
                
                <tr>
                    <td><?=$post['id_post']?></td>
                    <td class="dnone"><?=$post['pics_id']?></td>
                    <?php if($post["pics_id"] !== NULL){
                      echo "<td><div class='img-profil' style='background-image: url(../global/uploads/". getImg($pdo, $post['pics_id']).")'></div></td>";
                    }else{
                      echo "<td></td>";
                    }
                    ?>  
                    <td><?=$post['titre']?></td>
                    <td><div class="td-cat"><?= getIcon($pdo, $post['categories_id'])?></div></td>
                    <td>0</td>
                    <td>0</td>
                    
                    <?php if($Membre['statut'] == 0) :?>
                      
                    <td> <input type="checkbox" id="est_publie" name="est_publie" class="confirmedelete" value="<?= $post['est_publie'] ?>" <?= ($post['est_publie'] == 1) ? 'checked' : '' ;?>></td>

                    <td class="member_action">
                         
                          <a href="<?= $post['url']?>" class="linkbtn"></a>
                          <input type="button" class="viewbtn" name="view" id="<?=$post['id_post']?>"></input>
                          <input type="button" class="editbtn" id="<?=$post['id_post']?>"></input>
                          <input type="button" class="deletebtn"></input>
                          
                    </td>
                    <?php else:?>

                    <td class="member_action">
                         
                          <a href="<?= $post['url']?>" class="linkbtn"></a>
                          
                    </td>

                    <?php endif;?>
                </tr>

                <?php endforeach;?>
          </tbody>

        </table>
      </div> <!-- fin div table-responsive-->
       
    </div> 
  </div> 

</section>



<?php if($Membre['statut'] == 0) :?>
  <!-- ############################################## ***** Modal add formation ***** ########################################################## -->

<div class="modal fade" id="addmodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ajouter une formation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" enctype="multipart/form-data" id="add_edu">

            <div class="mb-3">
              <label for="add_name_member">Nom du langage : </label>
              <input type="text" 
              name="add_name_lang" 
              id="add_name_lang" 
              class="form-control">
            </div>

            <div class="mb-3">
              <label for="add_logo">Logo : </label>
              <input type="text" 
              name="add_logo" 
              id="add_logo" 
              class="form-control">
            </div>

            <div class="mb-3">
              <label for="skillRange" class="form-label">Pourcentage : </label>
              <input type="text" id="rangeReturn" value="" class="prctVal">
              <input type="range" class="form-range" min="0" max="100" step="0.5" id="skillRange" name="skillRange">
            </div>


            
            <div class="modal-footer">
              <button type="submit" name="add_lang" id="addlangBtn" class="disabledBtn" disabled="true">Ajouter</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>


<!-- ############################################## ***** Modal edit language ***** ########################################################## -->

 
 <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Modifier Langage</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body" id="update_modal">
          <form action="" method="post" id="update_lang" enctype="multipart/form-data">

          

            <div class="modal-footer">
              <button type="submit" name="update_lang" id="UpdatelangBtn" class="updateBtn">Modifier</button>
            </div>
          </form>
       </div>
     </div>
   </div>
 </div>
 
 
 
 <!-- ############################################## ***** Modal delete langage ***** ########################################################## -->
 
 
 <div class="modal fade" id="deletemodal" >
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title">Delete Langage</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body">
         <form action="" method="post" id="delete_lang">
           <input type="hidden" name="delete_id" id="delete_id">
           <input type="hidden" name="delete_img" id="delete_img">
             
           <p>Etes vous sur de vouloir supprimer ce langage?</p>
 
           <input type="checkbox" id="confirmedelete" name="confirmedelete" class="confirmedelete">
           <label for="confirmedelete">OUI</label>
 
             <div class="modal-footer">
               <button type="submit" name="deletecat"  id="deletecat" class="disabledBtn" disabled="true">Supprimer</button>
             </div>
           </form>
       </div>
     </div>
   </div>
 </div>


 <!-- ############################################## ***** Modal view langage ***** ########################################################## -->
  
  
<div class="modal fade" id="viewmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Langage détails</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="lang_detail">
        <div class="list_container">
          
      </div>
      <div class="modal-footer">
        <button type="button" class="closeBtn" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>



<?php endif;?>

<?php 
include __DIR__. '/assets/includes/footer_admin.php';
?>