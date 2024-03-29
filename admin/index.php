<?php
require_once __DIR__ . '/assets/config/bootstrap_admin.php';
require_once __DIR__ . '/assets/functions/index_functions.php';
require_once __DIR__ . '/assets/functions/posts_functions.php';
require_once __DIR__ . '/assets/functions/categories_functions.php';
require_once __DIR__ . '/assets/functions/stats_functions.php';


$page_title = '';
include __DIR__ . '/assets/includes/header_admin.php';
?>
<?php include __DIR__ . '/../global/includes/flash.php'; ?>

<div class="index_header">
  <p id="date"></p>
  <h1>Bonjour <?= $Membre['prenom'] ?></h1>
</div>

<section>
  <div class="dash__cards" id="cards">

    <div class="card__single">
      <div class="card__body">
        <i class="fas fa-eye"></i>
        <div>
          <h5>Visites</h5>
          <h4><?= getTotales_Visites($pdo) ?></h4>
        </div>
      </div>
      <div class="card__footer">
        <a href="stats">Voir les stats</a>
      </div>
    </div>

    <div class="card__single">
      <?php foreach (getBestPost($pdo) as $post) : ?>
        <div class="card__body">
          <?php if ($post["pics_id"] !== NULL) {
            echo "<td><div class='img-card' style='background-image: url(../global/uploads/" . getImg($pdo, $post['pics_id']) . ")'></div></td>";
          } else {
            echo "<td></td>";
          }
          ?>
          <div>
            <h5>Best Post</h5>
            <h4><?= $post['titre'] ?></h4>
          </div>
        </div>
      <?php endforeach; ?>

      <div class=" card__footer">
        <a href="posts">Voir les posts</a>
      </div>
    </div>

    <div class="card__single">
      <div class="card__body">
        <i class="fas fa-file-download"></i>
        <div>
          <h5>CV</h5>
          <h4><?= getDownloadCv($pdo) ?></h4>
        </div>
      </div>
      <div class="card__footer">
        <a href="docs">Voir les docs</a>
      </div>
    </div>

  </div>
</section>

<section class="recent recent_index">
  <div class="team__grid">
    <div class="team__card">
      <div class="card__header">
        <h3>Posts </h3>
        <?php if ($Membre['statut'] == 0) : ?>
          <button id="add_post_modal">
            <i class="fas fa-plus"></i>
            Ajouter
          </button>
        <?php endif; ?>
      </div>

      <div class="table-responsive" id="posts_table">
        <table>

          <thead>
            <tr>
              <th>ID</th>
              <th class="dnone">pics_id</th>
              <th>Img</th>
              <th>Titre</th>
              <th>Cat</th>
              <th>Clics</th>
              <?php if ($Membre['statut'] == 0) : ?>
                <th>Publié</th>
                <th>Actions</th>
              <?php else : ?>
                <th>Action</th>
              <?php endif; ?>
            </tr>
          </thead>



          <tbody>
            <?php foreach (getPostIndex($pdo) as $post) : ?>

              <tr>
                <td><?= $post['id_post'] ?></td>
                <td class="dnone"><?= $post['pics_id'] ?></td>
                <?php if ($post["pics_id"] !== NULL) {
                  echo "<td><div class='img-profil' style='background-image: url(../global/uploads/" . getImg($pdo, $post['pics_id']) . ")'></div></td>";
                } else {
                  echo "<td></td>";
                }
                ?>
                <td><?= $post['titre'] ?></td>
                <td>
                  <div class="td-cat"><?= getIcon($pdo, $post['categories_id']) ?></div>
                </td>
                <td><?= getClick($pdo, $post["pics_id"]) ?></td>

                <?php if ($Membre['statut'] == 0) : ?>

                  <td> <input type="checkbox" id="est_publie" name="est_publie" class="est_publie" value="<?= $post['est_publie'] ?>" <?= ($post['est_publie'] == 1) ? 'checked' : ''; ?>></td>

                  <td class="member_action">

                    <a href="<?= $post['url'] ?>" class="linkbtn"> </a>
                    <input type="button" class="viewbtn" name="view" id="<?= $post['id_post'] ?>"></input>
                    <input type="button" class="editbtn" id="<?= $post['id_post'] ?>"></input>
                    <input type="button" class="deletebtn"></input>

                  </td>
                <?php else : ?>

                  <td class="member_action">

                    <a href="<?= $post['url'] ?>" class="linkbtn"></a>

                  </td>

                <?php endif; ?>
              </tr>

            <?php endforeach; ?>
          </tbody>

        </table>
      </div> <!-- fin div table-responsive-->


    </div>


    <div class="summary">
      <div class="summary__card">

        <div class="summary__single">
          <i class="fas fa-street-view"></i>
          <div>
            <h5><?= $user_nbr; ?></h5>
            <small>Utilisateur(s) en ligne</small>
          </div>
        </div>

        <div class="summary__single">
          <i class="fas fa-calendar-day"></i>
          <div>
            <h5><?= getDayVisites($pdo); ?></h5>
            <small>Visites Aujourd'hui</small>
          </div>
        </div>

        <div class="summary__single">
          <i class="far fa-calendar-alt"></i>
          <div>
            <h5><?= getMonth_Visites($pdo) ?></h5>
            <small>Visites ce mois ci</small>
          </div>
        </div>

        <div class="summary__single">
          <i class="fas fa-globe-europe"></i>
          <div>
            <h5><?= getYear_Visites($pdo) ?></h5>
            <small>Visites cette année</small>
          </div>
        </div>

      </div>

      <div class="link__card">
        <div class="link-flex">

          <?php foreach (getBestLink($pdo) as $link) : ?>
            <div class='link-img'><i class="<?= $link['icone'] ?>"></i></div>

            <div class="link-info">
              <h5><i class="fas fa-link"></i> Best link</h5>
              <div>

                <div>

                  <div class="text-center">
                    <h4><?= $link['nb_clicks'] ?></h4>
                    <small><?= $link['titre'] ?></small>
                  </div>
                <?php endforeach; ?>
                </div>
              </div>


            </div>
        </div>

