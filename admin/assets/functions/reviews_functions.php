<?php
//count du nombre de post
function countReviews(PDO $pdo)
{
  $query = $pdo->query("SELECT count(*) as nb from reviews");
  $data = $query->fetch();

  $count = $data['nb'];
  return $count;
}

//count du nombre de post publié
function countReviewsPublie(PDO $pdo)
{
  $query = $pdo->query("SELECT count(*) as nb from reviews WHERE est_publie = 1");
  $data = $query->fetch();

  $count = $data['nb'];
  return $count;
}

//count du nombre de post publié
function countReviewsNonPublie(PDO $pdo)
{
  $query = $pdo->query("SELECT count(*) as nb from reviews WHERE est_publie = 0");
  $data = $query->fetch();

  $count = $data['nb'];
  return $count;
}

//moyennes des notes
function notesMoyenne(PDO $pdo)
{
  $query = $pdo->query("SELECT ROUND(AVG(note),1) as nb from reviews");
  $data = $query->fetch();

  $count = $data['nb'];
  return $count;
}

//affichage des étoiles pour les notes
function stars($note)
{
  $stars = '';
  if ($note == 0) {
    $stars = '<i style="color:gold;" class="far fa-star"></i><i style="color:gold;" class="far fa-star"></i><i style="color:gold;" class="far fa-star"></i><i style="color:gold;" class="far fa-star"></i><i style="color:gold;" class="far fa-star"></i>';
  } elseif ($note == 1) {
    $stars = '<i style="color:gold;" class="fas fa-star"></i><i style="color:gold;" class="far fa-star"></i><i style="color:gold;" class="far fa-star"></i><i style="color:gold;" class="far fa-star"></i><i style="color:gold;" class="far fa-star"></i>';
  } elseif ($note == 2) {
    $stars = '<i style="color:gold;" class="fas fa-star"></i><i style="color:gold;" class="fas fa-star"></i><i style="color:gold;" class="far fa-star"></i><i style="color:gold;" class="far fa-star"></i><i style="color:gold;" class="far fa-star"></i>';
  } elseif ($note == 3) {
    $stars = '<i style="color:gold;" class="fas fa-star"></i><i style="color:gold;" class="fas fa-star"></i><i style="color:gold;" class="fas fa-star"></i><i style="color:gold;" class="far fa-star"></i><i style="color:gold;" class="far fa-star"></i>';
  } elseif ($note == 4) {
    $stars = '<i style="color:gold;" class="fas fa-star"></i><i style="color:gold;" class="fas fa-star"></i><i style="color:gold;" class="fas fa-star"></i><i style="color:gold;" class="fas fa-star"></i><i style="color:gold;" class="far fa-star"></i>';
  } else {
    $stars = '<i style="color:gold;" class="fas fa-star"></i><i style="color:gold;" class="fas fa-star"></i><i style="color:gold;" class="fas fa-star"></i><i style="color:gold;" class="fas fa-star"></i><i style="color:gold;" class="fas fa-star"></i>';
  }
  return $stars;
}
