<?php

require_once __DIR__ . '/assets/config/bootstrap_admin.php';
require_once __DIR__ . '/assets/functions/soft_skills_functions.php';


$page_title ='Soft skills';
include __DIR__. '/assets/includes/header_admin.php';

?>

<div id="notif"></div>

<section>
  <div class="dash__cards" id="cards">

    <div class="card__single">
      <div class="card__body">
        <i class="fas fa-folder-open"></i>
        <div>
          <h5>Toutes les compétences</h5>
          <h4><?= countSkill($pdo)?></h4>
        </div>
      </div>
      <div class="card__footer">
      <input type="button" name="all" id="all" value="View All">
      </div>
    </div>

    <div class="card__single">
      <div class="card__body">
        <i class="far fa-eye"></i>
        <div>
          <h5>Publiées</h5>
          <h4><?= countSkillPublie($pdo)?></h4>
        </div>
      </div>
      <div class="card__footer">
      <input type="button" name="all_publie" id="all_publie" value="View All">
      </div>
    </div>

    <div class="card__single">
      <div class="card__body">
        <i class="far fa-eye-slash"></i>
        <div>
          <h5>Non Publiées</h5>
          <h4><?= countSkillNonPublie($pdo)?></h4>
        </div>
      </div>
      <div class="card__footer">
      <input type="button" name="non_publie" id="non_publie" value="View All">
      </div>
    </div>

  </div>
</section>

<section class="recent">
  <div class="recent__grid">
    <div class="team__card">
        <div class="card__header">
            <h3>Toutes les compétences </h3>
            <?php if($Membre['statut'] == 0) :?>
            <button id="add_skill_btn">
                <i class="fas fa-plus"></i>
                Ajouter
            </button>
            <?php endif;?>
        </div>

        <div class="table-responsive" id="skills_table">
          <table>

          <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>%</th>
                <?php if($Membre['statut'] == 0) :?>
                <th>Publié</th>
                <th>Actions</th>
                <?php endif;?>
            </tr>
          </thead>

          
              
          <tbody>
            <?php foreach(getSkill($pdo) as $skill): ?>
                
                <tr>
                    <td><?=$skill['id_skill']?></td>

                    <td><?=$skill['titre']?></td>
                    <td><?=$skill['number']?> %</td>
                    
                    <?php if($Membre['statut'] == 0) :?>

                    <td> <input type="checkbox" id="est_publie" name="est_publie" class="est_publie" value="<?= $skill['est_publie'] ?>" <?= ($skill['est_publie'] == 1) ? 'checked' : '' ;?>></td>

                    <td class="member_action">
                          <input type="button" class="viewbtn" name="view" id="<?=$skill['id_skill']?>"></input>
                          <input type="button" class="editbtn" id="<?=$skill['id_skill']?>"></input>
                          <input type="button" class="deletebtn"></input>
                          
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
  <!-- ############################################## ***** Modal add skill ***** ########################################################## -->

<div class="modal fade" id="addmodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ajouter une compétence</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" enctype="multipart/form-data" id="add_skill">

            <div class="mb-3">
              <label for="add_titre_skill">Titre de la compétence : </label>
              <input type="text" 
              name="add_titre_skill" 
              id="add_titre_skill" 
              class="form-control">
            </div>

            <div class="mb-3">
              <label for="skillRange" class="form-label">Pourcentage : </label>
              <input type="text" id="rangeReturn" value="" class="prctVal">
              <input type="range" class="form-range" min="0" max="100" value="0" step="0.5" id="skillRange" name="skillRange">
            </div>

            <div class="mb-3 mt-4">
              <label for="addPublie" class="form_label">Publié : </label>
                <div class="form-check">
                <input type="checkbox" id="est_publie" name="est_publie" class="addPublie">
                <label for="confirmedelete">OUI</label>
                </div>
            </div>
            
            <div class="modal-footer">
              <button type="submit" name="add_skill" id="addSkillBtn" class="disabledBtn" disabled="true">Ajouter</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>


<!-- ############################################## ***** Modal edit skill ***** ########################################################## -->

 
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
 
 
 
 <!-- ############################################## ***** Modal delete skill ***** ########################################################## -->
 
 
 <div class="modal fade" id="deletemodal" >
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title">Delete Compétence</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body">
         <form action="" method="post" id="delete_skill">
           <input type="hidden" name="delete_id" id="delete_id">
           <input type="hidden" name="delete_img" id="delete_img">
             
           <p>Etes vous sur de vouloir supprimer ce langage?</p>
 
           <input type="checkbox" id="confirmedelete" name="confirmedelete" class="confirmedelete">
           <label for="confirmedelete">OUI</label>
 
             <div class="modal-footer">
               <button type="submit" name="deleteskillbtn"  id="deleteskillbtn" class="disabledBtn" disabled="true">Supprimer</button>
             </div>
           </form>
       </div>
     </div>
   </div>
 </div>

<!-- ############################################## ***** Modal view skill ***** ########################################################## -->
  
  
<div class="modal fade" id="viewmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Skill détails</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="skill_detail">
        
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