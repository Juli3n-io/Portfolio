<?php
require_once __DIR__ . './../functions/portfolio_functions.php';
?>

<section class="portfolio" id="portfolio">
    <div class="container">
      <div class="row">

        <div class="section-title text-center heading col-sm-12">
          <h2>Portfolio</h2>
        </div>

        <div class="part col-md-12">
          <div class="portfolio-nav col-sm-12" id="filter-button">
            <ul>
              <li data-filter="*" class="current">
                <span>Toutes les catégories</span>
              </li>

              <?php foreach(getCat($pdo) as $cat): ?>

                <li data-filter=".<?= $cat['class']?>" >
                  <span><?= $cat['titre_cat']?></span>
                </li>

              <?php endforeach;?>

            </ul>
          </div>

          <div class="project-gallery col-sm-12">
            <div class="portfolioContainer row">

            <?php foreach(getPost($pdo) as $post): ?>

              <div class="grid-item col-md-4 <?= $post['class']?>">
                <figure>
                  <img src="global/uploads/<?=$post['img']?>" alt="image site internet">
                  <figcaption class="fig-caption">
                    <a href="<?= $post['url']?>">
                      <i class="fa fa-search"></i>
                      <h5 class="title"><?= $post['titre']?></h5>
                    </a>
                    <span class="sub-title"><?= $post['titre_cat']?></span>
                  </figcaption>
                </figure>
              </div>

            <?php endforeach;?>

              

            </div>
          </div>

        </div>


      </div>
    </div>
  </section>