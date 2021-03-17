<?php
require_once __DIR__ . './../functions/docs_functions.php';
?>
<section class="about" id="about">

    <div class="container">

      <div class="row">

        <div class="col-md-12 text-center heading text-white">
          <h2>A Propos</h2>
        </div>


        <div class="col-md-12 text-white gap">

        <div class="about-img"></div>

          <h2>A propos </h2>
          <p>Bonjour, </p>
          <p>Je suis Julien, 
            aprés plus de 10 ans dans le commerce, 
            dont 6 années aux services d'Apple, 
            je me suis fraichement reconvertis en développeur, 
            intégrateur web et 
            je me passionne pour le développement front-end. 
          </p>
          <p>
            Je cherche à associer le design et la technologie, 
            ainsi, mes 6 années chez Apple m'ont permis d'étre minutieux 
            dans mon travail, et de toujour chercher à me dépasser 
            pour tirer le meilleur de mes expériences. 
            Je continue aujourd'hui d'appliquer mes connaissances pour créer des sites internet attractifs.
          </p>
          <p>
            Je suis capable d'utiliser différentes 
            technologies tel que HTML5 & CSS3, 
            JavaScript, PHP, ainsi que 
             des CMS comme Wordpress ou Drupal.
          </p>
          <p>
            Vous trouverez sur mon site quelques projets 
            réalisés durant mes études ou durant mon temps libre.
          </p>

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

          <?php foreach(getDocs($pdo) as $doc): ?>
          <div class="download-btn">
              <a href="global/uploads/<?=$doc['fichier']?>" 
              download 
              class="btn custom-btn cv"
              id="<?= $doc['id_doc']?>">Télécharger mon CV</a>
          </div>
          <?php endforeach;?>
        </div> 

      </div>
      

    </div>

  </section>