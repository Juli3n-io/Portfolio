<?php
require_once __DIR__ . '/assets/config/bootstrap_admin.php';
require_once __DIR__ . '/assets/functions/reviews_functions.php';

$page_title = 'Reviews';
include __DIR__ . '/assets/includes/header_admin.php';
?>

<div id="notif"></div>


<section id="reviews_cards">
  <div class="dash__cards" id="cards">

    <div class="card__single card_visites">
      <div class="card__body">
        <i class="fas fa-folder-open"></i>
        <div>
          <h5>Tous les avis</h5>
          <h4><?= countReviews($pdo) ?></h4>
        </div>
      </div>
      <div class="card__footer">
        <input type="button" name="all" id="all" value="View All">
      </div>
    </div>

    <div class="card__single card_visites">
      <div class="card__body">
        <i class="far fa-eye"></i>
        <div>
          <h5>Publiés</h5>
          <h4><?= countReviewsPublie($pdo) ?></h4>
        </div>
      </div>
      <div class="card__footer">
        <input type="button" name="all_publie" id="all_publie" value="View All">
      </div>
    </div>

    <div class="card__single card_visites">
      <div class="card__body">
        <i class="far fa-eye-slash"></i>
        <div>
          <h5>Non Publiés</h5>
          <h4><?= countReviewsNonPublie($pdo) ?></h4>
        </div>
      </div>
      <div class="card__footer">
        <input type="button" name="non_publie" id="non_publie" value="View All">
      </div>
    </div>


    <div class="card__single card_visites">
      <div class="card__body">
        <i class="fas fa-star"></i>
        <div>
          <h5>Notes moyennes</h5>
          <h4><?= notesMoyenne($pdo) ?></h4>
        </div>
      </div>
      <div class="card__footer"> </div>
    </div>


  </div>
</section>


<section class="recent">
  <div class="recent__grid">
    <div class="team__card">
      <div class="card__header">
        <h3>Les avis</h3>
        <?php if ($Membre['statut'] == 0) : ?>
          <button id="add_review_modal">
            <i class="fas fa-plus"></i>
            Ajouter
          </button>
        <?php endif; ?>
      </div>

      <div class="table-responsive" id="pagination-data">

      </div>

    </div>
  </div>
</section>

</div>

<!-- ############################################## ***** Modal add  ***** ########################################################## -->
<?php if ($Membre['statut'] == 0) : ?>

  <div class="modal fade" id="addmodalreview" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ajouter une review</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post" enctype="multipart/form-data" id="add_review">

            <div class="mb-3">
              <label for="add_name">Nom : </label>
              <input type="text" name="add_name" id="add_name" class="form-control">
            </div>

            <div class="mb-3">
              <label for="add_company">Company : </label>
              <input type="text" name="add_company" id="add_company" class="form-control">
            </div>

            <div class="mb-3 mt-4">
              <label for="add_logo" class="form_label">Logo : </label>
              <input type="file" name="add_logo" id="add_logo" class="form-control">
            </div>

            <div class="mb-3 mt-4">
              <label for="add_contenu" class="form_label">Commentaire : </label>
              <textarea name="add_contenu" id="add_contenu" class="form-control"></textarea>
            </div>

            <div class="mb-3 mt-4">
              <label for="add_note" class="form_label">Note : </label>
              <select class="form-select" name="note" aria-label="">
                <option value="">Choisir une Note :</option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
            </div>

            <div class="mb-3 mt-4">
              <label for="add_url" class="form_label">Url : </label>
              <input type="text" name="add_url" id="add_url" class="form-control">
            </div>

            <div class="mb-3 mt-4">
              <label for="est_publié" class="form_label">Publié : </label>
              <div class="form-check">
                <input type="checkbox" id="est_publie" name="est_publie" class="confirmedelete">
                <label for="confirmedelete">OUI</label>
              </div>
            </div>


            <div class="modal-footer">
              <button type="submit" name="add_reviewbtn" class="addBtn">Ajouter</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- ############################################## ***** Modal delete  ***** ########################################################## -->


  <div class="modal fade" id="deletemodal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete Reviews</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="delete_reviews">
            <input type="hidden" name="delete_id" id="delete_id">
            <input type="hidden" name="delete_img" id="delete_img">

            <p>Etes vous sur de vouloir supprimer cette reviews?</p>

            <input type="checkbox" id="confirmedelete" name="confirmedelete" class="confirmedelete">
            <label for="confirmedelete">OUI</label>

            <div class="modal-footer">
              <button type="submit" name="deleteReviews" id="deleteReviews" class="disabledBtn" disabled="true">Supprimer</button>
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
          <h5 class="modal-title" id="">Edit Reviews</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="update_modal">

        </div>
      </div>
    </div>
  </div>

  <!-- ############################################## ***** Modal view reviews ***** ########################################################## -->


  <div class="modal fade" id="viewmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Review détails</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="reviews_detail">
          <div class="list_container">

          </div>
          <div class="modal-footer">
            <button type="button" class="closeBtn" data-bs-dismiss="modal">Fermer</button>
          </div>
        </div>
      </div>
    </div>


  <?php endif; ?>

  <?php
  include __DIR__ . '/assets/includes/footer_admin.php';
  ?>