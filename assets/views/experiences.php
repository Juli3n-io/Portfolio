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
                    <?= nl2br(mb_substr($edu['contenu'], 0, 150).'...')?>
                  </p>
                  <a href="#" class="btn link-education" id="<?= $edu['id_education']?>">En savoir plus</a>
              </div>

              <?php endforeach;?>

            </div>
          </div>  
        </div>


        <div class="col-sm-12 col-md-6">
          <div class="work">
            <h3>Expériences</h3>
            <div class="work-details">
            
              <?php foreach(getExe($pdo) as $exe): ?>

                <?php
                // changement format date
                $date_from = str_replace('/', '-', $exe['start_date']);
                $date_to = str_replace('/', '-', $exe['stop_date']);

                ?>

              <div class="work-item">
                <h4><?= $exe['titre']?> à <a href="<?= $exe['url']?> "><?= $exe['entreprise']?> </a></h4>
                <div class="eduyear"><?= date('Y', strtotime($date_from))?> - <?= ($exe['actuel'] == 1) ? 'à Aujourd\'hui' : date('Y', strtotime($date_to)) ;?></div>
                <p>
                  <?= nl2br(mb_substr($exe['contenu'], 0, 150).'...')?>
                </p>
                <a href="#" class="btn link-experience" id="<?= $exe['id_experience']?>">En savoir plus</a>
              </div>

            <?php endforeach;?>

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

    <!-- ############################################## ***** Modal view  education ***** ########################################################## -->

    
<div class="modal fade" id="viewmodaledu" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modal-dialog-centered">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-content" id="edu_detail">

      

      </div>  
    </div>
  </div>
</div>

<!-- ############################################## ***** Modal view  experience***** ########################################################## -->

    
<div class="modal fade" id="viewmodalexe" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modal-dialog-centered">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-content" id="exe_detail">

      

      </div>  
    </div>
  </div>
</div>