</section>

<?php if ($Membre['statut'] == 0) : ?>
  <!-- ############################################## ***** Modal add langage ***** ########################################################## -->

  <div class="modal fade" id="addmodal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ajouter un Post</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post" enctype="multipart/form-data" id="add_post">

            <input type="hidden" name="auteur_id" id="auteur_id" value="<?= $Membre['id_team_member'] ?>">

            <div class="mb-3 mt-4">
              <label for="add_titre_post">Titre : </label>
              <input type="text" name="add_titre_post" id="add_titre_post" class="form-control">
            </div>

            <div class="mb-3 mt-4">
              <label for="add_contenu_post" class="form_label">Contenu : </label>
              <textarea name="add_contenu_post" id="add_contenu_post" class="form-control">
              </textarea>
            </div>

            <div class="mb-3 mt-4">
              <label for="add_url_post" class="form_label">Url : </label>
              <input type="text" name="add_url_post" id="add_url_post" class="form-control">
            </div>

            <div class="mb-3 mt-4">
              <label for="add_img" class="form_label">Image : </label>
              <input type="file" name="add_img" id="add_img" class="form-control">
            </div>


            <div class="mb-3 mt-4">
              <label for="cat" class="form_label">Catégories : </label>
              <select class="form-select" name="cat" aria-label="">
                <option value="">Choisir une categorie :</option>
                <?php foreach (getCat($pdo) as $cat) : ?>
                  <option value="<?= $cat['id_categorie'] ?>"><?= $cat['titre'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>


            <div class="mb-3 mt-4">
              <label for="est publié" class="form_label">Publié : </label>
              <div class="form-check">
                <input type="checkbox" id="est_publie" name="est_publie" class="confirmedelete">
                <label for="confirmedelete">OUI</label>
              </div>
            </div>

            <div class="modal-footer">
              <button type="submit" name="add_post" id="addPostBtn" class="disabledBtn" disabled="true">Ajouter</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- ############################################## ***** Modal edit post ***** ########################################################## -->


  <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modifier Post</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="update_modal">
          <form action="" method="post" id="update_post" enctype="multipart/form-data">




            <div class="modal-footer">
              <button type="submit" name="update_cat" id="UpdateCatBtn" class="updateBtn">Modifier</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- ############################################## ***** Modal delete post ***** ########################################################## -->


  <div class="modal fade" id="deletemodal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete Post</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="delete_post">
            <input type="hidden" name="delete_id" id="delete_id">
            <input type="hidden" name="delete_img" id="delete_img">

            <p>Etes vous sur de vouloir supprimer ce post?</p>

            <input type="checkbox" id="confirmedelete" name="confirmedelete" class="confirmedelete">
            <label for="confirmedelete">OUI</label>

            <div class="modal-footer">
              <button type="submit" name="deletepost" id="deletepost" class="disabledBtn" disabled="true">Supprimer</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- ############################################## ***** Modal view post ***** ########################################################## -->


  <div class="modal fade" id="viewmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Post détails</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="post_detail">
          <div class="list_container">

          </div>
        </div>
      </div>
    </div>



  <?php endif; ?>

  <?php
  include __DIR__ . '/assets/includes/footer_admin.php';
  ?>