<?php
require_once __DIR__ . './../functions/experiences_functions.php';
require_once __DIR__ . './../functions/docs_functions.php';
?>

<section class="experience text-white" id="experience">
    <div class="container">
      <div class="row">

        <div class="col-sm-12 col-md-6">
          <div class="education">
            <h3>Formations</h3>
            <div class="education-details">
            
              <?php foreach(getEdu($pdo) as $edu): ?>

                <?php
                // changement format date
                $date_from = str_replace('/', '-', $edu['start_date']);
                $date_to = str_replace('/', '-', $edu['stop_date']);

                ?>

                <div class="education-item">
                  <h4><?= $edu['titre']?> à <a href="<?= $edu['url']?> "><?= $edu['school']?> </a></h4>
                  <div class="eduyear"><?= date('Y', strtotime($date_from))?> - <?= date('Y', strtotime($date_to))?></div>
                  <p>
                    <?= nl2br(mb_substr($edu['contenu'], 0, 150))?>
                  </p>
                  <a href="#" class="btn custom-link" id="<?= $edu['id_education']?>">...</a>
              </div>

              <?php endforeach;?>

            </div>
          </div>  
        </div>


        <div class="col-sm-12 col-md-6">
          <div class="work">
            <h3>Expériences</h3>
            <div class="work-details">

              <div class="work-item">
                <h4>Developpeur Web à <a href="#">Freelance</a></h4>
                <div class="eduyear">Depuis 2020</div>
                <p>
                  Création de site sur commande, pour des clients professionnels, sites e-commerce, sites vitrines, conseils SEO,...
                </p>
              </div>
            
              <div class="work-item">
                <h4>Développeur Stagiaire à <a href="#">IleoTech</a></h4>
                <div class="eduyear">2019 - 2020</div>
                <p>
                  Stage de fin de formation,
                  Travail sur des applications, utilsant principalement Angular, cordova et Ionic. Modification front des applications, recherche et correction de bugs.
                </p>
              </div>

              <div class="work-item">
                <h4>Spécialist à <a href="#">Apple Retail</a></h4>
                <div class="eduyear">2014 - Aujourd'hui</div>
                <p>
                  Susciter le dynamisme et l'enthousiasme autour Des produits, en proposant des solutions appropriées et en offrant à ses clients une expérience hors du commun</p>
              </div>


            </div>
          </div>  
        </div>

      </div>
      
    </div>
    <?php foreach(getDocs($pdo) as $doc): ?>
          <div class="download-btn">
              <a href="global/uploads/<?=$doc['fichier']?>" download class="btn custom-btn">Télécharger mon CV</a>
          </div>
      <?php endforeach;?>
  </section>

    <!-- ############################################## ***** Modal view ***** ########################################################## -->

    
<div class="modal fade" id="viewmodal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modal-dialog-centered">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-content" id="edu_detail">

      

      </div>  
    </div>
  </div>
</div>


