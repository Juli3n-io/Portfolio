<?php
require_once __DIR__ . './../functions/docs_functions.php';
?>
<section class="about section" id="section1">

  <div class="container">

    <div class="row">

      <div class="col-md-12 text-center heading text-white">
        <h2>A Propos</h2>
      </div>


      <div class="row col-md-12 text-white gap">


        <div class=" col-sm-12 col-md-4 about-img">
          <img src="assets/img/profil.webp" alt="photo" loading="lazy" id="about-img">
        </div>

        <div class="col-sm-12 col-md-8">


          <h2 class="heading">A propos </h2>
          <p>Bonjour, </p>
          <p>Fraichement reconverti en développeur et intégrateur web après 10 ans dans le commerce,
            dont 6 années au service d’Apple,
            j’ai décidé en 2020 de me lancer en tant que
            freelance pour vous aider à créer les sites Internet de demain.
          </p>
          <p>
            Passionné par le développement front-end et les nouvelles technologies,
            mes créations associent design et modernité. Fort de mes précédentes expériences,
            je travaille aujourd’hui avec rigueur et minutie pour vous fournir une prestation de services
            haut de gamme et en adéquation avec vos besoins.
          </p>
          <p>
            En formation permanente pour pouvoir m’adapter aux demandes de mes clients,
            je travaille aujourd’hui sur différentes technologies telles que :
            HTML5 & CSS3, JavaScript, PHP, ainsi que
            des CMS comme Wordpress.
          </p>
          <p>
            N’hésitez pas à vous rendre sur mon portfolio pour découvrir les premiers sites réalisés dans le cadre de ma formation ou de mon activité.
          </p>
          <p>
            Et si nous commencions aujourd’hui, un nouveau projet ensemble ?
          </p>
          <p>Julien</p>

          <div class="tag">
            <ul>
              <li><span>HTML</span></li>
              <li><span>CSS</span></li>
              <li><span>Javascript</span></li>
              <li><span>Jquery</span></li>
              <li><span>PHP</span></li>
              <li><span>Wordpress</span></li>
            </ul>
          </div>

          <br>

          <?php foreach (getDocs($pdo) as $doc) : ?>
            <div class="download-btn">
              <a href="global/uploads/<?= $doc['fichier'] ?>" download class="btn custom-btn cv" id="<?= $doc['id_doc'] ?>">Télécharger mon CV</a>
            </div>
          <?php endforeach; ?>

        </div>




      </div>

    </div>


  </div>

</section>