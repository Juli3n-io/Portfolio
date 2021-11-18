<?php
require_once __DIR__ . './../functions/reviews_functions.php';
?>
<section class="reviews text-white section" id="section6">
  <div class="container">
    <div class="row">

      <div class="col-sm-12 text-center text-white heading">
        <h2>Avis</h2>
      </div>

      <div class="reviews_container">

        <div class="swiper">
          <div class="swiper-wrapper">

            <?php foreach (getReviews($pdo) as $reviews) : ?>

              <div class="swiper-slide">
                <div class="reviewsBox">
                  <i class="fas fa-quote-right quote"></i>
                  <div class="content">
                    <p><?= $reviews['contenu'] ?></p>
                  </div>
                  <div class="reviewsDetails">
                    <div class="imgBox">
                      <img src="global/uploads/<?= getLogo($pdo, $reviews['logo_id']) ?>" alt="logo">
                    </div>
                    <h3><?= $reviews['name'] ?> <span><?= $reviews['company'] ?></span></h3>
                  </div>
                </div>
              </div>

            <?php endforeach; ?>

          </div>
          <!-- Add Pagination -->
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </div>



  </div>
</section>