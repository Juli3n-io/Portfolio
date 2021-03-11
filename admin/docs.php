<?php

require_once __DIR__ . '/assets/config/bootstrap_admin.php';
require_once __DIR__ . '/assets/functions/docs_functions.php';


$page_title ='Docs';
include __DIR__. '/assets/includes/header_admin.php';
?>

<?php include __DIR__.'/../global/includes/flash.php';?>

<div class="notif" id='notif'></div>



<section class="recent">
  <div class="team__grid">
    <div class="team__card">
        <div class="card__header">
            <h3>Tous les documents </h3>
            
            <?php if($Membre['statut'] == 0) :?>
            <button id="add_doc_btn">
                <i class="fas fa-user-plus"></i>
                Ajouter
            </button>
            <?php endif;?>
        </div>

        <div class="table-responsive" id="doc_table">
          <table>

          <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Date d'ajout</th>
                <?php if($Membre['statut'] == 0) :?>
                <th>Actions</th>
                <?php endif;?>
            </tr>
          </thead>

          
              
          <tbody>
            <?php foreach(getDocs($pdo) as $doc): ?>
              <?php
                // changement format date
                $date = str_replace('/', '-', $doc['date_enregistrement']);
                ?>
                <tr>
                    <td><?=$doc['id_doc']?></td>
                    <td><?=$doc['titre']?></td>
                    <td><?= date('d-m-Y', strtotime($date))?> </td>
                    <td class="member_action">
                    <input type="button" class="viewbtn" name="view" id="<?=$doc['id_doc']?>"></input>

                        <?php if($Membre['statut'] == 0) :?>
                          
                          <input type="button" class="deletebtn"></input>
                        <?php endif;?>
                        
                    </td>
                </tr>


                
            <?php endforeach;?>
          </tbody>


        </table>
      </div> <!-- fin div table-responsive-->
       
    </div> <!-- fin div team card -->
  </div> <!-- fin div team grid -->


</section>

<div class="reset" id="reset">
  
</div>

<!-- ############################################## ***** Modal add doc ***** ########################################################## -->
<?php if($Membre['statut'] == 0) :?>

<div class="modal fade" id="addmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter un document</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" enctype="multipart/form-data" id="add_doc">


            <div class="mb-3 mt-4">
              <label for="add_name_member">Titre : </label>
              <input type="text" name="add_title" id="add_title" class="form-control">
            </div>
            
            <div class="mb-3 mt-4">
              <label for="add_img" class="form_label">Fichier : </label>
              <input type="file" 
              name="add_file" 
              id="add_file" 
              class="form-control">
            </div>


            <div class="modal-footer">
              <button type="submit" name="add_doc" id="add_doc_btn" class="addBtn">Ajouter</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>

<!-- ############################################## ***** Modal delete doc ***** ########################################################## -->


<div class="modal fade" id="deletemodal" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete doc</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="delete_doc">
          <input type="hidden" name="delete_id" id="delete_id">
            
          <p>Etes vous sur de vouloir supprimer ce document?</p>

          <input type="checkbox" id="confirmedelete" name="confirmedelete" class="confirmedelete">
           <label for="confirmedelete">OUI</label>
 
             <div class="modal-footer">
               <button type="submit" name="deletedoc"  id="deletedoc" class="disabledBtn" disabled="true">Supprimer</button>
             </div>
          </form>
      </div>
    </div>
  </div>
</div>


<!-- ############################################## ***** Modal view member ***** ########################################################## -->
  
  
<div class="modal fade" id="viewmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Fichier détail</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="doc_detail">
        
          
      </div>
    </div>
  </div>
</div>


<?php endif ;?>



<?php 
include __DIR__. '/assets/includes/footer_admin.php';
?>