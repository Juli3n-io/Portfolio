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
            <h3>Toutes les stats </h3>
        </div>

        <div class="table-responsive">
          <table>

          <thead>
            <tr>
                <th>Jour</th>
                <th>Mois</th>
                <th>Année</th>
                <th>Visites</th>
            </tr>
          </thead>

          
              
          <tbody id="stats_table">
            
          </tbody>


        </table>
      </div> <!-- fin div table-responsive-->
       
    </div> <!-- fin div team card -->
  </div> <!-- fin div team grid -->


</section>

<div class="pagination" id="pagination">
  
</div>



<?php 
include __DIR__. '/assets/includes/footer_admin.php';
?>