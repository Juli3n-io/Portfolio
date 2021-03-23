<?php
require_once __DIR__ . './../functions/skills_functions.php';
?>

<section class="skills text-white section" id="section4">

    <div class="container">

      <div class="row">

        <div class="col-md-12 text-center heading">
          <h2>Compétences</h2>
        </div>

        <div class="col-sm-12 col-md-6">
          <div class="mh-skills-inner">
            <div class="tech-skill">
              <h3>Compétences Techniques</h3>
                <div class="pro-skill-items">

                <?php foreach(gettechSkills($pdo) as $tech): ?>

                  <div class="candidatos">
                    <div class="parcial">
                      <div class="info">
                        <div class="skill-name"><?= $tech['titre'] ?></div>
                        <div class="pourcentage-num"><?= $tech['number'] ?>%</div>
                      </div>
                      <div class="progressBar">
                        <div class="pourcentagem" style="width: <?= $tech['number'] ?>%;"></div>
                      </div>
                    </div>
                  </div>
          
                <?php endforeach;?>

                </div>
            </div> 
          </div><!-- fin skill inner-->
        </div>


        <div class="col-sm-12 col-md-6">
          <div class="pro-skill" id="pro-skill">
            <h3>Compétences Professionnelles</h3>
            <ul class="mh-pro-progess">

            <?php foreach(getSoftSkills($pdo) as $skill): ?>

              <li>
                <div class="card" id="<?= $skill['class']?>" data-value="<?= $skill['number']?>">
                  <div class="circle">
                    <div class="bar"></div>
                    <div class="box" data-value="<?= $skill['number']?>">
                      <span><?= $skill['number']?> %</span>
                    </div>
                  </div>
                  <div class="text"><?= $skill['titre']?></div>
                </div>
              </li>

            <?php endforeach;?>
              
            </ul>
          </div>
        </div>


      </div>

    </div>

  </section>