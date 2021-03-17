<?php

require_once __DIR__ . '/assets/config/bootstrap_admin.php';
require_once __DIR__ . '/assets/functions/experiences_functions.php';


$page_title ='Expériences';
include __DIR__. '/assets/includes/header_admin.php';

?>

<div id="notif"></div>


<section class="recent">
  <div class="team__grid">
    <div class="team__card">
        <div class="card__header">
            <h3>Toutes les Expériences </h3>
            <?php if($Membre['statut'] == 0) :?>
            <button id="add_exe_modal">
                <i class="fas fa-plus"></i>
                Ajouter
            </button>
            <?php endif;?>
        </div>

        <div class="table-responsive" id="exe_table">
          <table>

          <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Entreprise</th>
                <th>Début</th>
                <th>Fin</th>
                <?php if($Membre['statut'] == 0) :?>
                <th>Publié</th>
                <th>Actions</th>
                <?php else:?>
                <th>Action</th>
                <?php endif;?>
            </tr>
          </thead>

          
              
          <tbody>
            <?php foreach(getExe($pdo) as $exe): ?>

              <?php
                // changement format date
                $date_from = str_replace('/', '-', $exe['start_date']);
                $date_to = str_replace('/', '-', $exe['stop_date']);

                ?>
                
                <tr>
                    <td><?=$exe['id_experience']?></td>
                    
                    <td><?=$exe['titre']?></td>
                    <td><?=$exe['entreprise']?></td>

                    <td><?= date('Y', strtotime($date_from))?></td>
                    
                    <?php
                    if($exe['actuel'] == 1){
                      echo '<td><p class="badge actuel">Actuel</p></td>';
                    }else{
                      echo '<td>'. date('Y', strtotime($date_to)).'</td> ';
                    }
                    ?>
                    
                    <?php if($Membre['statut'] == 0) :?>
                      
                    <td> <input type="checkbox" id="est_publie" name="est_publie" class="est_publie" value="<?= $exe['est_publie'] ?>" <?= ($exe['est_publie'] == 1) ? 'checked' : '' ;?>></td>

                    <td class="member_action">
                         
                          <a href="<?= $exe['url']?>" class="linkbtn"></a>
                          <input type="button" class="viewbtn" name="view" id="<?=$exe['id_experience']?>"></input>
                          <input type="button" class="editbtn" id="<?=$exe['id_experience']?>"></input>
                          <input type="button" class="deletebtn"></input>
                          
                    </td>
                    <?php else:?>

                    <td class="member_action">
                         
                          <a href="<?= $exe['url']?>" class="linkbtn"></a>
                          
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
  <!-- ############################################## ***** Modal add expériences ***** ########################################################## -->

<div class="modal fade" id="addmodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ajouter une Expérience</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" enctype="multipart/form-data" id="add_exe">

            <div class="mb-3 mt-4">
              <label for="add_name_member">Nom de l'Expérience : </label>
              <input type="text" 
              name="add_name_exe" 
              id="add_name_exe" 
              class="form-control">
            </div>

            <div class="mb-3 mt-4">
              <label for="add_name_member">Entreprise : </label>
              <input type="text" 
              name="add_inc" 
              id="add_inc" 
              class="form-control">
            </div>

            <div class="mb-3 mt-4">
              <label for="add_contenu" class="form_label">Contenu : </label>
              <textarea
              name="add_contenu_exe" 
              id="add_contenu" 
              class="form-control"></textarea>
            </div>

            <div class="mb-3 mt-4">
              <label for="from" class="form_label">Début :</label>
              <input type="text" id="from" name="from" class="from form-control">
            </div>

            <div class="mb-3 mt-4">
              <label for="est publié" class="form_label">Poste Actuel : </label>
                <div class="form-check">
                <input type="checkbox" id="actuel" name="actuel" class="actuel">
                <label for="confirmedelete">OUI</label>
                </div>
            </div>

            <div class="mb-3 mt-4 fin">
              <label for="to" class="form_label">Fin :</label>
              <input type="text" id="to" name="to" class="to form-control">
            </div>

            <div class="mb-3 mt-4">
              <label for="add_url" class="form_label">Url : </label>
              <input type="text" 
              name="add_url" 
              id="add_url" 
              class="form-control">
            </div>

            <div class="mb-3 mt-4">
              <label for="est publié" class="form_label">Publié : </label>
                <div class="form-check">
                <input type="checkbox" id="est_publie" name="est_publie" class="confirmedelete">
                <label for="confirmedelete">OUI</label>
                </div>
            </div>


            
            <div class="modal-footer">
              <button type="submit" name="add_exe" id="addExeBtn" class="disabledBtn" disabled="true">Ajouter</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>


<!-- ############################################## ***** Modal edit expérience ***** ########################################################## -->

 
 <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Modifier Experience</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body" id="update_modal">
          <form action="" method="post" id="update_exe" enctype="multipart/form-data">

          

            <div class="modal-footer">
              <button type="submit" name="update_exe" id="UpdateExeBtn" class="updateBtn">Modifier</button>
            </div>
          </form>
       </div>
     </div>
   </div>
 </div>
 
 
 
 <!-- ############################################## ***** Modal delete exeperience  ***** ########################################################## -->
 
 
 <div class="modal fade" id="deletemodal" >
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title">Delete Experience</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body">
         <form action="" method="post" id="delete_exe">
           <input type="hidden" name="delete_id" id="delete_id">
             
           <p>Etes vous sur de vouloir supprimer cette formation?</p>
 
           <input type="checkbox" id="confirmedelete" name="confirmedelete" class="confirmedelete">
           <label for="confirmedelete">OUI</label>
 
             <div class="modal-footer">
               <button type="submit" name="deleteEdu"  id="deleteEdu" class="disabledBtn" disabled="true">Supprimer</button>
             </div>
           </form>
       </div>
     </div>
   </div>
 </div>


 <!-- ############################################## ***** Modal view experience ***** ########################################################## -->
  
  
<div class="modal fade" id="viewmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Expérience détails</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="exe_detail">
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