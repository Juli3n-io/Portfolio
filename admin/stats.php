<?php

require_once __DIR__ . '/assets/config/bootstrap_admin.php';
require_once __DIR__ . '/assets/functions/stats_functions.php';


$page_title ='Stats';
include __DIR__. '/assets/includes/header_admin.php';
?>

<?php include __DIR__.'/../global/includes/flash.php';?>

<div class="notif" id='notif'></div>

<section>
  <div class="dash__cards" id="cards">

  <div class="card__single card_visites">
      <div class="card__body">
        <i class="fas fa-street-view"></i>
        <div>
          <h5>En ligne</h5>
          <h4><?= $user_nbr; ?></h4>
        </div>
      </div>
      <div class="card__footer">

      </div>
    </div>

    <div class="card__single card_visites">
      <div class="card__body">
        <i class="fas fa-calendar-day"></i>
        <div>
          <h5>Aujourd'hui</h5>
          <h4><?= getDayVisites($pdo);?></h4>
        </div>
      </div>
      <div class="card__footer">

      </div>
    </div>

    <div class="card__single card_visites">
      <div class="card__body">
        <i class="far fa-calendar-alt"></i>
        <div>
          <h5>Ce mois-ci</h5>
          <h4><?= getMonth_Visites($pdo) ?></h4>
        </div>
      </div>
      <div class="card__footer">
      
      </div>
    </div>

    <div class="card__single card_visites">
      <div class="card__body">
        <i class="fas fa-globe-europe"></i>
        <div>
          <h5>Cette année</h5>
          <h4><?= getYear_Visites($pdo)?></h4>
        </div>
      </div>
      <div class="card__footer">

      </div>
    </div>

    <div class="card__single card_visites">
      <div class="card__body">
        <i class="fas fa-eye"></i>
        <div>
          <h5>Totales</h5>
          <h4><?= getTotales_Visites($pdo)?></h4>
        </div>
      </div>
      <div class="card__footer">

      </div>
    </div>

  </div>
</section>




<section class="recent">
  <div class="recent__grid">
    <div class="team__card">
      <div class="card__header">
        <h3>Stats des visites </h3>
      </div>

      <div class="table-responsive" id="pagination-data">

      </div>

    </div>
  </div>
</section>


<section class="recent">
  <div class="recent__grid">
    <div class="team__card">
        <div class="card__header">
            <h3>Origine des visites </h3>
            <?php if($Membre['statut'] == 0) :?>
            <button id="add_links_modal">
                <i class="fas fa-user-plus"></i>
                Ajouter
            </button>
            <?php endif;?>
        </div>

        <div class="table-responsive" id="stats_table">
          <table>

          <thead>
            <tr>
                <th>ID</th>
                <th>Logo</th>
                <th>Titre</th>
                <th>Clicks</th>
                <?php if($Membre['statut'] == 0) :?>
                <th>Actions</th>
                <?php endif;?>
            </tr>
          </thead>

          
              
          <tbody >
            <?php foreach(getLink($pdo) as $link): ?>

              <tr>
                    <td><?=$link['id']?></td>
                    <td><div class='img-logo'><i class="<?=$link['icone']?>"></i></div></td>

                    <td><?=$link['titre']?></td>
                    <td><?=$link['nb_clicks']?></td>
                    
                    <?php if($Membre['statut'] == 0) :?>
                    <td class="member_action">

                          <button class="copybtn" onclick="copyUrl(this)" value="<?=$link['url']?>" title="copier url"><i class="far fa-copy"></i></button>
                          <input type="button" class="viewbtn" name="view" id="<?=$link['id']?>"></input>
                          <input type="button" class="editbtn" id="<?=$link['id']?>"></input>
                          <input type="button" class="deletebtn"></input>
                          
                    </td>
                    <?php endif;?>
                </tr>

            <?php endforeach;?>
          </tbody>


        </table>
      </div> <!-- fin div table-responsive-->
       
    </div> <!-- fin div team card -->
  </div> <!-- fin div team grid -->


</section>


  
</div>

<!-- ############################################## ***** Modal add  ***** ########################################################## -->
<?php if($Membre['statut'] == 0) :?>

<div class="modal fade" id="addmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter un link</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" enctype="multipart/form-data" id="add_link">

        <div class="mb-3">
              <label for="add_name_member">Titre : </label>
              <input type="text" 
              name="add_titre" 
              id="add_titre" 
              class="form-control">
            </div>

            <div class="mb-3">
              <label for="add_logo">Logo : </label>
              <input type="text" 
              name="add_logo" 
              id="add_logo" 
              class="form-control">
            </div>


            <div class="modal-footer">
              <button type="submit" name="add_link" class="addBtn">Ajouter</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>

<!-- ############################################## ***** Modal delete  ***** ########################################################## -->


<div class="modal fade" id="deletemodal" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Link</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="delete_link">
          <input type="hidden" name="delete_id" id="delete_id">
            
          <p>Etes vous sur de vouloir supprimer ce lien?</p>

          <input type="checkbox" id="confirmedelete" name="confirmedelete" class="confirmedelete">
           <label for="confirmedelete">OUI</label>
 
             <div class="modal-footer">
               <button type="submit" name="deletelink"  id="deletelink" class="disabledBtn" disabled="true">Supprimer</button>
             </div>
          </form>
      </div>
    </div>
  </div>
</div>



<!-- ############################################## ***** Modal edit  ***** ########################################################## -->

 
<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit link</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="update_modal">
        
      </div>
    </div>
  </div>
</div>

<!-- ############################################## ***** Modal view langage ***** ########################################################## -->
  
  
<div class="modal fade" id="viewmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">link détails</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="link_detail">
        <div class="list_container">
          
      </div>
      <div class="modal-footer">
        <button type="button" class="closeBtn" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>


<?php endif ;?>


<?php 
include __DIR__. '/assets/includes/footer_admin.php';
?>